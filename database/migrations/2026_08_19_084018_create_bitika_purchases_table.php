<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bitika_purchases', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('house_id')
                ->constrained('houses')
                ->cascadeOnDelete();

            $table->foreignId('house_unlock_id')
                ->constrained('house_unlock')
                ->cascadeOnDelete();

            $table->foreignId('bitika_payment_id')
                ->constrained('bitika_payments')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->index('bitika_payment_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bitika_purchases');
    }
};