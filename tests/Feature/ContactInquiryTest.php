<?php

namespace Tests\Feature;

use App\Mail\GeneralInquiryReceived;
use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactInquiryTest extends TestCase
{
    use RefreshDatabase;

    /* ═══════════════════════════════════════════════════════════════════════
       1. VALIDATION TESTS
       ═══════════════════════════════════════════════════════════════════════ */

    /**
     * Test inquiry form validation fails when required fields are missing
     */
    public function test_inquiry_validation_fails_when_fields_are_missing(): void
    {
        $response = $this->post(route('contact.submit'), [
            'name' => '',
            'email' => '',
            'phone' => '',
            'subject' => '',
            'message' => '',
        ]);

        $response->assertSessionHasErrors(['name', 'email', 'subject', 'message']);
    }

    /**
     * Test inquiry form validation fails with invalid email format
     */
    public function test_inquiry_validation_fails_with_invalid_email(): void
    {
        $response = $this->post(route('contact.submit'), [
            'name' => 'John Doe',
            'email' => 'not-an-email',
            'subject' => 'General Question',
            'message' => 'Test message',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /**
     * Test inquiry form validation rejects invalid or unapproved subject values
     */
    public function test_inquiry_validation_rejects_unapproved_subject_values(): void
    {
        $response = $this->post(route('contact.submit'), [
            'name' => 'Rajesh Shah',
            'email' => 'rajesh@example.com',
            'subject' => 'Airport Taxi / Shuttle Request', // Unapproved / removed subject
            'message' => 'Please pick me up at the airport.',
        ]);

        $response->assertSessionHasErrors(['subject']);
    }

    /**
     * Test form preserves previously entered values upon validation failure
     */
    public function test_form_preserves_old_input_on_validation_failure(): void
    {
        $response = $this->post(route('contact.submit'), [
            'name' => 'Kavita Patel',
            'email' => 'invalid-email',
            'phone' => '+91 98765 43210',
            'subject' => 'Room Reservation',
            'message' => 'Looking for suite availability.',
        ]);

        $response->assertSessionHasErrors(['email']);
        $response->assertSessionHas('_old_input.name', 'Kavita Patel');
        $response->assertSessionHas('_old_input.phone', '+91 98765 43210');
        $response->assertSessionHas('_old_input.subject', 'Room Reservation');
        $response->assertSessionHas('_old_input.message', 'Looking for suite availability.');
    }

    /* ═══════════════════════════════════════════════════════════════════════
       2. DATABASE TESTS
       ═══════════════════════════════════════════════════════════════════════ */

    /**
     * Test inquiry submission succeeds and stores all fields including subject in database
     */
    public function test_inquiry_submission_succeeds_and_saves_subject(): void
    {
        Mail::fake();

        $payload = [
            'name' => 'Aarav Patel',
            'email' => 'aarav.patel@example.com',
            'phone' => '+91 98765 12345',
            'subject' => 'Room Reservation',
            'message' => 'Inquiry for executive suite booking next month.',
        ];

        $response = $this->post(route('contact.submit'), $payload);

        $response->assertRedirect(route('contact'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Aarav Patel',
            'email' => 'aarav.patel@example.com',
            'phone' => '+91 98765 12345',
            'subject' => 'Room Reservation',
            'message' => 'Inquiry for executive suite booking next month.',
            'status' => 'new',
        ]);
    }

    /**
     * Test previously existing inquiries without subject remain accessible
     */
    public function test_existing_inquiries_without_subject_remain_accessible(): void
    {
        $legacy = ContactMessage::create([
            'name' => 'Legacy Customer',
            'email' => 'legacy@example.com',
            'phone' => '+91 90000 00000',
            'subject' => null, // No subject from before migration
            'message' => 'Older message submitted before subject column existed.',
            'status' => 'new',
            'is_read' => false,
            'is_replied' => false,
        ]);

        $this->assertDatabaseHas('contact_messages', [
            'id' => $legacy->id,
            'name' => 'Legacy Customer',
            'subject' => null,
        ]);

        $found = ContactMessage::find($legacy->id);
        $this->assertNotNull($found);
        $this->assertEquals('Legacy Customer', $found->name);
        $this->assertNull($found->subject);
    }

    /**
     * Test airport shuttle parameter is completely ignored if submitted
     */
    public function test_airport_shuttle_param_is_safely_ignored(): void
    {
        Mail::fake();

        $payload = [
            'name' => 'Pooja Sharma',
            'email' => 'pooja@example.com',
            'phone' => '+91 98765 67890',
            'subject' => 'General Question',
            'message' => 'Checking for check-in timings.',
            'airport_shuttle' => '1',
        ];

        $response = $this->post(route('contact.submit'), $payload);

        $response->assertRedirect(route('contact'));

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Pooja Sharma',
            'email' => 'pooja@example.com',
            'subject' => 'General Question',
        ]);
    }

    /* ═══════════════════════════════════════════════════════════════════════
       3. EMAIL NOTIFICATION TESTS
       ═══════════════════════════════════════════════════════════════════════ */

    /**
     * Test manager email notification is triggered with accurate customer details
     */
    public function test_manager_email_notification_is_triggered_after_successful_storage(): void
    {
        Mail::fake();

        $payload = [
            'name' => 'Vikram Singhania',
            'email' => 'vikram@example.com',
            'phone' => '+91 98222 33444',
            'subject' => 'Banquet & Event Inquiry',
            'message' => 'Requesting quote for wedding reception of 250 guests.',
        ];

        $this->post(route('contact.submit'), $payload);

        Mail::assertSent(GeneralInquiryReceived::class, function ($mail) use ($payload) {
            return $mail->hasTo(config('hotel.contact.manager_email', 'Hotelrosepalacesurat@gmail.com')) &&
                   $mail->inquiry->name === $payload['name'] &&
                   $mail->inquiry->email === $payload['email'] &&
                   $mail->inquiry->phone === $payload['phone'] &&
                   $mail->inquiry->subject === $payload['subject'] &&
                   $mail->inquiry->message === $payload['message'];
        });
    }

    /**
     * Test email notification is NOT triggered if validation fails
     */
    public function test_email_is_not_triggered_when_validation_fails(): void
    {
        Mail::fake();

        $this->post(route('contact.submit'), [
            'name' => '',
            'email' => 'invalid',
        ]);

        Mail::assertNothingSent();
    }

    /**
     * Test email dispatch failure does not lose or delete the saved inquiry
     */
    public function test_email_failure_does_not_lose_saved_inquiry(): void
    {
        // Mock Mail to throw an exception when sending
        Mail::shouldReceive('to')->andThrow(new \Exception('SMTP Connection Timed Out'));

        $payload = [
            'name' => 'Hardik Shah',
            'email' => 'hardik@example.com',
            'phone' => '+91 98888 77777',
            'subject' => 'General Question',
            'message' => 'Query about banquet hall pricing.',
        ];

        $response = $this->post(route('contact.submit'), $payload);

        // Form still completes gracefully
        $response->assertRedirect(route('contact'));
        $response->assertSessionHas('success');

        // Inquiry is safely preserved in database
        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Hardik Shah',
            'email' => 'hardik@example.com',
            'subject' => 'General Question',
            'message' => 'Query about banquet hall pricing.',
        ]);
    }

    /* ═══════════════════════════════════════════════════════════════════════
       4. ADMIN PANEL INQUIRY MANAGEMENT TESTS
       ═══════════════════════════════════════════════════════════════════════ */

    /**
     * Test guest cannot access admin inquiry management
     */
    public function test_unauthenticated_user_cannot_access_admin_inquiries(): void
    {
        $response = $this->get(route('admin.contact-messages.index'));
        $response->assertRedirect(route('admin.login'));
    }

    /**
     * Test admin can access inquiry management index
     */
    public function test_admin_can_access_inquiry_management(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);

        ContactMessage::create([
            'name' => 'Anil Kapoor',
            'email' => 'anil@example.com',
            'phone' => '+91 98765 00000',
            'subject' => 'Room Reservation',
            'message' => 'Need 2 deluxe rooms.',
            'status' => 'new',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.contact-messages.index'));

        $response->assertStatus(200);
        $response->assertSee('General Contact Inquiries');
        $response->assertSee('Anil Kapoor');
        $response->assertSee('Room Reservation');
    }

    /**
     * Test admin can view inquiry details and auto-marks as read
     */
    public function test_admin_can_view_inquiry_details_and_auto_marks_as_read(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);

        $inquiry = ContactMessage::create([
            'name' => 'Meera Rajput',
            'email' => 'meera@example.com',
            'phone' => '+91 98111 22233',
            'subject' => 'General Question',
            'message' => 'Do you allow early check-in at 8 AM?',
            'status' => 'new',
            'is_read' => false,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.contact-messages.show', $inquiry->id));

        $response->assertStatus(200);
        $response->assertSee('Meera Rajput');
        $response->assertSee('Do you allow early check-in at 8 AM?');

        // Verify status automatically updated to read
        $this->assertEquals('read', $inquiry->fresh()->status);
        $this->assertTrue((bool)$inquiry->fresh()->is_read);
    }

    /**
     * Test admin can update inquiry status
     */
    public function test_admin_can_update_inquiry_status(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);

        $inquiry = ContactMessage::create([
            'name' => 'Sanjay Verma',
            'email' => 'sanjay@example.com',
            'subject' => 'Room Reservation',
            'message' => 'Booking request.',
            'status' => 'read',
        ]);

        $response = $this->actingAs($admin)->patch(route('admin.contact-messages.update-status', $inquiry->id), [
            'status' => 'replied',
        ]);

        $response->assertSessionHas('success');
        $this->assertEquals('replied', $inquiry->fresh()->status);
        $this->assertTrue((bool)$inquiry->fresh()->is_replied);
    }

    /**
     * Test admin can filter inquiries by status
     */
    public function test_admin_can_filter_inquiries_by_status(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);

        ContactMessage::create([
            'name' => 'Guest Alpha',
            'email' => 'alpha@example.com',
            'subject' => 'Room Reservation',
            'message' => 'Alpha message',
            'status' => 'new',
        ]);

        ContactMessage::create([
            'name' => 'Guest Beta',
            'email' => 'beta@example.com',
            'subject' => 'General Question',
            'message' => 'Beta message',
            'status' => 'replied',
        ]);

        // Filter for new only
        $response = $this->actingAs($admin)->get(route('admin.contact-messages.index', ['status' => 'new']));
        $response->assertStatus(200);
        $response->assertSee('Guest Alpha');
        $response->assertDontSee('Guest Beta');

        // Filter for replied only
        $response = $this->actingAs($admin)->get(route('admin.contact-messages.index', ['status' => 'replied']));
        $response->assertStatus(200);
        $response->assertSee('Guest Beta');
        $response->assertDontSee('Guest Alpha');
    }

    /**
     * Test admin can delete an inquiry
     */
    public function test_admin_can_delete_inquiry(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);

        $inquiry = ContactMessage::create([
            'name' => 'Spam Guest',
            'email' => 'spam@example.com',
            'subject' => 'General Question',
            'message' => 'Spam text',
            'status' => 'new',
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.contact-messages.destroy', $inquiry->id));

        $response->assertRedirect(route('admin.contact-messages.index'));
        $this->assertSoftDeleted('contact_messages', ['id' => $inquiry->id]);
    }
}
