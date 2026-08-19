<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class UjumbeSMS
{
    /**
     * Send SMS via UjumbeSMS API.
     *
     * @param string|array $phoneNumber Single number or array/comma-separated numbers
     * @param string $message The message body
     * @param string|null $senderId Optional custom sender ID
     * @return array
     * @throws Exception
     */
    public function send($phoneNumber, string $message, ?string $senderId = null): array
    {
        $config = config('ujumbesms');

        $baseUrl  = rtrim($config['base_url'] ?? 'http://ujumbesms.co.ke/api/messaging', '/');
        $apiKey   = $config['api_key'] ?? '';
        $email    = $config['email'] ?? '';
        $sender   = $senderId ?? $config['sender_id'] ?? 'UjumbeSMS';

        // Format phone numbers as comma-separated string if passed as array
        $formattedNumbers = is_array($phoneNumber) ? implode(',', $phoneNumber) : $phoneNumber;

        // Construct body according to UjumbeSMS spec
        $payload = [
            'data' => [
                [
                    'message_bag' => [
                        'numbers' => $formattedNumbers,
                        'message' => $message,
                        'sender'  => $sender,
                    ]
                ]
            ]
        ];

        try {
            // Perform HTTP POST with auth headers
            $response = Http::withHeaders([
                'X-Authorization' => $apiKey,
                'email'           => $email,
                'Content-Type'    => 'application/json',
                'Accept'          => 'application/json',
            ])->post($baseUrl, $payload);

            // Process HTTP response
            if ($response->failed()) {
                Log::error('UjumbeSMS HTTP Error', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
                throw new Exception("UjumbeSMS HTTP Request Failed with status: " . $response->status());
            }

            $data = $response->json();

            // Handle API level response codes
            $code = $data['status']['code'] ?? null;
            $type = $data['status']['type'] ?? null;

            // Check for API Error 1002 or failure statuses
            if ($code === '1002' || $type === 'error' || $type === 'failed') {
                $description = $data['status']['description'] ?? 'Authentication or API processing error occurred.';
                
                Log::error("UjumbeSMS API Error [Code {$code}]: {$description}", [
                    'response' => $data,
                    'numbers'  => $formattedNumbers,
                ]);

                throw new Exception("UjumbeSMS API Error [{$code}]: {$description}");
            }

            // Success case (Code 1008)
            Log::info("UjumbeSMS sent successfully", [
                'code'       => $code,
                'recipients' => $data['meta']['recipients'] ?? null,
                'credits'    => $data['meta']['available_credits'] ?? null,
            ]);

            return $data;

        } catch (Exception $e) {
            Log::channel('single')->error('UjumbeSMS Service Failure: ' . $e->getMessage());
            throw $e;
        }
    }
}