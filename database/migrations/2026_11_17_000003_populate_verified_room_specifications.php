<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Populate verified room specifications from master hotel documentation.
     */
    public function up(): void
    {
        // Deluxe Family Room
        DB::table('room_types')
            ->where('slug', 'deluxe-family-room')
            ->update([
                'bed_type' => '1 King Bed',
                'bedroom_count' => 1,
                'living_room_count' => 1,
                'bathroom_count' => 1,
                'size_sqft' => 154,
                'max_occupancy' => 3,
            ]);

        // Executive Room
        DB::table('room_types')
            ->where('slug', 'executive-room')
            ->update([
                'bed_type' => '1 King Bed',
                'bedroom_count' => 1,
                'living_room_count' => 0,
                'bathroom_count' => 1,
                'max_occupancy' => 3,
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Keep non-destructive
    }
};
