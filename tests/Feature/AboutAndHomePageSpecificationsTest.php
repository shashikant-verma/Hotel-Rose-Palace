<?php

namespace Tests\Feature;

use App\Models\RoomType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AboutAndHomePageSpecificationsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed room types matching production database
        RoomType::create([
            'name' => 'Deluxe Family Room',
            'slug' => 'deluxe-family-room',
            'base_price' => 1200,
            'is_active' => true,
            'description' => 'Spacious family accommodation featuring 1 King Bed + 1 Living Room.',
            'max_occupancy' => 3,
        ]);

        RoomType::create([
            'name' => 'Executive Room',
            'slug' => 'executive-room',
            'base_price' => 1100,
            'is_active' => true,
            'description' => 'Crafted for corporate and textile travelers featuring 1 King Bed.',
            'max_occupancy' => 3,
        ]);
    }

    public function test_about_page_returns_200_and_renders_database_driven_cards(): void
    {
        $response = $this->get('/about');
        $response->assertStatus(200);

        $content = $response->getContent();

        // Database prices rendered dynamically
        $this->assertStringContainsString('Base Price ₹1,200/night', $content);
        $this->assertStringContainsString('Base Price ₹1,100/night', $content);
        $this->assertStringContainsString('₹1,128', $content);
        $this->assertStringContainsString('₹1,034', $content);

        // Manager-approved room specifications
        $this->assertStringContainsString('189 sq.ft. (17.56 m²)', $content);
        $this->assertStringContainsString('169 sq.ft. (15.70 m²)', $content);

        // Absence of old dimensions
        $this->assertStringNotContainsString('2034', $content);

        // Absence of unsupported marketing claims
        $this->assertStringNotContainsString('silent climate control', strtolower($content));
        $this->assertStringNotContainsString('smart entertainment', strtolower($content));
        $this->assertStringNotContainsString('sanitized guest touchpoints', strtolower($content));

        // Verified amenities present
        $this->assertStringContainsString('air conditioning', strtolower($content));
        $this->assertStringContainsString('flat-screen television with cable channels', strtolower($content));

        // Links present
        $this->assertStringContainsString('/rooms/deluxe-family-room', $content);
        $this->assertStringContainsString('/rooms/executive-room', $content);
        $this->assertStringContainsString('/booking/search', $content);
        $this->assertStringContainsString('/gallery', $content);
    }

    public function test_home_page_returns_200(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $content = $response->getContent();

        // Absence of 2034
        $this->assertStringNotContainsString('2034', $content);

        // Absence of unsupported marketing claims in featured rooms section
        $this->assertStringNotContainsString('silent climate control', strtolower($content));

        // Verified amenities in featured section
        $this->assertStringContainsString('air conditioning', strtolower($content));
        $this->assertStringContainsString('flat-screen television with cable channels', strtolower($content));
    }

    public function test_room_detail_routes_return_200(): void
    {
        $responseDeluxe = $this->get('/rooms/deluxe-family-room');
        $responseDeluxe->assertStatus(200);

        $responseExecutive = $this->get('/rooms/executive-room');
        $responseExecutive->assertStatus(200);
    }
}
