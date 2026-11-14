<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageBookingLinksTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_homepage_booking_buttons_link_to_booking_search(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $content = $response->getContent();

        // Ensure booking/search route is present
        $this->assertStringContainsString('/booking/search', $content);

        // Ensure no active buttons trigger openBookingModal
        $this->assertStringNotContainsString('onclick="window.openBookingModal', $content);
        $this->assertStringNotContainsString('onclick="if(window.openBookingModal', $content);

        // Ensure misleading modal titles and buttons are replaced in the modal component
        $this->assertStringNotContainsString('Direct Luxury Reservation', $content);
        $this->assertStringNotContainsString('Confirm Direct Reservation', $content);
        $this->assertStringContainsString('Room Reservation Enquiry', $content);
        $this->assertStringContainsString('Submit Booking Enquiry', $content);

        // Verify count of booking/search links on homepage
        $count = substr_count($content, '/booking/search');
        $this->assertGreaterThanOrEqual(9, $count, "Expected at least 9 booking search links across navbar, hero, floating bar, featured rooms, comparison table, and mobile dock.");
    }
}
