<?php

namespace App\Jobs;

use App\Models\SmsMessage;
use App\Services\UjumbeSMS;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class SendHouseUnlockSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Number of times Laravel should attempt this job.
     */
    public int $tries = 5;

    /**
     * Retry delays in seconds.
     */
    public array $backoff = [
        10,
        30,
        60,
        300,
    ];

    /**
     * Maximum execution time.
     */
    public int $timeout = 30;

    public function __construct(
        public SmsMessage $smsMessage
    ) {
    }

    /**
     * Send the SMS.
     */
    public function handle(UjumbeSMS $ujumbe): void
    {
        /*
         * Refresh the model because the database may have
         * changed since the job was dispatched.
         */
        $this->smsMessage->refresh();

        /*
         * Don't send an SMS that has already been successfully sent.
         */
        if ($this->smsMessage->status === SmsMessage::STATUS_SENT) {
            Log::info('SMS already sent. Skipping.', [
                'sms_id' => $this->smsMessage->id,
            ]);

            return;
        }

        /*
         * Increment attempts and mark as processing.
         */
        $this->smsMessage->update([
            'status' => SmsMessage::STATUS_PROCESSING,
            'attempts' => $this->smsMessage->attempts + 1,
            'error_message' => null,
        ]);

        try {

            Log::info('Sending SMS through UjumbeSMS.', [
                'sms_id' => $this->smsMessage->id,
                'purchase_id' => $this->smsMessage->purchase_id,
                'phone_number' => $this->smsMessage->phone_number,
                'attempt' => $this->smsMessage->attempts,
            ]);

            /*
             * UjumbeSMS::send() returns the decoded API response.
             */
            $result = $ujumbe->send(
                $this->smsMessage->phone_number,
                $this->smsMessage->message
            );

            /*
             * Store the provider response.
             *
             * Requires a `provider_response` JSON column
             * on sms_messages.
             */
            $this->smsMessage->update([
                'status' => SmsMessage::STATUS_SENT,
                'sent_at' => now(),
                'error_message' => null,
                'provider_response' => $result,
            ]);

            Log::info('SMS sent successfully.', [
                'sms_id' => $this->smsMessage->id,
                'purchase_id' => $this->smsMessage->purchase_id,

                // Useful information from Ujumbe's response
                'provider_code' => $result['status']['code'] ?? null,
                'provider_type' => $result['status']['type'] ?? null,
                'recipients' => $result['meta']['recipients'] ?? null,
                'credits' => $result['meta']['available_credits'] ?? null,
            ]);

        } catch (Throwable $e) {

            /*
             * Mark the attempt as failed.
             */
            $this->smsMessage->update([
                'status' => SmsMessage::STATUS_FAILED,
                'error_message' => $e->getMessage(),
            ]);

            Log::error('SMS sending failed.', [
                'sms_id' => $this->smsMessage->id,
                'purchase_id' => $this->smsMessage->purchase_id,
                'phone_number' => $this->smsMessage->phone_number,
                'attempt' => $this->smsMessage->attempts,
                'error' => $e->getMessage(),
            ]);

            /*
             * VERY IMPORTANT:
             *
             * Re-throw the exception so Laravel's queue system
             * knows the job failed and will retry it according
             * to $tries and $backoff.
             */
            throw $e;
        }
    }

    /**
     * Called after all retry attempts have failed.
     */
    public function failed(Throwable $exception): void
    {
        $this->smsMessage->refresh();

        $this->smsMessage->update([
            'status' => SmsMessage::STATUS_FAILED,
            'error_message' => $exception->getMessage(),
        ]);

        Log::critical('SMS permanently failed after all retries.', [
            'sms_id' => $this->smsMessage->id,
            'purchase_id' => $this->smsMessage->purchase_id,
            'phone_number' => $this->smsMessage->phone_number,
            'attempts' => $this->smsMessage->attempts,
            'error' => $exception->getMessage(),
        ]);
    }
}