<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bitika_payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('house_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('house_unlock_id')
                ->nullable()
                ->constrained('house_unlock')
                ->nullOnDelete();

            /*
             * Bitika identifiers
             */
            $table->string('transaction_code')
                ->nullable()
                ->unique();

            $table->uuid('idempotency_key')
                ->unique();

            /*
             * Payment information
             */
            $table->unsignedBigInteger('amount_kes');

            $table->string('phone_number', 20);

            $table->string('lightning_address');

            /*
             * Bitika status:
             *
             * processing
             * processing_payment
             * fulfilled
             * failed
             * payment_failed
             */
            $table->string('status')
                ->default('processing')
                ->index();

            /*
             * Bitika transaction details
             */
            $table->unsignedBigInteger('sats')
                ->nullable();

            $table->string('payment_hash')
                ->nullable();

            $table->string('mpesa_receipt')
                ->nullable();

            $table->text('decline_reason')
                ->nullable();

            /*
             * Webhook/event information
             */
            $table->string('last_event')
                ->nullable();

            $table->string('last_event_id')
                ->nullable()
                ->index();

            $table->timestamp('paid_at')
                ->nullable();

            $table->timestamp('failed_at')
                ->nullable();

            $table->timestamp('last_webhook_at')
                ->nullable();

            /*
             * Keep the complete latest Bitika response/event
             * for reconciliation/debugging.
             */
            $table->json('metadata')
                ->nullable();

            $table->timestamps();

            $table->index([
                'phone_number',
                'status',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bitika_payments');
    }
};