<?php

namespace App\Services;

use IntaSend\IntaSendPHP\Collection;
use Exception;
use Illuminate\Support\Facades\Log;

class IntasendService
{
    protected Collection $collection;

    public function __construct()
    {
        $credentials = [
            'token'           => config('services.intasend.secret_key'),
            'publishable_key' => config('services.intasend.publishable_key'),
            'test'            => config('services.intasend.test_mode', true),
        ];

        $this->collection = new Collection();
        $this->collection->init($credentials);
    }

    /**
     * Initiate an M-Pesa STK Push payment prompt.
     *
     * @param float|int $amount
     * @param string $phoneNumber Must be in 2547XXXXXXXX or 2541XXXXXXXX format
     * @param string|null $apiRef Unique identifier (e.g. House #101 / Order ID)
     * @param string|null $email
     * @param string|null $name
     * @return array
     * @throws Exception
     */
    public function initiateStkPush(
        float|int $amount,
        string $phoneNumber,
        ?string $apiRef = null,
        ?string $email = null,
        ?string $name = null
    ): array {
        // Sanitize phone number to 254 format
        $formattedPhone = $this->formatPhoneNumber($phoneNumber);

        try {
            $response = $this->collection->mpesa_stk_push(
                $amount = $amount,
                $phone_number = $formattedPhone,
                $api_ref = $apiRef ?? 'Order-' . time(),
                $name = $name ?? '',
                $email = $email ?? ''
            );

            Log::info('IntaSend STK Push initiated successfully', [
                'phone'   => $formattedPhone,
                'amount'  => $amount,
                'api_ref' => $apiRef,
            ]);

            return (array) $response;
        } catch (Exception $e) {
            Log::error('IntaSend STK Push Failed', [
                'error' => $e->getMessage(),
                'phone' => $formattedPhone,
            ]);

            throw new Exception('Payment initiation failed: ' . $e->getMessage());
        }
    }

    /**
     * Format Kenyan phone numbers to the required 254XXXXXXXXX format.
     */
    protected function formatPhoneNumber(string $phone): string
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (str_starts_with($phone, '0')) {
            return '254' . substr($phone, 1);
        }

        if (str_starts_with($phone, '7') || str_starts_with($phone, '1')) {
            return '254' . $phone;
        }

        return $phone;
    }
}