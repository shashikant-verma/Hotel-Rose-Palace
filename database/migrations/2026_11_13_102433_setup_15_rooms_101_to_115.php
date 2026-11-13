<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use App\Models\Room;
use App\Models\RoomType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Delete all existing rooms first
        Room::query()->delete();
        
        // Get the two room types
        $deluxeType = RoomType::where('name', 'Deluxe Family Room')->first();
        $executiveType = RoomType::where('name', 'Executive Room')->first();
        
        if (!$deluxeType || !$executiveType) {
            throw new \Exception('Required room types not found. Please ensure "Deluxe Family Room" and "Executive Room" exist.');
        }

        // Create 15 rooms (101-115)
        // 8 Deluxe Family Rooms: 101-108
        // 7 Executive Rooms: 109-115
        
        $roomsData = [
            // Deluxe Family Rooms (101-108)
            ['room_number' => '101', 'room_type_id' => $deluxeType->id, 'floor' => 1, 'is_available' => true, 'status' => 'available'],
            ['room_number' => '102', 'room_type_id' => $deluxeType->id, 'floor' => 1, 'is_available' => true, 'status' => 'available'],
            ['room_number' => '103', 'room_type_id' => $deluxeType->id, 'floor' => 1, 'is_available' => true, 'status' => 'available'],
            ['room_number' => '104', 'room_type_id' => $deluxeType->id, 'floor' => 1, 'is_available' => true, 'status' => 'available'],
            ['room_number' => '105', 'room_type_id' => $deluxeType->id, 'floor' => 1, 'is_available' => true, 'status' => 'available'],
            ['room_number' => '106', 'room_type_id' => $deluxeType->id, 'floor' => 1, 'is_available' => true, 'status' => 'available'],
            ['room_number' => '107', 'room_type_id' => $deluxeType->id, 'floor' => 1, 'is_available' => true, 'status' => 'available'],
            ['room_number' => '108', 'room_type_id' => $deluxeType->id, 'floor' => 1, 'is_available' => true, 'status' => 'available'],
            
            // Executive Rooms (109-115)
            ['room_number' => '109', 'room_type_id' => $executiveType->id, 'floor' => 1, 'is_available' => true, 'status' => 'available'],
            ['room_number' => '110', 'room_type_id' => $executiveType->id, 'floor' => 1, 'is_available' => true, 'status' => 'available'],
            ['room_number' => '111', 'room_type_id' => $executiveType->id, 'floor' => 1, 'is_available' => true, 'status' => 'available'],
            ['room_number' => '112', 'room_type_id' => $executiveType->id, 'floor' => 1, 'is_available' => true, 'status' => 'available'],
            ['room_number' => '113', 'room_type_id' => $executiveType->id, 'floor' => 1, 'is_available' => true, 'status' => 'available'],
            ['room_number' => '114', 'room_type_id' => $executiveType->id, 'floor' => 1, 'is_available' => true, 'status' => 'available'],
            ['room_number' => '115', 'room_type_id' => $executiveType->id, 'floor' => 1, 'is_available' => true, 'status' => 'available'],
        ];

        foreach ($roomsData as $room) {
            $roomType = $room['room_type_id'] === $deluxeType->id ? $deluxeType : $executiveType;
            
            Room::create([
                'room_type_id' => $room['room_type_id'],
                'room_number' => $room['room_number'],
                'category' => $roomType->name,
                'floor' => $room['floor'],
                'current_price' => $roomType->base_price,
                'price_per_night' => $roomType->base_price,
                'max_guests' => $roomType->max_occupancy,
                'is_available' => $room['is_available'],
                'status' => $room['status'],
                'housekeeping_status' => 'clean',
                'image_path' => null,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Delete all rooms (optional)
        Room::query()->delete();
    }
};
