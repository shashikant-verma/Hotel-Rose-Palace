<?php

namespace App\Services;

use App\Models\OtpVerification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;

class OtpService
{
    // Configuration (should be in .env)
    protected int $otpLength = 6;
    protected int $otpExpiryMinutes = 5;
    protected int $maxVerificationAttempts = 5;
    protected int $maxOtpsPerWindow = 3;
    protected int $otpRequestWindowMinutes = 15;

    /**
     * Generate and send OTP to mobile number
     * 
     * @param string $mobile Customer mobile number
     * @param string $purpose 'booking' or 'manage_bookings'
     * @return array ['success' => bool, 'message' => string, 'otp_id' => int|null]
     */
    public function generateAndSendOtp(string $mobile, string $purpose = 'booking'): array
    {
        // Validate mobile number
        if (!$this->isValidMobileNumber($mobile)) {
            return [
                'success' => false,
                'message' => 'Invalid mobile number format',
                'otp_id' => null,
            ];
        }

        // Rate limiting: Check OTP request count in time window
        $cacheKey = "otp_requests:{$mobile}:{$purpose}";
        $requestCount = Cache::get($cacheKey, 0);

        if ($requestCount >= $this->maxOtpsPerWindow) {
            return [
                'success' => false,
                'message' => "Too many OTP requests. Please try again in {$this->otpRequestWindowMinutes} minutes.",
                'otp_id' => null,
            ];
        }

        // Generate OTP
        $otp = $this->generateOtp();

        // Create OTP record
        $otpRecord = OtpVerification::create([
            'mobile_number' => $mobile,
            'otp_hash' => Hash::make($otp),
            'purpose' => $purpose,
            'expires_at' => now()->addMinutes($this->otpExpiryMinutes),
        ]);

        // Try to send SMS
        $sendResult = $this->sendOtpSms($mobile, $otp);

        if (!$sendResult['success']) {
            // Delete the OTP record if SMS failed
            $otpRecord->delete();
            
            return [
                'success' => false,
                'message' => $sendResult['message'] ?? 'Failed to send OTP. Please try again.',
                'otp_id' => null,
            ];
        }

        // Update rate limit cache
        Cache::put($cacheKey, $requestCount + 1, now()->addMinutes($this->otpRequestWindowMinutes));

        return [
            'success' => true,
            'message' => "OTP sent to {$mobile}. Valid for {$this->otpExpiryMinutes} minutes.",
            'otp_id' => $otpRecord->id,
        ];
    }

    /**
     * Verify OTP
     * 
     * @param string $mobile Customer mobile number
     * @param string $otp The OTP code entered by user
     * @param string $purpose 'booking' or 'manage_bookings'
     * @return array ['success' => bool, 'message' => string, 'otp_record' => OtpVerification|null]
     */
    public function verifyOtp(string $mobile, string $otp, string $purpose = 'booking'): array
    {
        // Get latest OTP for this mobile and purpose
        $otpRecord = OtpVerification::latestForMobile($mobile, $purpose)->first();

        if (!$otpRecord) {
            return [
                'success' => false,
                'message' => 'No OTP request found for this mobile number.',
                'otp_record' => null,
            ];
        }

        // Check if expired
        if ($otpRecord->hasExpired()) {
            return [
                'success' => false,
                'message' => 'OTP has expired. Request a new OTP.',
                'otp_record' => null,
            ];
        }

        // Check if already verified
        if ($otpRecord->verified) {
            return [
                'success' => false,
                'message' => 'OTP already used. Request a new OTP.',
                'otp_record' => null,
            ];
        }

        // Check attempt count
        if ($otpRecord->attemptsExceeded($this->maxVerificationAttempts)) {
            return [
                'success' => false,
                'message' => "Maximum verification attempts exceeded. Request a new OTP.",
                'otp_record' => null,
            ];
        }

        // Verify OTP hash
        if (!Hash::check($otp, $otpRecord->otp_hash)) {
            $otpRecord->incrementAttempt();
            
            $remainingAttempts = $this->maxVerificationAttempts - $otpRecord->attempt_count;
            $message = $remainingAttempts > 0 
                ? "Invalid OTP. {$remainingAttempts} attempts remaining."
                : "Maximum attempts exceeded. Request a new OTP.";

            return [
                'success' => false,
                'message' => $message,
                'otp_record' => null,
            ];
        }

        // OTP is valid - mark as verified
        $otpRecord->markVerified();

        // Clear rate limit for successful verification
        Cache::forget("otp_requests:{$mobile}:{$purpose}");

        return [
            'success' => true,
            'message' => 'OTP verified successfully.',
            'otp_record' => $otpRecord,
        ];
    }

    /**
     * Generate a 6-digit OTP
     */
    private function generateOtp(): string
    {
        return str_pad(random_int(0, 999999), $this->otpLength, '0', STR_PAD_LEFT);
    }

    /**
     * Validate mobile number format
     */
    private function isValidMobileNumber(string $mobile): bool
    {
        // Remove spaces, dashes, parentheses
        $cleaned = preg_replace('/[^0-9+]/', '', $mobile);

        // Check length (10-15 digits for international format)
        if (!preg_match('/^\+?[0-9]{10,15}$/', $cleaned)) {
            return false;
        }

        return true;
    }

    /**
     * Send OTP via SMS
     * This is a stub - actual implementation depends on SMS provider
     * 
     * @param string $mobile
     * @param string $otp
     * @return array ['success' => bool, 'message' => string]
     */
    private function sendOtpSms(string $mobile, string $otp): array
    {
        // Check if SMS provider is configured
        $smsProvider = config('services.sms.provider', null);

        if (!$smsProvider) {
            // If not configured, return success but log warning
            \Log::warning('SMS provider not configured. OTP not actually sent.', [
                'mobile' => $mobile,
                'otp_placeholder' => $this->maskOtp($otp),
            ]);

            return [
                'success' => true,
                'message' => 'OTP prepared (SMS provider not configured for development)',
            ];
        }

        try {
            // Dispatch job to send SMS asynchronously
            // For now, we'll return success as implementation depends on chosen provider
            // In production, this would call: SendOtpSmsJob::dispatch($mobile, $otp);
            
            return [
                'success' => true,
                'message' => "OTP sent to {$mobile}",
            ];
        } catch (\Exception $e) {
            \Log::error('Failed to send OTP SMS', [
                'mobile' => $mobile,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Failed to send OTP. Please try again.',
            ];
        }
    }

    /**
     * Mask OTP for logging (show only last 2 digits)
     */
    private function maskOtp(string $otp): string
    {
        $length = strlen($otp);
        return str_repeat('*', $length - 2) . substr($otp, -2);
    }

    /**
     * Clean up expired OTPs (database maintenance)
     * 
     * @return int Count of deleted records
     */
    public function cleanupExpiredOtps(): int
    {
        return OtpVerification::where('expires_at', '<', now())
            ->where('verified', false)
            ->delete();
    }

    /**
     * Get remaining valid time for an OTP in seconds
     */
    public function getRemainingTime(OtpVerification $otp): int
    {
        $remaining = $otp->expires_at->diffInSeconds(now(), false);
        return max(0, $remaining);
    }
}
