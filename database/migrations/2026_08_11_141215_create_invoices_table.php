<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('blink_id')->unique()->comment('ID from Blink API');
            $table->string('payment_hash')->unique();
            $table->text('payment_request'); // The bolt11 invoice string
            $table->bigInteger('amount_msat'); // Amount in millisatoshis
            $table->string('status')->default('pending'); // pending, paid, expired
            $table->string('full_name')->nullable();
            $table->string('blink_client_ip')->nullable();
            $table->string('satoshis_paid')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};