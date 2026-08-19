<?php

namespace App\Http\Controllers;

use App\Jobs\SendHouseUnlockSms;
use App\Models\BitikaPayment;
use App\Models\BitikaPurchase;
use App\Models\SmsMessage;
use App\Services\UjumbeSMS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class BitikaWebhookController extends Controller
{
    /**
     * Handle Bitika webhook events.
     *
     * POST /api/bitika/webhook
     */
    public function handle(Request $request)
    {
        Log::info('Bitika request', $request->all());
        /*
         * IMPORTANT:
         *
         * Bitika signs:
         *
         * timestamp.raw_body
         *
         * Therefore we MUST obtain the raw body before parsing JSON.
         */
        $rawBody = $request->getContent();

        // To be uncommented when Bitika webhook signature verification is implemented

        // $signature = $request->header('X-Bitika-Signature');

        // if (!$this->verifySignature($rawBody, $signature)) {
        //     Log::warning('Invalid Bitika webhook signature', [
        //         'ip' => $request->ip(),
        //     ]);

        //     return response()->json([
        //         'message' => 'Invalid signature.',
        //     ], 401);
        // }

        $payload = json_decode($rawBody, true);

        if (!is_array($payload)) {
            Log::error('Invalid Bitika webhook JSON');

            return response()->json([
                'message' => 'Invalid JSON payload.',
            ], 400);
        }

        Log::info('Bitika webhook received', [
            'event' => $payload['event'] ?? null,
            'event_id' => $payload['id'] ?? null,
        ]);

        $event = $payload['event'] ?? null;
        $eventId = $payload['id'] ?? null;
        $data = $payload['data'] ?? [];

        if (empty($event)) {
            Log::warning('Bitika webhook missing event');

            return response()->json([
                'message' => 'Missing event.',
            ], 400);
        }

        if (empty($data)) {
            Log::warning('Bitika webhook missing data', [
                'event' => $event,
            ]);

            return response()->json([
                'message' => 'Missing event data.',
            ], 400);
        }

        $transactionCode = $data['transaction_code'] ?? null;

        if (!$transactionCode) {
            Log::warning('Bitika webhook missing transaction code', [
                'event' => $event,
            ]);

            return response()->json([
                'message' => 'Missing transaction code.',
            ], 400);
        }

        /*
         * Find our payment using Bitika's transaction code.
         */
        $payment = BitikaPayment::where(
            'transaction_code',
            $transactionCode
        )->first();

        if (!$payment) {
            Log::warning('Bitika payment not found', [
                'transaction_code' => $transactionCode,
                'event' => $event,
            ]);

            /*
             * Return 200 so Bitika doesn't continuously retry
             * an event for a transaction we don't know about.
             */
            return response()->json([
                'status' => 'payment_not_found',
            ]);
        }

        /*
         * Webhooks can be delivered more than once.
         *
         * If we have already processed this exact event,
         * acknowledge it without doing anything again.
         */
        if (
            $eventId &&
            $payment->last_event_id === $eventId
        ) {
            Log::info('Duplicate Bitika webhook ignored', [
                'payment_id' => $payment->id,
                'event_id' => $eventId,
            ]);

            return response()->json([
                'status' => 'already_processed',
            ]);
        }

        /*
         * Store common transaction data.
         */
        $updateData = [
            'last_event' => $event,
            'last_event_id' => $eventId,
            'last_webhook_at' => now(),

            'metadata' => $payload,

            'status' => $data['status'] ?? $payment->status,

            'sats' => $data['sats'] ?? $payment->sats,

            'payment_hash' => $data['payment_hash']
                ?? $payment->payment_hash,

            'mpesa_receipt' => $data['mpesa_receipt']
                ?? $payment->mpesa_receipt,

            'decline_reason' => $data['decline_reason']
                ?? $payment->decline_reason,
        ];

        /*
         * Handle the event.
         */
        switch ($event) {

            case 'transaction.updated':

                return $this->handleTransactionUpdated(
                    $payment,
                    $updateData
                );

            case 'payment.completed':

                return $this->handlePaymentCompleted(
                    $payment,
                    $updateData
                );

            case 'payment.failed':

                return $this->handlePaymentFailed(
                    $payment,
                    $updateData
                );

            default:

                Log::info('Unknown Bitika event ignored', [
                    'event' => $event,
                    'transaction_code' => $transactionCode,
                ]);

                /*
                 * Still store the event.
                 */
                $payment->update($updateData);

                return response()->json([
                    'status' => 'ignored',
                    'event' => $event,
                ]);
        }
    }

    /**
     * transaction.updated
     *
     * Expected status:
     * processing_payment
     */
    private function handleTransactionUpdated(
        BitikaPayment $payment,
        array $updateData
    ) {
        /*
         * Don't downgrade a fulfilled payment.
         */
        if ($payment->isSuccessful()) {
            Log::info(
                'Ignoring transaction.updated for fulfilled payment',
                [
                    'payment_id' => $payment->id,
                ]
            );

            return response()->json([
                'status' => 'already_fulfilled',
            ]);
        }

        $payment->update($updateData);

        Log::info('Bitika payment is being processed', [
            'payment_id' => $payment->id,
            'transaction_code' => $payment->transaction_code,
            'status' => $payment->status,
        ]);

        return response()->json([
            'status' => 'processed',
        ]);
    }

    /**
     * payment.completed
     *
     * This is the ONLY event that unlocks the house.
     */
    private function handlePaymentCompleted(
        BitikaPayment $payment,
        array $updateData
    ) {
        /*
         * If already fulfilled, don't send SMS again.
         */
        if ($payment->isSuccessful()) {
            Log::info('Payment already fulfilled', [
                'payment_id' => $payment->id,
            ]);

            return response()->json([
                'status' => 'already_processed',
            ]);
        }

        DB::transaction(function () use (
            $payment,
            $updateData
        ) {
            $payment->update([
                ...$updateData,

                'status' => BitikaPayment::STATUS_FULFILLED,

                'paid_at' => now(),
            ]);
        });

        Log::info('Bitika payment fulfilled', [
            'payment_id' => $payment->id,
            'transaction_code' => $payment->transaction_code,
            'amount_kes' => $payment->amount_kes,
            'sats' => $payment->sats,
            'mpesa_receipt' => $payment->mpesa_receipt,
        ]);

        /*
         * Find the purchase associated with this payment.
         */
        $purchase = BitikaPurchase::with([
            'houseUnlock.house',
        ])
            ->where(
                'bitika_payment_id',
                $payment->id
            )
            ->first();

        if (!$purchase) {
            Log::error('Bitika Purchase not found for fulfilled Bitika payment', [
                'payment_id' => $payment->id,
                'transaction_code' => $payment->transaction_code,
            ]);

            /*
             * Payment is still fulfilled.
             * We don't tell Bitika the payment failed simply
             * because our local purchase record is missing.
             */
            return response()->json([
                'status' => 'fulfilled_purchase_not_found',
            ]);
        }

        $this->sendHouseInfo($purchase);

        return response()->json([
            'status' => 'success',
            'payment_id' => $payment->id,
            'transaction_code' => $payment->transaction_code,
            'user_notified' => true,
        ]);
    }

    /**
     * payment.failed
     */
    private function handlePaymentFailed(
        BitikaPayment $payment,
        array $updateData
    ) {
        /*
         * Don't change a successful payment to failed.
         */
        if ($payment->isSuccessful()) {
            Log::warning(
                'Received failed event for already fulfilled payment',
                [
                    'payment_id' => $payment->id,
                    'transaction_code' => $payment->transaction_code,
                ]
            );

            return response()->json([
                'status' => 'already_fulfilled',
            ]);
        }

        $status = $updateData['status']
            ?? BitikaPayment::STATUS_FAILED;

        if (!in_array($status, [
            BitikaPayment::STATUS_FAILED,
            BitikaPayment::STATUS_PAYMENT_FAILED,
        ], true)) {
            $status = BitikaPayment::STATUS_FAILED;
        }

        $payment->update([
            ...$updateData,

            'status' => $status,

            'failed_at' => now(),
        ]);

        Log::warning('Bitika payment failed', [
            'payment_id' => $payment->id,
            'transaction_code' => $payment->transaction_code,
            'status' => $status,
            'reason' => $payment->decline_reason,
        ]);

        return response()->json([
            'status' => 'processed',
        ]);
    }

    /**
     * Verify Bitika HMAC-SHA256 webhook signature.
     */
    private function verifySignature(
        string $rawBody,
        ?string $signatureHeader
    ): bool {
        if (!$signatureHeader) {
            return false;
        }

        $secret = config('services.bitika.webhook_secret');

        if (!$secret) {
            Log::error('Bitika webhook secret is not configured.');

            return false;
        }

        /*
         * Header:
         *
         * X-Bitika-Signature:
         * t=1783625207,v1=9f86d081...
         */
        $parts = [];

        foreach (explode(',', $signatureHeader) as $part) {
            $pair = explode('=', trim($part), 2);

            if (count($pair) === 2) {
                $parts[$pair[0]] = $pair[1];
            }
        }

        $timestamp = $parts['t'] ?? null;
        $signature = $parts['v1'] ?? null;

        if (!$timestamp || !$signature) {
            return false;
        }

        /*
         * Prevent replay attacks.
         *
         * Bitika specifies a five-minute window.
         */
        if (abs(time() - (int) $timestamp) > 300) {
            Log::warning('Bitika webhook timestamp outside allowed window', [
                'timestamp' => $timestamp,
            ]);

            return false;
        }

        /*
         * Bitika signs:
         *
         * timestamp.raw_body
         */
        $signedPayload = "{$timestamp}.{$rawBody}";

        $expectedSignature = hash_hmac(
            'sha256',
            $signedPayload,
            $secret
        );

        /*
         * Constant-time comparison.
         */
        return hash_equals(
            $expectedSignature,
            $signature
        );
    }

    /**
     * Save the house information to the sms message table from where actual sending will happen.
     */
    public function sendHouseInfo(BitikaPurchase $purchase): void
    {
        $houseUnlock = $purchase->houseUnlock;

        if (!$houseUnlock) {
            Log::error('No house unlock record found for purchase', [
                'purchase_id' => $purchase->id,
                'user_id' => $purchase->user_id,
                'house_id' => $purchase->house_id,
            ]);

            return;
        }

        $house = $houseUnlock->house;

        if (!$house) {
            Log::error('Associated house missing', [
                'house_unlock_id' => $houseUnlock->id,
                'house_id' => $houseUnlock->house_id,
            ]);

            return;
        }

        $caretakerPhone = $house->caretaker_phone;
        $lat = $house->lat;
        $long = $house->long;
        $scoutPhone = $house->contact_number;

        $location = "https://www.google.com/maps?q={$lat},{$long}";
        $navigationUrl = $houseUnlock->navigation_url;

        /*
        * Build the SMS message.
        */
        if (!$caretakerPhone || !$lat || !$long) {

            Log::error('Caretaker phone or location missing', [
                'house_id' => $house->id,
                'caretaker_phone' => $caretakerPhone,
                'lat' => $lat,
                'long' => $long,
            ]);

            $message =
                "Your house is now unlocked. However, "
                . "caretaker phone number or location is missing. "
                . "Please contact support for assistance. "
                . "Scout Phone: {$scoutPhone}";

        } else {

            $caretakerNumber = is_array($caretakerPhone)
                ? ($caretakerPhone[0]['phone'] ?? null)
                : $caretakerPhone;

            $message = "CribSearch: Your house location is ready. "
            . "Get directions here: {$navigationUrl}";
            }

        /*
        * Create the SMS only once for this purchase.
        *
        * This protects against duplicate Bitika webhooks.
        */
        $smsMessage = SmsMessage::firstOrCreate(
            [
                'purchase_id' => $purchase->id,
                'type' => 'house_unlock',
            ],
            [
                'user_id' => $purchase->user_id,
                'house_id' => $house->id,
                'phone_number' => $houseUnlock->text_phone_number,
                'message' => $message,
                'status' => SmsMessage::STATUS_PENDING,
                'next_attempt_at' => now(),
            ]
        );

        /*
        * Only dispatch the job when the SMS record was newly created.
        */
        if ($smsMessage->wasRecentlyCreated) {

            SendHouseUnlockSms::dispatch($smsMessage);

            Log::info('House unlock SMS queued.', [
                'sms_id' => $smsMessage->id,
                'purchase_id' => $purchase->id,
                'user_id' => $purchase->user_id,
                'house_id' => $house->id,
                'phone_number' => $houseUnlock->text_phone_number,
            ]);

            return;
        }

        /*
        * If it already exists, don't dispatch another job.
        */
        Log::info('House unlock SMS already exists. Skipping duplicate dispatch.', [
            'sms_id' => $smsMessage->id,
            'purchase_id' => $purchase->id,
            'status' => $smsMessage->status,
        ]);
    }
}