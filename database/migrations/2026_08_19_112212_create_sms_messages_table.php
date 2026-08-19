<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sms_messages', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('house_id')
                ->nullable()
                ->constrained('houses')
                ->nullOnDelete();

            $table->foreignId('purchase_id')
                ->nullable()
                ->constrained('bitika_purchases')
                ->nullOnDelete();

            $table->string('phone_number', 20);
            $table->string('type')->default('house_unlock');
            $table->unique(
                ['purchase_id', 'type'],
                'sms_purchase_type_unique'
            );

            $table->text('message');

            $table->string('status')
                ->default('pending')
                ->index();

            $table->unsignedTinyInteger('attempts')
                ->default(0);

            $table->timestamp('sent_at')
                ->nullable();

            $table->timestamp('next_attempt_at')
                ->nullable()
                ->index();

            $table->text('error_message')
                ->nullable();

            $table->json('provider_response')
                ->nullable();

            $table->timestamps();

            $table->index([
                'status',
                'next_attempt_at',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sms_messages');
    }
};