<?php

namespace App\Http\Controllers;

use App\Models\BitikaPayment;
use App\Models\HouseUnlock;
use App\Models\BitikaPurchase;
use App\Services\BitikaPaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Exception;



class BitikaStkPushController extends Controller
{

   
    protected BitikaPaymentService $bitika;

    public function __construct(BitikaPaymentService $bitika)
    {
        $this->bitika = $bitika;
    }

    public function initiateStkPush(Request $request): JsonResponse
    {
        Log::info('Bitika STK Push Initiated', [
            'phone'   => $request->phone_number,
            'house_id' => $request->house_id,
            'user_id' => auth()->id() ?? 'guest',
        ]);

        try {
            $validated = $request->validate([
                'phone_number' => [
                    'required',
                    'string',
                    'regex:/^(254|\+254|0)?(7|1)\d{8}$/',
                ],

                'text_phone_number' => [
                    'required',
                    'string',
                    'regex:/^(254|\+254|0)?(7|1)\d{8}$/',
                ],

                'house_id' => [
                    'required',
                    'integer',
                    'exists:houses,id',
                ],
            ]);

            /*
            * Generate the idempotency key BEFORE calling Bitika.
            *
            * If the HTTP request times out and we retry,
            * the same key should be reused.
            */
            $idempotencyKey = (string) Str::uuid();
            $amount = (int) config('services.bitika.fixed_amount', 3030);

            /*
            * Create our local payment records first.
            */
            $payment = DB::transaction(function () use (
                $validated,
                $idempotencyKey,
                $amount
            ) {
                $houseUnlock = HouseUnlock::create([
                    'phone_number'     => $validated['phone_number'],
                    'text_phone_number' => $validated['text_phone_number'],
                    'house_id'         => $validated['house_id'],
                    'user_id'          => auth()->id(),
                ]);

                $payment = BitikaPayment::create([
                    'user_id' => auth()->id(),
                    'house_id' => $validated['house_id'],
                    'house_unlock_id' => $houseUnlock->id,

                    'idempotency_key' => $idempotencyKey,

                    'amount_kes' => $amount,
                    'phone_number' => $validated['phone_number'],

                    'lightning_address' => config(
                        'services.bitika.lightning_address'
                    ),

                    'status' => BitikaPayment::STATUS_PROCESSING,
                ]);

                BitikaPurchase::create([
                    'user_id' => auth()->id(),
                    'house_id' => $validated['house_id'],
                    'house_unlock_id' => $houseUnlock->id,
                    'bitika_payment_id' => $payment->id,
                ]);

                return $payment;
            });

            /*
            * Initiate Bitika payment.
            */
            try {
                Log::info('Calling Bitika collect endpoint', [
                    'payment_id' => $payment->id,
                    'phone' => $validated['phone_number'],
                    'amount' => $amount,
                    'idempotency_key' => $idempotencyKey,
                ]);

                $bitikaResponse = $this->bitika->collect(
                    $validated['phone_number'],
                    $amount,
                    $idempotencyKey
                );

            } catch (Exception $e) {

                $payment->update([
                    'status' => BitikaPayment::STATUS_FAILED,
                    'failed_at' => now(),
                    'metadata' => [
                        'error' => $e->getMessage(),
                    ],
                ]);

                Log::error('Bitika STK Push Failed', [
                    'payment_id' => $payment->id,
                    'error' => $e->getMessage(),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Unable to initiate payment. Please try again.',
                ], 502);
            }

            /*
            * Bitika should return something similar to:
            *
            * {
            *     "transaction_code": "SBX-1A2B3C4D",
            *     "status": "processing"
            * }
            */
            $responseData = $bitikaResponse['response'] ?? $bitikaResponse;

            $status = strtolower(
                $responseData['status'] ?? ''
            );

            $transactionCode = $responseData['transaction_code'] ?? null;

            /*
            * The initial successful state is "processing".
            *
            * Do NOT require "fulfilled" here.
            * Fulfillment happens asynchronously via webhook.
            */
            if (
                empty($transactionCode) ||
                $status !== BitikaPayment::STATUS_PENDING
            ) {
                $payment->update([
                    'status' => BitikaPayment::STATUS_FAILED,
                    'failed_at' => now(),
                    'metadata' => $responseData,
                ]);

                Log::warning('Unexpected Bitika initiation response', [
                    'payment_id' => $payment->id,
                    'response' => $responseData,
                ]);

                return response()->json([
                    'success' => false,
                    'message' => $responseData['message']
                        ?? 'Bitika payment initiation failed.',
                    'details' => $responseData,
                ], 400);
            }

            /*
            * Save Bitika transaction code.
            */
            $payment->update([
                'transaction_code' => $transactionCode,
                'status' => $status,
                'metadata' => $responseData,
            ]);

            Log::info('Bitika STK Push Dispatched Successfully', [
                'payment_id' => $payment->id,
                'transaction_code' => $transactionCode,
                'status' => $status,
                'phone' => $validated['phone_number'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'STK Push initiated successfully.',
                'transaction_code' => $transactionCode,
                'status' => $status,
                'phone_number' => $validated['phone_number'],
                'amount' => $amount,
            ], 200);

        } catch (ValidationException $e) {

            Log::notice('Bitika STK Push Validation Failed', [
                'errors' => $e->errors(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Validation error.',
                'errors' => $e->errors(),
            ], 422);

        } catch (Exception $e) {

            Log::error('Unhandled Bitika STK Push Exception', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred while processing your payment.',
            ], 500);
        }
    }
}
