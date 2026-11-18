<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use App\Models\RoomType;
use App\Models\Amenity;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Attach existing verified amenities to Deluxe Family and Executive Room types.
     */
    public function up(): void
    {
        $deluxe = RoomType::where('slug', 'deluxe-family-room')->first();
        $executive = RoomType::where('slug', 'executive-room')->first();

        if ($deluxe) {
            // Television (8), Private Bathroom (9), Air Conditioning (7), Free Wi-Fi (1), Room Service (5)
            $amenityIds = Amenity::whereIn('name', ['Television', 'Private Bathroom', 'Air Conditioning', 'Free Wi-Fi', 'Room Service'])->pluck('id');
            $deluxe->amenities()->syncWithoutDetaching($amenityIds);
        }

        if ($executive) {
            // Television (8), Private Bathroom (9), Air Conditioning (7), Free Wi-Fi (1)
            $amenityIds = Amenity::whereIn('name', ['Television', 'Private Bathroom', 'Air Conditioning', 'Free Wi-Fi'])->pluck('id');
            $executive->amenities()->syncWithoutDetaching($amenityIds);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Keep non-destructive
    }
};
