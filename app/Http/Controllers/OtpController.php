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

    public function showSendForm()
    {
        return view('otp.send-request');
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'purpose' => ['required', 'in:booking,manage_bookings'],
        ], [
            'email.email' => 'Please enter a valid email address.',
        ]);

        try {
            $result = $this->otpService->generateAndSendOtp(
                $validated['email'],
                $validated['purpose']
            );

            if (!$result['success']) {
                throw ValidationException::withMessages([
                    'email' => [$result['message']],
                ]);
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $result['message'],
                    'email_masked' => $this->maskEmail($validated['email']),
                    'otp_id' => $result['otp_id'],
                ]);
            }

            return redirect()->route('otp.verify.form')
                ->with('success', $result['message'])
                ->with('email', $validated['email'])
                ->with('purpose', $validated['purpose']);

        } catch (\Exception $e) {
            Log::error('OTP send failed', [
                'error' => $e->getMessage(),
                'email' => $validated['email'] ?? 'unknown',
            ]);

            throw ValidationException::withMessages([
                'email' => ['Failed to send OTP. Please try again later.'],
            ]);
        }
    }

    public function showVerifyForm(Request $request)
    {
        $email = $request->query('email') ?? session('email');
        $purpose = $request->query('purpose') ?? session('purpose');

        if (!$email) {
            return redirect()->route('otp.send.form')
                ->with('error', 'Please request an OTP first.');
        }

        return view('otp.verify', [
            'email' => $email,
            'purpose' => $purpose,
        ]);
    }

    public function verify(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'otp' => ['required', 'digits:6'],
            'purpose' => ['required', 'in:booking,manage_bookings'],
        ], [
            'otp.digits' => 'OTP must be 6 digits',
            'email.email' => 'Invalid email address',
        ]);

        try {
            $result = $this->otpService->verifyOtp(
                $validated['email'],
                $validated['otp'],
                $validated['purpose']
            );

            if (!$result['success']) {
                throw ValidationException::withMessages([
                    'otp' => [$result['message']],
                ]);
            }

            Log::info('OTP verified successfully', [
                'email' => $validated['email'],
                'purpose' => $validated['purpose'],
            ]);

            session([
                'otp_verified' => true,
                'verified_email' => $validated['email'],
                'verified_purpose' => $validated['purpose'],
                'verified_at' => now()->timestamp,
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'OTP verified successfully',
                    'redirect' => $this->getRedirectUrl($validated['purpose']),
                ]);
            }

            $redirectUrl = $this->getRedirectUrl($validated['purpose']);
            return redirect($redirectUrl)
                ->with('success', 'Email verified successfully.');

        } catch (\Exception $e) {
            Log::error('OTP verification failed', [
                'error' => $e->getMessage(),
                'email' => $validated['email'] ?? 'unknown',
            ]);

            throw ValidationException::withMessages([
                'otp' => ['OTP verification failed. Please try again.'],
            ]);
        }
    }

    public function resend(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'purpose' => ['required', 'in:booking,manage_bookings'],
        ]);

        try {
            $result = $this->otpService->generateAndSendOtp(
                $validated['email'],
                $validated['purpose']
            );

            if (!$result['success']) {
                throw ValidationException::withMessages([
                    'email' => [$result['message']],
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
                'email' => $validated['email'] ?? 'unknown',
            ]);

            throw ValidationException::withMessages([
                'email' => ['Failed to resend OTP. Please try again.'],
            ]);
        }
    }

    public function checkVerification(Request $request)
    {
        $isVerified = session('otp_verified', false) === true;
        $verifiedEmail = session('verified_email');
        $verificationAge = $this->getVerificationAge();

        return response()->json([
            'verified' => $isVerified,
            'email' => $isVerified ? $this->maskEmail($verifiedEmail) : null,
            'age_seconds' => $verificationAge,
            'expire_seconds' => $isVerified ? (3600 - $verificationAge) : 0,
        ]);
    }

    public function logout(Request $request)
    {
        session()->forget(['otp_verified', 'verified_email', 'verified_purpose', 'verified_at']);

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('home')
            ->with('success', 'Logged out successfully.');
    }

    private function getRedirectUrl(string $purpose): string
    {
        return match ($purpose) {
            'booking' => route('booking.search.form'),
            'manage_bookings' => route('customer.bookings.index'),
            default => route('home'),
        };
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

    private function getVerificationAge(): int
    {
        $verifiedAt = session('verified_at');
        if (!$verifiedAt) {
            return 0;
        }

        return now()->timestamp - $verifiedAt;
    }
}
