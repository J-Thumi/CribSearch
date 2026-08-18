<?php

namespace App\Http\Controllers;

use App\Models\HouseUnlock;
use App\Models\IntaSendInvoice;
use App\Models\Invoice;
use App\Models\Purchase;
use App\Services\BitikaService;
use App\Services\BlinkService;
use App\Services\IntasendService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Exception;

class StkPushController extends Controller
{
    protected IntasendService $intasend;
    protected BlinkService $blink;
    protected BitikaService $bitika;

    public function __construct(IntasendService $intasend, BlinkService $blink, BitikaService $bitika)
    {
        $this->intasend = $intasend;
        $this->blink = $blink;
        $this->bitika = $bitika;
    }

    public function initiateStkPush(Request $request): JsonResponse
    {
        // This will be used if Bitika is the payment processor. If Intasend is used, this method can be removed or modified accordingly.


        Log::info('STK Push Initiated', [
            'phone'  => $request->phone_number,
            'amount' => $request->amount,
            'user_id'=> auth()->id() ?? 'guest',
        ]);

        try {
            // 1. Validate incoming request
            $validated = $request->validate([
                'phone_number' => ['required', 'string', 'regex:/^(254|\+254|0)?(7|1)\d{8}$/'],
                'text_phone_number' => ['required', 'string', 'regex:/^(254|\+254|0)?(7|1)\d{8}$/'],
                'amount'       => ['required', 'numeric', 'min:10', 'max:10000'],
            ]);

            HouseUnlock::create([
                'phone_number' => $validated['phone_number'],
                'text_phone_number' => $validated['text_phone_number'],
                'house_id'     => $request->input('house_id'),
                'user_id'      => auth()->id() ?? null,
            ]);

            // 2. Create Blink Lightning Invoice
            try {
                Log::info('Creating Blink Lightning Invoice', ['amount' => $validated['amount']]);
                
                $invoice = $this->blink->createInvoice($validated['amount'], 84600);

                $invoice = Invoice::create([
                    'blink_id'      => $invoice['id'] ?? null,
                    'payment_hash' => $invoice['payment_hash'] ?? null,
                    'payment_request' => $invoice['payment_request'] ?? null,
                    'amount_msat'          => $validated['amount'],
                    'status'          => Invoice::STATUS_PENDING,                    
                ]);

                Purchase::create([
                    'user_id'    => auth()->id() ?? null,
                    'invoice_id' => $invoice->id,
                    'house_id'   => $request->input('house_id'),
                ]);

                $bolt11String = is_array($invoice) 
                    ? ($invoice['payment_request'] ?? null) 
                    : ($invoice->payment_request ?? null);

                if (empty($bolt11String)) {
                    Log::error('Blink Service returned empty payment request', ['invoice_response' => $invoice]);
                    throw new Exception('Failed to generate a valid Lightning invoice from Blink.');
                }

            } catch (Exception $e) {
                Log::error('Blink Invoice Creation Failed', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Unable to generate payment invoice: ' . $e->getMessage(),
                ], 502);
            }

            // 3. Initiate M-Pesa STK Push via Bitika
            $bitikaRes = $this->bitika->collectInvoice(
                $validated['phone_number'],
                $bolt11String
            );

            // Extract nested response array safely
            $responseData = $bitikaRes['response'] ?? $bitikaRes;

            // Determine if request succeeded ('processing', 'success', or 'pending')
            $status = strtolower($responseData['status'] ?? '');
            $isSuccessful = in_array($status, ['processing', 'success', 'pending']);

            // 4. Handle Bitika response failure
            if (!$isSuccessful) {
                Log::warning('Bitika STK Push Declined or Failed', [
                    'phone'    => $validated['phone_number'],
                    'response' => $responseData,
                ]);

                return response()->json([
                    'success' => false,
                    'message' => $responseData['message'] ?? 'Bitika STK push request failed.',
                    'details' => $responseData,
                ], 400);
            }

            // 5. Success response
            Log::info('STK Push Request Dispatched Successfully', [
                'transaction_code' => $responseData['transaction_code'] ?? null,
                'status'           => $status,
                'phone'            => $validated['phone_number'],
            ]);

            return response()->json([
                'success'          => true,
                'message'          => $responseData['message'] ?? 'STK Push initiated successfully.',
                'transaction_code' => $responseData['transaction_code'] ?? null,
                'status'           => $responseData['status'] ?? 'processing',
                'phone_number'     => $validated['phone_number'],
                'amount'           => $validated['amount'],
                'bitika_response'  => $responseData,
            ], 200);

        } catch (ValidationException $e) {
            Log::notice('STK Push Validation Failed', ['errors' => $e->errors()]);

            return response()->json([
                'success' => false,
                'message' => 'Validation error.',
                'errors'  => $e->errors(),
            ], 422);

        } catch (Exception $e) {
            Log::error('Unhandled Exception during STK Push Processing', [
                'error' => $e->getMessage(),
                'file'  => $e->getFile(),
                'line'  => $e->getLine(),
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage() ?: 'An unexpected error occurred while processing your request.',
            ], 500);
        }
    }

    public function initiateIntaStkPush(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'phone_number'      => 'required|string',
            'text_phone_number' => 'nullable|string',
            'amount'            => 'required|numeric|min:1',
            'house_id'          => 'required|string',
        ]);

        try {
            $user = auth('sanctum')->user() ?? auth()->user();
            $apiRef = 'House-' . $validated['house_id'] . '-' . time();

            // 1. Create the HouseUnlock record
            $houseUnlock = HouseUnlock::create([
                'phone_number'      => $validated['phone_number'],
                'text_phone_number' => $validated['text_phone_number'] ?? $validated['phone_number'],
                'house_id'          => $validated['house_id'],
                'user_id'           => $user?->id,
            ]);
            

            // 2. Trigger IntaSend STK Push
            $response = $this->intasend->initiateStkPush(
                amount: $validated['amount'],
                phoneNumber: $validated['phone_number'],
                apiRef: $apiRef,
                email: $user?->email,
                name: $user?->name
            );

            // Cast object/stdClass to array
            $responseArray = (array) $response;

            // Extract tracking ID safely
            $trackingId = $responseArray['invoice']->invoice_id 
                        ?? $responseArray['invoice']['invoice_id'] 
                        ?? $responseArray['tracking_id'] 
                        ?? $responseArray['invoice_id'] 
                        ?? $response->invoice->invoice_id 
                        ?? null;

            if (!$trackingId) {
                throw new \Exception('Failed to retrieve tracking ID from IntaSend response.');
            }

            // 3. Save invoice record
            IntaSendInvoice::create([
                'user_id'         => $user?->id,
                'house_unlock_id' => $houseUnlock->id,
                'tracking_id'     => $trackingId,
                'api_ref'         => $apiRef,
                'phone_number'    => $validated['phone_number'],
                'amount'          => $validated['amount'],
                'status'          => 'PENDING',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'STK push sent to your phone. Please enter your M-Pesa PIN.',
                'data'    => $response,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }
    }