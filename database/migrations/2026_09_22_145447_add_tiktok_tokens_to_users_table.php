<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('tiktok_open_id')->nullable();
            $table->text('tiktok_access_token')->nullable();
            $table->text('tiktok_refresh_token')->nullable();
            $table->timestamp('tiktok_token_expires_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('tiktok_open_id');
            $table->dropColumn('tiktok_access_token');
            $table->dropColumn('tiktok_refresh_token');
            $table->dropColumn('tiktok_token_expires_at');
        });
    }
};
