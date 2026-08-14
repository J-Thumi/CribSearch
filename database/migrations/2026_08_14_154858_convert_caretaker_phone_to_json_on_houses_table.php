<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // First, convert existing phone numbers into valid JSON strings.
        DB::table('houses')
            ->whereNotNull('caretaker_phone')
            ->where('caretaker_phone', '!=', '')
            ->orderBy('id')
            ->chunkById(100, function ($houses) {
                foreach ($houses as $house) {
                    // If it is already valid JSON, don't convert it again.
                    if (json_decode($house->caretaker_phone, true) !== null) {
                        continue;
                    }

                    $contacts = [
                        [
                            'name' => $house->caretaker_name ?: 'Building Caretaker',
                            'phone' => $house->caretaker_phone,
                        ],
                    ];

                    DB::table('houses')
                        ->where('id', $house->id)
                        ->update([
                            'caretaker_phone' => json_encode($contacts),
                        ]);
                }
            });

        // Now change the column type to JSON.
        Schema::table('houses', function (Blueprint $table) {
            $table->json('caretaker_phone')
                ->nullable()
                ->change();
            $table->text('description')->nullable();
        });
    }

    public function down(): void
    {
        // Convert JSON contacts back to the old string format.
        DB::table('houses')
            ->whereNotNull('caretaker_phone')
            ->orderBy('id')
            ->chunkById(100, function ($houses) {
                foreach ($houses as $house) {
                    $contacts = json_decode($house->caretaker_phone, true);

                    if (is_array($contacts) && !empty($contacts)) {
                        $firstContact = $contacts[0];

                        DB::table('houses')
                            ->where('id', $house->id)
                            ->update([
                                'caretaker_phone' => $firstContact['phone'] ?? null,
                            ]);
                    }
                }
            });

        Schema::table('houses', function (Blueprint $table) {
            $table->string('caretaker_phone')
                ->nullable()
                ->change();
        });
    }
};