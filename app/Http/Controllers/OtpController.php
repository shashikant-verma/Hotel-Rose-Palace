<?php

namespace App\Http\Controllers;

use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class OtpController extends Controller
{
    protected OtpService $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    /**
     * Show OTP request form (GET /otp/send-request)
     */
    public function showSendForm()
    {
        return view('otp.send-request');
    }

    /**
     * Send OTP to mobile number (POST /otp/send)
     */
    public function send(Request $request)
    {
        $validated = $request->validate([
            'mobile' => ['required', 'regex:/^\+?[0-9]{10,15}$/'],
            'purpose' => ['required', 'in:booking,manage_bookings'],
        ], [
            'mobile.regex' => 'Please enter a valid mobile number (10-15 digits)',
        ]);

        try {
            $result = $this->otpService->generateAndSendOtp(
                $validated['mobile'],
                $validated['purpose']
            );

            if (!$result['success']) {
                throw ValidationException::withMessages([
                    'mobile' => [$result['message']],
                ]);
            }

            // If AJAX request, return JSON
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $result['message'],
                    'mobile_masked' => $this->maskMobile($validated['mobile']),
                    'otp_id' => $result['otp_id'],
                ]);
            }

            // Otherwise redirect to verify form with session data
            return redirect()->route('otp.verify.form')
                ->with('success', $result['message'])
                ->with('mobile', $validated['mobile'])
                ->with('purpose', $validated['purpose']);

        } catch (\Exception $e) {
            Log::error('OTP send failed', [
                'error' => $e->getMessage(),
                'mobile' => $validated['mobile'] ?? 'unknown',
            ]);

            throw ValidationException::withMessages([
                'mobile' => ['Failed to send OTP. Please try again later.'],
            ]);
        }
    }

    /**
     * Show OTP verification form (GET /otp/verify)
     */
    public function showVerifyForm(Request $request)
    {
        $mobile = $request->query('mobile') ?? session('mobile');
        $purpose = $request->query('purpose') ?? session('purpose');

        if (!$mobile) {
            return redirect()->route('otp.send.form')
                ->with('error', 'Please request an OTP first.');
        }

        return view('otp.verify', [
            'mobile' => $mobile,
            'purpose' => $purpose,
        ]);
    }

    /**
     * Verify OTP (POST /otp/verify)
     */
    public function verify(Request $request)
    {
        $validated = $request->validate([
            'mobile' => ['required', 'regex:/^\+?[0-9]{10,15}$/'],
            'otp' => ['required', 'digits:6'],
            'purpose' => ['required', 'in:booking,manage_bookings'],
        ], [
            'otp.digits' => 'OTP must be 6 digits',
            'mobile.regex' => 'Invalid mobile number',
        ]);

        try {
            $result = $this->otpService->verifyOtp(
                $validated['mobile'],
                $validated['otp'],
                $validated['purpose']
            );

            if (!$result['success']) {
                throw ValidationException::withMessages([
                    'otp' => [$result['message']],
                ]);
            }

            // Log successful verification
            Log::info('OTP verified successfully', [
                'mobile' => $validated['mobile'],
                'purpose' => $validated['purpose'],
            ]);

            // Store verification in session
            session([
                'otp_verified' => true,
                'verified_mobile' => $validated['mobile'],
                'verified_purpose' => $validated['purpose'],
                'verified_at' => now()->timestamp,
            ]);

            // If AJAX request, return JSON
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'OTP verified successfully',
                    'redirect' => $this->getRedirectUrl($validated['purpose']),
                ]);
            }

            // Redirect based on purpose
            $redirectUrl = $this->getRedirectUrl($validated['purpose']);
            return redirect($redirectUrl)
                ->with('success', 'Mobile number verified successfully.');

        } catch (\Exception $e) {
            Log::error('OTP verification failed', [
                'error' => $e->getMessage(),
                'mobile' => $validated['mobile'] ?? 'unknown',
            ]);

            throw ValidationException::withMessages([
                'otp' => ['OTP verification failed. Please try again.'],
            ]);
        }
    }

    /**
     * Resend OTP (POST /otp/resend)
     */
    public function resend(Request $request)
    {
        $validated = $request->validate([
            'mobile' => ['required', 'regex:/^\+?[0-9]{10,15}$/'],
            'purpose' => ['required', 'in:booking,manage_bookings'],
        ]);

        try {
            $result = $this->otpService->generateAndSendOtp(
                $validated['mobile'],
                $validated['purpose']
            );

            if (!$result['success']) {
                throw ValidationException::withMessages([
                    'mobile' => [$result['message']],
                ]);
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $result['message'],
                ]);
            }

            return back()->with('success', $result['message']);

        } catch (\Exception $e) {
            Log::error('OTP resend failed', [
                'error' => $e->getMessage(),
                'mobile' => $validated['mobile'] ?? 'unknown',
            ]);

            throw ValidationException::withMessages([
                'mobile' => ['Failed to resend OTP. Please try again.'],
            ]);
        }
    }

    /**
     * Check if customer is OTP verified (AJAX endpoint)
     */
    public function checkVerification(Request $request)
    {
        $isVerified = session('otp_verified', false) === true;
        $verifiedMobile = session('verified_mobile');
        $verificationAge = $this->getVerificationAge();

        return response()->json([
            'verified' => $isVerified,
            'mobile' => $isVerified ? $this->maskMobile($verifiedMobile) : null,
            'age_seconds' => $verificationAge,
            'expire_seconds' => $isVerified ? (3600 - $verificationAge) : 0, // 1 hour expiry
        ]);
    }

    /**
     * Logout from OTP verification (clear session)
     */
    public function logout(Request $request)
    {
        session()->forget(['otp_verified', 'verified_mobile', 'verified_purpose', 'verified_at']);

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('home')
            ->with('success', 'Logged out successfully.');
    }

    /**
     * Get redirect URL based on OTP purpose
     */
    private function getRedirectUrl(string $purpose): string
    {
        return match ($purpose) {
            'booking' => route('booking.search.form'),
            'manage_bookings' => route('customer.bookings.index'),
            default => route('home'),
        };
    }

    /**
     * Mask mobile number for display (show only last 4 digits)
     */
    private function maskMobile(string $mobile): string
    {
        $cleaned = preg_replace('/[^0-9]/', '', $mobile);
        $length = strlen($cleaned);
        return str_repeat('*', $length - 4) . substr($cleaned, -4);
    }

    /**
     * Get age of current OTP verification in seconds
     */
    private function getVerificationAge(): int
    {
        $verifiedAt = session('verified_at');
        if (!$verifiedAt) {
            return 0;
        }

        return now()->timestamp - $verifiedAt;
    }
}
