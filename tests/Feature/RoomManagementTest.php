<?php

namespace Tests\Feature;

use App\Models\Room;
use App\Models\RoomType;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class RoomManagementTest extends TestCase
{
    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    /**
     * Test admin can view room types list
     */
    public function test_admin_can_view_room_types_list(): void
    {
        RoomType::factory(3)->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.room-types.index'));

        $response->assertStatus(200);
    }

    /**
     * Test admin can create new room type
     */
    public function test_admin_can_create_room_type(): void
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.room-types.store'), [
                'name' => 'Deluxe Suite',
                'description' => 'A luxurious suite',
                'base_price' => 5000,
                'max_guests' => 4,
            ]);

        $this->assertDatabaseHas('room_types', [
            'name' => 'Deluxe Suite',
        ]);
    }

    /**
     * Test admin can update room type
     */
    public function test_admin_can_update_room_type(): void
    {
        $roomType = RoomType::factory()->create();

        $response = $this->actingAs($this->admin)
            ->put(route('admin.room-types.update', $roomType), [
                'name' => 'Updated Suite',
                'description' => 'Updated description',
                'base_price' => 6000,
                'max_guests' => 5,
            ]);

        $this->assertDatabaseHas('room_types', [
            'id' => $roomType->id,
            'name' => 'Updated Suite',
        ]);
    }

    /**
     * Test admin can delete room type
     */
    public function test_admin_can_delete_room_type(): void
    {
        $roomType = RoomType::factory()->create();

        $this->actingAs($this->admin)
            ->delete(route('admin.room-types.destroy', $roomType));

        $this->assertDatabaseMissing('room_types', [
            'id' => $roomType->id,
        ]);
    }

    /**
     * Test admin can upload room images
     */
    public function test_admin_can_upload_room_images(): void
    {
        $room = Room::factory()->create();
        $file = UploadedFile::fake()->image('room.jpg', 800, 600);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.rooms.store'), [
                'room_type_id' => $room->room_type_id,
                'room_number' => 'R101',
                'floor' => 1,
                'status' => 'available',
                'images' => [$file],
            ]);

        $this->assertDatabaseHas('room_images', [
            'room_id' => $room->id,
        ]);
    }

    /**
     * Test unauthenticated user cannot access room management
     */
    public function test_unauthenticated_user_cannot_access_room_management(): void
    {
        $response = $this->get(route('admin.room-types.index'));

        $response->assertRedirect(route('admin.login'));
    }
}
