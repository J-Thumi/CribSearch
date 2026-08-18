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
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\DB;

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

    /**
     * Helper to format any valid Kenyan phone number to 254XXXXXXXXX
     */
    private function formatKenyanPhoneNumber(?string $phone): ?string
    {
        if (!$phone) {
            return null;
        }

        // Remove non-numeric characters except plus
        $phone = preg_replace('/[^\d+]/', '', trim($phone));

        if (str_starts_with($phone, '+254')) {
            $phone = substr($phone, 1);
        } elseif (str_starts_with($phone, '0')) {
            $phone = '254' . substr($phone, 1);
        } elseif (preg_match('/^(7|1)\d{8}$/', $phone)) {
            $phone = '254' . $phone;
        }

        return $phone;
    }

   public function initiateIntaStkPush(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'phone_number'      => ['required', 'string', 'regex:/^(?:\+?254|0)?(7|1)\d{8}$/'],
            'text_phone_number' => ['nullable', 'string', 'regex:/^(?:\+?254|0)?(7|1)\d{8}$/'],
            'amount'            => ['required', 'numeric', 'min:1'],
            'house_id'          => ['required', 'string'],
        ]);

        // Sanitize phone numbers for IntaSend and SMS operations
        $formattedMpesaPhone = $this->formatKenyanPhoneNumber($validated['phone_number']);
        $formattedTextPhone  = $this->formatKenyanPhoneNumber($validated['text_phone_number'] ?? $validated['phone_number']);

        try {
            return DB::transaction(function () use ($validated, $formattedMpesaPhone, $formattedTextPhone) {
                $user = auth('sanctum')->user() ?? auth()->user();
                $apiRef = 'House-' . $validated['house_id'] . '-' . time();

                // 1. Create the HouseUnlock record
                $houseUnlock = HouseUnlock::create([
                    'phone_number'      => $formattedMpesaPhone,
                    'text_phone_number' => $formattedTextPhone,
                    'house_id'          => $validated['house_id'],
                    'user_id'           => $user?->id,
                ]);

                // 2. Trigger IntaSend STK Push
                $response = $this->intasend->initiateStkPush(
                    amount: $validated['amount'],
                    phoneNumber: $formattedMpesaPhone,
                    apiRef: $apiRef,
                    email: $user?->email,
                    name: $user?->name
                );

                // Convert object to array for safe traversal
                $responseArray = json_decode(json_encode($response), true);

                // Extract tracking ID safely across response variants
                $trackingId = $responseArray['invoice']['invoice_id'] 
                            ?? $responseArray['tracking_id'] 
                            ?? $responseArray['invoice_id'] 
                            ?? null;

                if (!$trackingId) {
                    throw new \Exception('Payment gateway response missing tracking ID.');
                }

                // 3. Save invoice record
                IntaSendInvoice::create([
                    'user_id'         => $user?->id,
                    'house_unlock_id' => $houseUnlock->id,
                    'tracking_id'     => $trackingId,
                    'api_ref'         => $apiRef,
                    'phone_number'    => $formattedMpesaPhone,
                    'amount'          => $validated['amount'],
                    'status'          => 'PENDING',
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'STK push sent to your phone. Please enter your M-Pesa PIN.',
                    'data'    => $response,
                ]);
            });

        } catch (RequestException $e) {
            Log::error('IntaSend HTTP error:', ['exception' => $e->getMessage()]);

            $formattedErrors = [];
            $message = 'Failed to initiate M-Pesa payment. Please check your details.';

            if ($e->hasResponse()) {
                $body = json_decode((string) $e->getResponse()->getBody(), true);

                // Parse IntaSend API response error structure
                if (isset($body['errors']) && is_array($body['errors'])) {
                    foreach ($body['errors'] as $err) {
                        $attr = $err['attr'] ?? 'phone_number';
                        $detail = $err['detail'] ?? 'Invalid value provided.';
                        $formattedErrors[$attr][] = $detail;
                    }
                    $message = $body['errors'][0]['detail'] ?? $message;
                } elseif (isset($body['detail'])) {
                    $message = $body['detail'];
                    $formattedErrors['general'][] = $body['detail'];
                }
            }

            return response()->json([
                'success' => false,
                'message' => $message,
                'errors'  => $formattedErrors,
            ], 400);

        } catch (\GuzzleHttp\Exception\RequestException | \GuzzleHttp\Exception\ClientException $e) {
            Log::error('IntaSend API error:', ['exception' => $e->getMessage()]);

            $formattedErrors = [];
            $message = 'Payment processing failed. Please try again.';

            if ($e->hasResponse()) {
                $responseBody = (string) $e->getResponse()->getBody();
                $body = json_decode($responseBody, true);

                // Handle IntaSend 401 Unauthorized / Invalid API Token
                if ($e->getResponse()->getStatusCode() === 401) {
                    $message = 'Payment system configuration error: Invalid API token or keys.';
                    $formattedErrors['general'][] = 'Authentication failed with the payment gateway.';
                } 
                // Handle IntaSend validation / client errors (400)
                elseif (isset($body['errors']) && is_array($body['errors'])) {
                    foreach ($body['errors'] as $err) {
                        $attr = $err['attr'] ?? 'general';
                        $detail = $err['detail'] ?? 'Invalid value provided.';
                        $formattedErrors[$attr][] = $detail;
                    }
                    $message = $body['errors'][0]['detail'] ?? $message;
                } elseif (isset($body['detail'])) {
                    $message = $body['detail'];
                    $formattedErrors['general'][] = $body['detail'];
                }
            }

            return response()->json([
                'success' => false,
                'message' => $message,
                'errors'  => $formattedErrors,
            ], 400);

        } catch (\Exception $e) {
            Log::error('STK push initiation failed:', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred: ' . $e->getMessage(),
                'errors'  => [
                    'general' => [$e->getMessage()]
                ]
            ], 400);
        }
    }
    }