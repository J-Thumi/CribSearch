<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('intasend_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('house_unlock_id')->nullable()->constrained('house_unlock')->cascadeOnDelete();
            $table->string('tracking_id')->unique()->comment('IntaSend invoice/tracking ID');
            $table->string('api_ref')->nullable();
            $table->string('phone_number');
            $table->decimal('amount', 10, 2);
            $table->string('status')->default('PENDING'); // PENDING, COMPLETE, FAILED, CANCELLED
            $table->string('mpesa_reference')->nullable()->comment('M-Pesa Receipt Number');
            $table->string('client_ip')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('intasend_invoices');
    }
};