<?php

namespace Tests\Feature;

use App\Models\Room;
use App\Models\RoomImage;
use App\Models\RoomType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RoomCatalogueAndImageUploadTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected RoomType $roomType;
    protected Room $room;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['is_active' => true]);

        $this->roomType = RoomType::create([
            'name' => 'Deluxe Family Room',
            'slug' => 'deluxe-family-room',
            'description' => 'Comfortable elegance with modern sandstone accents.',
            'base_price' => 1725.00,
            'original_price' => 2100.00,
            'max_occupancy' => 3,
            'max_adults' => 2,
            'max_children' => 1,
            'size_sqft' => 154,
            'bed_type' => 'King Bed',
            'view_type' => 'City View',
            'bedroom_count' => 1,
            'living_room_count' => 0,
            'bathroom_count' => 1,
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $this->room = Room::create([
            'room_type_id' => $this->roomType->id,
            'room_number' => '101',
            'category' => 'Deluxe Family Room',
            'floor' => 1,
            'current_price' => 1725.00,
            'price_per_night' => 1725.00,
            'max_guests' => 3,
            'is_available' => true,
            'status' => 'available',
            'housekeeping_status' => 'clean',
        ]);
    }

    /**
     * Test RoomType model supports new hospitality fields.
     */
    public function test_room_type_has_hospitality_specifications(): void
    {
        $this->assertEquals('King Bed', $this->roomType->bed_type);
        $this->assertEquals('City View', $this->roomType->view_type);
        $this->assertEquals(1, $this->roomType->bedroom_count);
        $this->assertEquals(0, $this->roomType->living_room_count);
        $this->assertEquals(1, $this->roomType->bathroom_count);
        $this->assertEquals('2100.00', $this->roomType->original_price);
    }

    /**
     * Test admin can create a room type with full hospitality specifications.
     */
    public function test_admin_can_create_room_type_with_specifications(): void
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.room-types.store'), [
                'name' => 'Executive Club Room',
                'description' => 'Spacious corporate room with executive amenities.',
                'base_price' => 2499.00,
                'original_price' => 2899.00,
                'max_occupancy' => 3,
                'max_adults' => 2,
                'max_children' => 1,
                'size_sqft' => 220,
                'bed_type' => 'Twin Beds',
                'view_type' => 'Courtyard View',
                'bedroom_count' => 1,
                'living_room_count' => 1,
                'bathroom_count' => 1,
                'is_active' => 1,
            ]);

        $response->assertRedirect(route('admin.room-types.index'));
        $this->assertDatabaseHas('room_types', [
            'name' => 'Executive Club Room',
            'slug' => 'executive-club-room',
            'bed_type' => 'Twin Beds',
            'view_type' => 'Courtyard View',
            'living_room_count' => 1,
            'original_price' => 2899.00,
        ]);
    }

    /**
     * Test admin can update a room type's hospitality specifications.
     */
    public function test_admin_can_update_room_type_specifications(): void
    {
        $response = $this->actingAs($this->admin)
            ->put(route('admin.room-types.update', $this->roomType), [
                'name' => 'Deluxe Family Room',
                'description' => 'Updated luxury description.',
                'base_price' => 1725.00,
                'original_price' => 2200.00,
                'max_occupancy' => 3,
                'max_adults' => 2,
                'max_children' => 1,
                'size_sqft' => 154,
                'bed_type' => 'Master King Bed',
                'view_type' => 'Panoramic City View',
                'bedroom_count' => 1,
                'living_room_count' => 0,
                'bathroom_count' => 1,
                'is_active' => 1,
            ]);

        $response->assertRedirect(route('admin.room-types.index'));
        $this->roomType->refresh();
        $this->assertEquals('Master King Bed', $this->roomType->bed_type);
        $this->assertEquals('Panoramic City View', $this->roomType->view_type);
        $this->assertEquals('2200.00', $this->roomType->original_price);
    }

    /**
     * Test admin room image upload correctly uses display_order and creates valid image records.
     */
    public function test_admin_room_image_upload_uses_display_order(): void
    {
        Storage::fake('public');

        $image1 = UploadedFile::fake()->create('room101_view1.jpg', 200, 'image/jpeg');
        $image2 = UploadedFile::fake()->create('room101_view2.jpg', 250, 'image/jpeg');

        $response = $this->actingAs($this->admin)
            ->post(route('admin.rooms.upload-images', $this->room), [
                'images' => [$image1, $image2],
            ]);

        $response->assertRedirect();
        $this->assertDatabaseCount('room_images', 2);

        $images = RoomImage::where('room_id', $this->room->id)->orderBy('display_order')->get();

        // First image should be display_order 1 and is_featured true
        $this->assertEquals(1, $images[0]->display_order);
        $this->assertTrue($images[0]->is_featured);
        $this->assertNotEmpty($images[0]->image_path);
        $this->assertNotEmpty($images[0]->image_url);

        // Second image should be display_order 2 and is_featured false
        $this->assertEquals(2, $images[1]->display_order);
        $this->assertFalse($images[1]->is_featured);

        // Verify relationship on room
        $this->assertCount(2, $this->room->images);
    }

    /**
     * Test deleting featured image re-assigns featured to the next available image.
     */
    public function test_admin_delete_featured_image_reassigns_featured(): void
    {
        Storage::fake('public');

        $img1 = RoomImage::create([
            'room_id' => $this->room->id,
            'image_path' => 'rooms/101/test1.jpg',
            'image_url' => '/storage/rooms/101/test1.jpg',
            'display_order' => 1,
            'is_featured' => true,
        ]);

        $img2 = RoomImage::create([
            'room_id' => $this->room->id,
            'image_path' => 'rooms/101/test2.jpg',
            'image_url' => '/storage/rooms/101/test2.jpg',
            'display_order' => 2,
            'is_featured' => false,
        ]);

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.rooms.delete-image', $img1));

        $response->assertRedirect();
        $this->assertDatabaseMissing('room_images', ['id' => $img1->id]);

        $img2->refresh();
        $this->assertTrue($img2->is_featured);
    }

    /**
     * Test public room catalogue renders dynamically without hardcoded room cards.
     */
    public function test_public_rooms_catalogue_renders_dynamic_database_records(): void
    {
        $response = $this->get(route('rooms'));

        $response->assertStatus(200);
        $response->assertSee('Deluxe Family Room');
        $response->assertSee('1,725');
        $response->assertSee('King Bed');
        $response->assertSee('154 sq.ft');
        $response->assertSee('Up to 3 Guests');
        $response->assertSee('City View');

        // Ensure legacy fictional room cards are not hardcoded
        $response->assertDontSee('Maharaja Grand Suite</h3>', false);
        $response->assertDontSee('Royal Heritage Suite</h3>', false);
        $response->assertDontSee('Executive Work-Desk Suite</h3>', false);

        // Verify multi-photo carousel and gallery elements render
        $response->assertSee('hrp-room-gallery-wrap', false);
        $response->assertSee('hrp-thumbnails-strip', false);
        $response->assertSee('hrp-carousel-arrow', false);
        $response->assertSee('Check Rates');
        $response->assertSee('Book Now');
        $response->assertSee('Details');
    }

    /**
     * Test public room detail page renders verified specifications and photo gallery.
     */
    public function test_public_room_detail_displays_verified_specs(): void
    {
        $response = $this->get(route('room-detail', ['slug' => 'deluxe-family-room']));

        $response->assertStatus(200);
        $response->assertSee('Deluxe Family Room');
        $response->assertSee('154 sq.ft');
        $response->assertSee('King Bed');
        $response->assertSee('City View');
        $response->assertSee('Up to 3 Guests');
        $response->assertSee('thumb-selector');

        // Ensure "Pay on arrival" is not present
        $response->assertDontSee('No advance booking fees. Pay on arrival');
        $response->assertSee('100% Secure Instant Online Booking via Razorpay');

        // Also test Executive Room detail page renders
        $executiveType = RoomType::create([
            'name' => 'Executive Room',
            'slug' => 'executive-room',
            'description' => 'Tailored for corporate travelers and textile connoisseurs.',
            'base_price' => 1100.00,
            'max_occupancy' => 3,
            'max_adults' => 2,
            'max_children' => 1,
            'size_sqft' => 180,
            'bed_type' => 'Twin Beds',
            'view_type' => 'City View',
            'bedroom_count' => 1,
            'bathroom_count' => 1,
            'is_active' => true,
            'sort_order' => 2,
        ]);

        $execResponse = $this->get(route('room-detail', ['slug' => 'executive-room']));
        $execResponse->assertStatus(200);
        $execResponse->assertSee('Executive Room');
        $execResponse->assertSee('1,100');
        $execResponse->assertSee('thumb-selector');
    }

    /**
     * Test HotelOperationsSeeder has zero destructive operations.
     */
    public function test_hotel_operations_seeder_has_no_destructive_operations(): void
    {
        $seederContent = file_get_contents(database_path('seeders/HotelOperationsSeeder.php'));

        $this->assertStringNotContainsString('truncate()', $seederContent);
        $this->assertStringNotContainsString('FOREIGN_KEY_CHECKS=0', $seederContent);
        $this->assertStringNotContainsString('FOREIGN_KEY_CHECKS=1', $seederContent);
        $this->assertStringContainsString('firstOrCreate', $seederContent);
    }
}
