<?php

namespace Tests\Unit;

use App\Models\Amenity;
use App\Models\Enquiry;
use App\Models\Room;
use App\Models\RoomImage;
use App\Models\RoomType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModelRelationshipsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test user can have multiple enquiries
     */
    public function test_enquiry_belongs_to_room_type(): void
    {
        $roomType = RoomType::factory()->create();
        $enquiry = Enquiry::factory()->create(['room_type_id' => $roomType->id]);

        $this->assertInstanceOf(RoomType::class, $enquiry->roomType);
    }

    /**
     * Test room type has many rooms
     */
    public function test_room_type_has_many_rooms(): void
    {
        $roomType = RoomType::factory()->create();
        Room::factory(3)->create(['room_type_id' => $roomType->id]);

        $this->assertEquals(3, $roomType->rooms()->count());
    }

    /**
     * Test room has many images
     */
    public function test_room_has_many_images(): void
    {
        $room = Room::factory()->create();
        RoomImage::factory(5)->create(['room_id' => $room->id]);

        $this->assertEquals(5, $room->images()->count());
    }

    /**
     * Test room type has many amenities
     */
    public function test_room_type_has_many_amenities(): void
    {
        $roomType = RoomType::factory()->create();
        Amenity::factory(4)->create();

        // Attach amenities
        $roomType->amenities()->attach(Amenity::all());

        $this->assertEquals(4, $roomType->amenities()->count());
    }

    /**
     * Test amenity belongs to many room types
     */
    public function test_amenity_belongs_to_many_room_types(): void
    {
        $amenity = Amenity::factory()->create();
        $roomTypes = RoomType::factory(3)->create();

        foreach ($roomTypes as $roomType) {
            $amenity->roomTypes()->attach($roomType);
        }

        $this->assertEquals(3, $amenity->roomTypes()->count());
    }

    /**
     * Test room belongs to room type
     */
    public function test_room_belongs_to_room_type(): void
    {
        $roomType = RoomType::factory()->create();
        $room = Room::factory()->create(['room_type_id' => $roomType->id]);

        $this->assertInstanceOf(RoomType::class, $room->roomType);
        $this->assertEquals($roomType->id, $room->roomType->id);
    }

    /**
     * Test image belongs to room
     */
    public function test_room_image_belongs_to_room(): void
    {
        $room = Room::factory()->create();
        $image = RoomImage::factory()->create(['room_id' => $room->id]);

        $this->assertInstanceOf(Room::class, $image->room);
        $this->assertEquals($room->id, $image->room->id);
    }

    /**
     * Test enquiry has correct attributes
     */
    public function test_enquiry_has_required_attributes(): void
    {
        $enquiry = Enquiry::factory()->create();

        $this->assertNotNull($enquiry->customer_name);
        $this->assertNotNull($enquiry->customer_email);
        $this->assertNotNull($enquiry->customer_phone);
        $this->assertNotNull($enquiry->check_in_date);
        $this->assertNotNull($enquiry->check_out_date);
        $this->assertNotNull($enquiry->reference_id);
        $this->assertNotNull($enquiry->status);
    }
}
