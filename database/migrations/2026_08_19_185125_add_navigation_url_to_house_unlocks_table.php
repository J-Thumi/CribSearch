<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('house_unlock', function (Blueprint $table) {
            $table->text('navigation_url')
                ->nullable()
                ->after('house_id');
        });
    }

    public function down(): void
    {
        Schema::table('house_unlock', function (Blueprint $table) {
            $table->dropColumn('navigation_url');
        });
    }
};