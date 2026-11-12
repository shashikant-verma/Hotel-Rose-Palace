<?php

namespace Tests\Feature;

use App\Models\Enquiry;
use App\Models\RoomType;
use Tests\TestCase;

class EnquiryFlowTest extends TestCase
{
    /**
     * Test that enquiry form can be submitted successfully
     */
    public function test_enquiry_submission_succeeds(): void
    {
        $roomType = RoomType::factory()->create();

        $response = $this->post(route('enquiry.store'), [
            'guest_name' => 'John Doe',
            'guest_email' => 'john@example.com',
            'guest_phone' => '+91 9876543210',
            'check_in_date' => now()->addDay()->toDateString(),
            'check_out_date' => now()->addDays(3)->toDateString(),
            'room_type_id' => $roomType->id,
            'number_of_guests' => 2,
            'message' => 'Looking for a luxury room',
        ]);

        $this->assertDatabaseHas('enquiries', [
            'guest_name' => 'John Doe',
            'guest_email' => 'john@example.com',
        ]);

        $this->assertTrue($response->status() >= 200 && $response->status() < 300);
    }

    /**
     * Test enquiry validation fails with invalid data
     */
    public function test_enquiry_validation_fails_with_invalid_data(): void
    {
        $response = $this->post(route('enquiry.store'), [
            'guest_name' => '',
            'guest_email' => 'invalid-email',
            'guest_phone' => '',
            'check_in_date' => 'invalid-date',
            'room_type_id' => 999, // Non-existent room type
        ]);

        $response->assertSessionHasErrors();
    }

    /**
     * Test rate limiting on enquiry form
     */
    public function test_enquiry_rate_limiting_works(): void
    {
        $roomType = RoomType::factory()->create();
        $data = [
            'guest_name' => 'John Doe',
            'guest_email' => 'john@example.com',
            'guest_phone' => '+91 9876543210',
            'check_in_date' => now()->addDay()->toDateString(),
            'check_out_date' => now()->addDays(3)->toDateString(),
            'room_type_id' => $roomType->id,
            'number_of_guests' => 2,
        ];

        // First 3 enquiries should succeed
        for ($i = 0; $i < 3; $i++) {
            $response = $this->post(route('enquiry.store'), $data);
            $this->assertTrue($response->status() < 300);
        }

        // 4th enquiry should be rate limited
        $response = $this->post(route('enquiry.store'), $data);
        $this->assertTrue($response->status() === 429);
    }

    /**
     * Test enquiry success page displays correctly
     */
    public function test_enquiry_success_page_displays(): void
    {
        $enquiry = Enquiry::factory()->create();

        $response = $this->get(route('enquiry.success', $enquiry->reference_number));

        $response->assertStatus(200);
        $response->assertSee($enquiry->reference_number);
    }

    /**
     * Test enquiry generates reference number
     */
    public function test_enquiry_has_reference_number(): void
    {
        $enquiry = Enquiry::factory()->create();

        $this->assertNotNull($enquiry->reference_number);
        $this->assertEquals(10, strlen($enquiry->reference_number));
    }
}
