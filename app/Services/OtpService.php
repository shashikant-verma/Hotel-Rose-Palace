<?php

namespace App\Services;

use App\Mail\OtpMail;
use App\Models\OtpVerification;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OtpService
{
    protected int $otpLength = 6;
    protected int $otpExpiryMinutes = 5;
    protected int $maxVerificationAttempts = 5;
    protected int $maxOtpsPerWindow = 3;
    protected int $otpRequestWindowMinutes = 15;

    /**
     * @return array{success: bool, message: string, otp_id: int|null}
     */
    public function generateAndSendOtp(string $email, string $purpose = 'booking'): array
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return [
                'success' => false,
                'message' => 'Invalid email address format.',
                'otp_id' => null,
            ];
        }

        $cacheKey = "otp_requests:{$email}:{$purpose}";
        $requestCount = Cache::get($cacheKey, 0);

        if ($requestCount >= $this->maxOtpsPerWindow) {
            return [
                'success' => false,
                'message' => "Too many OTP requests. Please try again in {$this->otpRequestWindowMinutes} minutes.",
                'otp_id' => null,
            ];
        }

        $otp = $this->generateOtp();

        $otpRecord = OtpVerification::create([
            'email' => $email,
            'otp_hash' => Hash::make($otp),
            'purpose' => $purpose,
            'expires_at' => now()->addMinutes($this->otpExpiryMinutes),
        ]);

        $sendResult = $this->sendOtpEmail($email, $otp, $purpose);

        if (!$sendResult['success']) {
            $otpRecord->delete();

            return [
                'success' => false,
                'message' => $sendResult['message'] ?? 'Failed to send OTP. Please try again.',
                'otp_id' => null,
            ];
        }

        Cache::put($cacheKey, $requestCount + 1, now()->addMinutes($this->otpRequestWindowMinutes));

        return [
            'success' => true,
            'message' => "OTP sent to {$this->maskEmail($email)}. Valid for {$this->otpExpiryMinutes} minutes.",
            'otp_id' => $otpRecord->id,
        ];
    }

    /**
     * @return array{success: bool, message: string, otp_record: OtpVerification|null}
     */
    public function verifyOtp(string $email, string $otp, string $purpose = 'booking'): array
    {
        $otpRecord = OtpVerification::latestForEmail($email, $purpose)->first();

        if (!$otpRecord) {
            return [
                'success' => false,
                'message' => 'No OTP request found for this email address.',
                'otp_record' => null,
            ];
        }

        if ($otpRecord->hasExpired()) {
            return [
                'success' => false,
                'message' => 'OTP has expired. Request a new OTP.',
                'otp_record' => null,
            ];
        }

        if ($otpRecord->verified) {
            return [
                'success' => false,
                'message' => 'OTP already used. Request a new OTP.',
                'otp_record' => null,
            ];
        }

        if ($otpRecord->attemptsExceeded($this->maxVerificationAttempts)) {
            return [
                'success' => false,
                'message' => 'Maximum verification attempts exceeded. Request a new OTP.',
                'otp_record' => null,
            ];
        }

        if (!Hash::check($otp, $otpRecord->otp_hash)) {
            $otpRecord->incrementAttempt();

            $remainingAttempts = $this->maxVerificationAttempts - $otpRecord->attempt_count;
            $message = $remainingAttempts > 0
                ? "Invalid OTP. {$remainingAttempts} attempts remaining."
                : 'Maximum attempts exceeded. Request a new OTP.';

            return [
                'success' => false,
                'message' => $message,
                'otp_record' => null,
            ];
        }

        $otpRecord->markVerified();

        Cache::forget("otp_requests:{$email}:{$purpose}");

        return [
            'success' => true,
            'message' => 'OTP verified successfully.',
            'otp_record' => $otpRecord,
        ];
    }

    private function generateOtp(): string
    {
        return str_pad(random_int(0, 999999), $this->otpLength, '0', STR_PAD_LEFT);
    }

    /**
     * @return array{success: bool, message: string}
     */
    private function sendOtpEmail(string $email, string $otp, string $purpose): array
    {
        try {
            Mail::to($email)->send(new OtpMail($otp, $purpose, $this->otpExpiryMinutes));

            return [
                'success' => true,
                'message' => "OTP sent to {$email}",
            ];
        } catch (\Exception $e) {
            Log::error('Failed to send OTP email', [
                'email' => $email,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Failed to send verification email. Please try again.',
            ];
        }
    }

    private function maskEmail(string $email): string
    {
        $parts = explode('@', $email);
        if (count($parts) !== 2) {
            return '***';
        }

        $local = $parts[0];
        $domain = $parts[1];

        if (strlen($local) <= 2) {
            $masked = $local[0] . '***';
        } else {
            $masked = $local[0] . str_repeat('*', strlen($local) - 2) . substr($local, -1);
        }

        return $masked . '@' . $domain;
    }

    public function cleanupExpiredOtps(): int
    {
        return OtpVerification::where('expires_at', '<', now())
            ->where('verified', false)
            ->delete();
    }

    public function getRemainingTime(OtpVerification $otp): int
    {
        $remaining = $otp->expires_at->diffInSeconds(now(), false);
        return max(0, $remaining);
    }
}
