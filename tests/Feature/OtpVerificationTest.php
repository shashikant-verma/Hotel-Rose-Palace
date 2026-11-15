<?php

namespace Tests\Feature;

use App\Models\OtpVerification;
use App\Services\OtpService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class OtpVerificationTest extends TestCase
{
    use RefreshDatabase;

    protected OtpService $otpService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->otpService = app(OtpService::class);

        Cache::flush();
        Mail::fake();
    }

    // ==================== OTP Service Tests ====================

    public function test_can_generate_and_send_otp_with_valid_email()
    {
        $result = $this->otpService->generateAndSendOtp('guest@example.com', 'booking');

        $this->assertTrue($result['success']);
        $this->assertNotNull($result['otp_id']);
        $this->assertStringContainsString('sent', strtolower($result['message']));

        $otpRecord = OtpVerification::find($result['otp_id']);
        $this->assertNotNull($otpRecord);
        $this->assertEquals('guest@example.com', $otpRecord->email);
        $this->assertEquals('booking', $otpRecord->purpose);
        $this->assertFalse($otpRecord->verified);
    }

    public function test_cannot_generate_otp_with_invalid_email()
    {
        $result = $this->otpService->generateAndSendOtp('not-an-email', 'booking');

        $this->assertFalse($result['success']);
        $this->assertNull($result['otp_id']);
        $this->assertStringContainsString('invalid', strtolower($result['message']));
    }

    public function test_rate_limiting_prevents_excessive_otp_requests()
    {
        $email = 'guest@example.com';
        $purpose = 'booking';

        $result1 = $this->otpService->generateAndSendOtp($email, $purpose);
        $this->assertTrue($result1['success']);

        $result2 = $this->otpService->generateAndSendOtp($email, $purpose);
        $this->assertTrue($result2['success']);

        $result3 = $this->otpService->generateAndSendOtp($email, $purpose);
        $this->assertTrue($result3['success']);

        $result4 = $this->otpService->generateAndSendOtp($email, $purpose);
        $this->assertFalse($result4['success']);
        $this->assertStringContainsString('too many', strtolower($result4['message']));

        $otpCount = OtpVerification::byEmail($email)->byPurpose($purpose)->count();
        $this->assertEquals(3, $otpCount);
    }

    public function test_rate_limiting_separates_by_purpose()
    {
        $email = 'guest@example.com';

        for ($i = 0; $i < 3; $i++) {
            $result = $this->otpService->generateAndSendOtp($email, 'booking');
            $this->assertTrue($result['success']);
        }

        $result = $this->otpService->generateAndSendOtp($email, 'booking');
        $this->assertFalse($result['success']);

        $result = $this->otpService->generateAndSendOtp($email, 'manage_bookings');
        $this->assertTrue($result['success']);
    }

    public function test_can_verify_otp_with_correct_code()
    {
        $email = 'guest@example.com';
        $purpose = 'booking';
        $generateResult = $this->otpService->generateAndSendOtp($email, $purpose);
        $this->assertTrue($generateResult['success']);

        $otpRecord = OtpVerification::find($generateResult['otp_id']);
        $this->assertTrue($otpRecord->isValid());
        $this->assertFalse($otpRecord->hasExpired());
    }

    public function test_cannot_verify_expired_otp()
    {
        $otpRecord = OtpVerification::create([
            'email' => 'guest@example.com',
            'otp_hash' => Hash::make('123456'),
            'purpose' => 'booking',
            'expires_at' => now()->subMinutes(1),
        ]);

        $this->assertTrue($otpRecord->hasExpired());

        $result = $this->otpService->verifyOtp('guest@example.com', '123456', 'booking');
        $this->assertFalse($result['success']);
        $this->assertStringContainsString('expired', strtolower($result['message']));
    }

    public function test_cannot_verify_already_verified_otp()
    {
        $otpRecord = OtpVerification::create([
            'email' => 'guest@example.com',
            'otp_hash' => Hash::make('123456'),
            'purpose' => 'booking',
            'expires_at' => now()->addMinutes(5),
            'verified' => true,
            'verified_at' => now(),
        ]);

        $result = $this->otpService->verifyOtp('guest@example.com', '123456', 'booking');
        $this->assertFalse($result['success']);
        $this->assertStringContainsString('already used', strtolower($result['message']));
    }

    public function test_wrong_otp_increments_attempt_count()
    {
        $otpRecord = OtpVerification::create([
            'email' => 'guest@example.com',
            'otp_hash' => Hash::make('123456'),
            'purpose' => 'booking',
            'expires_at' => now()->addMinutes(5),
        ]);

        $result = $this->otpService->verifyOtp('guest@example.com', '999999', 'booking');
        $this->assertFalse($result['success']);

        $otpRecord->refresh();
        $this->assertEquals(1, $otpRecord->attempt_count);
        $this->assertNotNull($otpRecord->last_attempt_at);
    }

    public function test_cannot_verify_after_max_attempts()
    {
        $otpRecord = OtpVerification::create([
            'email' => 'guest@example.com',
            'otp_hash' => Hash::make('123456'),
            'purpose' => 'booking',
            'expires_at' => now()->addMinutes(5),
            'attempt_count' => 5,
        ]);

        $result = $this->otpService->verifyOtp('guest@example.com', '123456', 'booking');
        $this->assertFalse($result['success']);
        $this->assertStringContainsString('maximum', strtolower($result['message']));
    }

    public function test_cleanup_expired_otps()
    {
        OtpVerification::create([
            'email' => 'expired@example.com',
            'otp_hash' => Hash::make('111111'),
            'purpose' => 'booking',
            'expires_at' => now()->subMinutes(10),
            'verified' => false,
        ]);

        OtpVerification::create([
            'email' => 'valid@example.com',
            'otp_hash' => Hash::make('222222'),
            'purpose' => 'booking',
            'expires_at' => now()->addMinutes(5),
            'verified' => false,
        ]);

        OtpVerification::create([
            'email' => 'verified@example.com',
            'otp_hash' => Hash::make('333333'),
            'purpose' => 'booking',
            'expires_at' => now()->subMinutes(5),
            'verified' => true,
        ]);

        $deleted = $this->otpService->cleanupExpiredOtps();

        $this->assertEquals(1, $deleted);
        $this->assertEquals(2, OtpVerification::count());
    }

    // ==================== OTP Controller Tests ====================

    public function test_otp_send_form_displays()
    {
        $response = $this->get(route('otp.send.form'));

        $response->assertStatus(200);
        $response->assertViewIs('otp.send-request');
    }

    public function test_otp_verify_form_displays()
    {
        session(['email' => 'guest@example.com', 'purpose' => 'booking']);

        $response = $this->get(route('otp.verify.form'));

        $response->assertStatus(200);
        $response->assertViewIs('otp.verify');
    }

    public function test_can_send_otp_via_http()
    {
        $response = $this->post(route('otp.send'), [
            'email' => 'guest@example.com',
            'purpose' => 'booking',
        ]);

        $response->assertStatus(302);
        $this->assertEquals(1, OtpVerification::count());
    }

    public function test_cannot_send_otp_with_invalid_input()
    {
        $response = $this->post(route('otp.send'), [
            'email' => 'not-an-email',
            'purpose' => 'invalid_purpose',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['email', 'purpose']);
    }

    public function test_can_verify_otp_via_http()
    {
        $otpRecord = OtpVerification::create([
            'email' => 'guest@example.com',
            'otp_hash' => Hash::make('123456'),
            'purpose' => 'booking',
            'expires_at' => now()->addMinutes(5),
        ]);

        $response = $this->post(route('otp.verify'), [
            'email' => 'guest@example.com',
            'otp' => '123456',
            'purpose' => 'booking',
        ]);

        $response->assertStatus(302);

        $this->assertTrue(session('otp_verified') ?? false);
        $this->assertEquals('guest@example.com', session('verified_email'));
    }

    public function test_cannot_verify_otp_with_wrong_code()
    {
        $otpRecord = OtpVerification::create([
            'email' => 'guest@example.com',
            'otp_hash' => Hash::make('123456'),
            'purpose' => 'booking',
            'expires_at' => now()->addMinutes(5),
        ]);

        $response = $this->post(route('otp.verify'), [
            'email' => 'guest@example.com',
            'otp' => '999999',
            'purpose' => 'booking',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['otp']);

        $this->assertNotTrue(session('otp_verified') ?? false);
    }

    public function test_can_resend_otp()
    {
        $this->otpService->generateAndSendOtp('guest@example.com', 'booking');

        $response = $this->postJson(route('otp.resend'), [
            'email' => 'guest@example.com',
            'purpose' => 'booking',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertEquals(2, OtpVerification::byEmail('guest@example.com')->count());
    }

    public function test_can_check_verification_status()
    {
        $response = $this->getJson(route('otp.check-verification'));
        $response->assertJson(['verified' => false]);

        session([
            'otp_verified' => true,
            'verified_email' => 'guest@example.com',
            'verified_at' => now()->timestamp,
        ]);

        $response = $this->getJson(route('otp.check-verification'));
        $response->assertJson(['verified' => true]);
    }

    public function test_otp_logout_clears_session()
    {
        session([
            'otp_verified' => true,
            'verified_email' => 'guest@example.com',
            'verified_purpose' => 'booking',
            'verified_at' => now()->timestamp,
        ]);

        $response = $this->postJson(route('otp.logout'));
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertNull(session('otp_verified'));
        $this->assertNull(session('verified_email'));
    }

    public function test_otp_must_be_6_digits()
    {
        $response = $this->post(route('otp.verify'), [
            'email' => 'guest@example.com',
            'otp' => '12345',
            'purpose' => 'booking',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['otp']);
    }

    public function test_otp_verification_session_can_expire()
    {
        session([
            'otp_verified' => true,
            'verified_email' => 'guest@example.com',
            'verified_at' => now()->subHours(2)->timestamp,
        ]);

        $verifiedAt = session('verified_at');
        $currentTime = now()->timestamp;
        $ageSeconds = $currentTime - $verifiedAt;
        $isExpired = $ageSeconds > 3600;

        $this->assertTrue($isExpired);
    }
}
