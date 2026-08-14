<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\ConnectionException;
use Exception;

class BitikaService
{
    protected string $baseUrl;
    protected ?string $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.bitika.base_url', 'https://api.bitika.xyz/api/v1');
        $this->apiKey = config('services.bitika.api_key');
    }

    /**
     * Standardize phone number format (254XXXXXXXXX).
     */
    private function formatPhoneNumber(string $phone): string
    {
        $cleaned = preg_replace('/\D/', '', $phone);

        if (str_starts_with($cleaned, '0')) {
            return '254' . substr($cleaned, 1);
        }

        if (str_starts_with($cleaned, '7') || str_starts_with($cleaned, '1')) {
            return '254' . $cleaned;
        }

        return $cleaned;
    }

    /**
     * Collect invoice payment via Bitika.
     *
     * @param string $phone
     * @param string $lightningInvoice BOLT11 invoice string (must start with 'lnbc')
     * @return array
     * @throws Exception
     */
    public function collectInvoice(string $phone, string $lightningInvoice): array
    {
        $formattedPhone = $this->formatPhoneNumber($phone);
        $invoiceTrimmed = trim($lightningInvoice);

        // Pre-flight validation
        if (empty($invoiceTrimmed) || !str_starts_with(strtolower($invoiceTrimmed), 'lnbc')) {
            Log::warning('Bitika Service: Invalid BOLT11 invoice provided', [
                'phone'   => $formattedPhone,
                'invoice' => substr($invoiceTrimmed, 0, 15) . '...',
            ]);
            throw new Exception('Invalid BOLT11 Lightning invoice string provided.');
        }

        $payload = [
            'phone'            => $formattedPhone,
            'lightningInvoice' => $invoiceTrimmed,
        ];

        Log::info('Bitika Service: Initiating Invoice Collection', [
            'phone'         => $formattedPhone,
            'invoice_prefix'=> substr($invoiceTrimmed, 0, 15) . '...',
        ]);

        try {
            $request = Http::timeout(15)
                ->acceptJson()
                ->contentType('application/json');

            if (!empty($this->apiKey)) {
                $request->withToken($this->apiKey);
            }

            $response = $request->post("{$this->baseUrl}/xwift/collect-invoice", $payload);

            if ($response->failed()) {
                Log::error('Bitika Service: HTTP Request Failed', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                    'phone'  => $formattedPhone,
                ]);

                $errorMessage = $response->json('message');

                if (is_array($errorMessage)) {
                    $errorMessage = implode(', ', $errorMessage);
                }

                $errorMessage = $errorMessage 
                    ?: ($response->json('error') ?: "Bitika API returned HTTP status {$response->status()}.");

                throw new Exception($errorMessage);
            }

            $responseData = $response->json();

            Log::info('Bitika Service: Payment Request Dispatched Successfully', [
                'phone'    => $formattedPhone,
                'response' => $responseData,
            ]);

            return $responseData;

        } catch (ConnectionException $e) {
            Log::critical('Bitika Service: Connection/Timeout Error', [
                'message' => $e->getMessage(),
                'phone'   => $formattedPhone,
            ]);
            throw new Exception('Unable to reach Bitika payment gateway. Please try again later.');
        } catch (Exception $e) {
            // Re-throw custom exceptions for controller handling
            throw $e;
        }
    }
}