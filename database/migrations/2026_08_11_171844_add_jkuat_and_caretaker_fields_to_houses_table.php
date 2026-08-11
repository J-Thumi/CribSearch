<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('houses', function (Blueprint $table) {
            // Nearest JKUAT Gate (Gate A, Gate B, Gate C, Highfield Gate, Juja Main Gate, etc.)
            $table->string('nearest_gate')->nullable()->after('long'); 
            
            // Estimated time to campus (e.g., "5 mins walk", "10 mins by bodaboda")
            $table->string('estimated_time_to_school')->nullable()->after('nearest_gate');
            
            // Approximate Area / Neighborhood (e.g., "Gate A - Gachororo", "Gate C - Kimbo")
            $table->string('approximate_area')->nullable()->after('estimated_time_to_school');
            
            // Direct Caretaker Contact Info
            $table->string('caretaker_name')->nullable()->after('approximate_area');
            $table->string('caretaker_phone')->nullable()->after('caretaker_name');
        });
    }

    public function down(): void
    {
        Schema::table('houses', function (Blueprint $table) {
            $table->dropColumn([
                'nearest_gate',
                'estimated_time_to_school',
                'approximate_area',
                'caretaker_name',
                'caretaker_phone',
            ]);
        });
    }
};