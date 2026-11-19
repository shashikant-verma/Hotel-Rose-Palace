<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Room;
use App\Models\RoomType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $deluxeType = RoomType::where('slug', 'deluxe-family-room')->first()
            ?? RoomType::where('name', 'Deluxe Family Room')->first();

        $executiveType = RoomType::where('slug', 'executive-room')->first()
            ?? RoomType::where('name', 'Executive Room')->first();

        if (!$deluxeType || !$executiveType) {
            return;
        }

        // Restore any soft-deleted rooms in the 101-115 range
        Room::withTrashed()
            ->whereIn('room_number', ['101','102','103','104','105','106','107','108','109','110','111','112','113','114','115'])
            ->restore();

        // 1. Configure Deluxe Family Rooms (101-105) - 5 physical rooms
        $deluxeImages = [
            '101' => 'images/rooms/WhatsApp Image 2026-11-17 at 6.53.49 PM.jpeg',
            '102' => 'images/rooms/hotel-rose-palace-room-102-door.jpeg',
            '103' => 'images/rooms/WhatsApp Image 2026-11-17 at 6.54.15 PM.jpeg',
            '104' => 'images/rooms/WhatsApp Image 2026-11-17 at 6.54.26 PM.jpeg',
            '105' => 'images/rooms/WhatsApp Image 2026-11-17 at 6.54.38 PM.jpeg',
        ];

        foreach ($deluxeImages as $roomNum => $imgPath) {
            $room = Room::withTrashed()->where('room_number', $roomNum)->first();
            if ($room) {
                $room->update([
                    'room_type_id' => $deluxeType->id,
                    'category' => 'Deluxe Family Room',
                    'current_price' => 1200.00,
                    'price_per_night' => 1200.00,
                    'image_path' => $imgPath,
                    'deleted_at' => null,
                ]);
            } else {
                Room::create([
                    'room_number' => $roomNum,
                    'room_type_id' => $deluxeType->id,
                    'category' => 'Deluxe Family Room',
                    'floor' => 1,
                    'current_price' => 1200.00,
                    'price_per_night' => 1200.00,
                    'max_guests' => 3,
                    'is_available' => true,
                    'status' => 'available',
                    'housekeeping_status' => 'clean',
                    'image_path' => $imgPath,
                ]);
            }
        }

        // 2. Configure Executive Rooms (106-115) - 10 physical rooms
        $executiveImages = [
            '106' => 'images/rooms/WhatsApp Image 2026-11-17 at 6.54.48 PM.jpeg',
            '107' => 'images/rooms/WhatsApp Image 2026-11-17 at 6.55.00 PM.jpeg',
            '108' => 'images/rooms/hotel-rose-palace-room-view-window.jpeg',
            '109' => 'images/rooms/hotel-rose-palace-room-wardrobe-mirror.jpeg',
            '110' => 'images/rooms/hotel-rose-palace-room-warm-cove.jpeg',
            '111' => 'images/rooms/hotel-rose-palace-room-gold-molding.jpeg',
            '112' => 'images/rooms/WhatsApp Image 2026-11-17 at 6.54.03 PM.jpeg',
            '113' => 'images/rooms/hotel-rose-palace-room-113.jpeg',
            '114' => 'images/rooms/WhatsApp Image 2026-11-17 at 7.22.49 PM.jpeg',
            '115' => 'images/rooms/WhatsApp Image 2026-11-17 at 7.23.41 PM.jpeg',
        ];

        foreach ($executiveImages as $roomNum => $imgPath) {
            $room = Room::withTrashed()->where('room_number', $roomNum)->first();
            if ($room) {
                $room->update([
                    'room_type_id' => $executiveType->id,
                    'category' => 'Executive Room',
                    'current_price' => 1100.00,
                    'price_per_night' => 1100.00,
                    'image_path' => $imgPath,
                    'deleted_at' => null,
                ]);
            } else {
                Room::create([
                    'room_number' => $roomNum,
                    'room_type_id' => $executiveType->id,
                    'category' => 'Executive Room',
                    'floor' => 1,
                    'current_price' => 1100.00,
                    'price_per_night' => 1100.00,
                    'max_guests' => 3,
                    'is_available' => true,
                    'status' => 'available',
                    'housekeeping_status' => 'clean',
                    'image_path' => $imgPath,
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Safe no-op down to preserve operational room integrity
    }
};
