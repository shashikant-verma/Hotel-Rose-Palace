<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequireOtpVerification
{
    /**
     * Handle an incoming request.
     *
     * Ensures customer has completed OTP verification within the last hour.
     * If not verified, redirects to OTP verification page.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if OTP is verified
        $isVerified = session('otp_verified', false) === true;
        
        if (!$isVerified) {
            $purpose = $request->is('my-bookings*') ? 'manage_bookings' : 'booking';
            return redirect()->route('otp.send.form', ['purpose' => $purpose])
                ->with('error', 'Please verify your mobile number to continue.');
        }

        // Check if verification has expired (1 hour)
        $verifiedAt = session('verified_at');
        if ($verifiedAt && now()->timestamp - $verifiedAt > 3600) {
            // Clear expired verification
            session()->forget(['otp_verified', 'verified_mobile', 'verified_purpose', 'verified_at']);
            
            $purpose = $request->is('my-bookings*') ? 'manage_bookings' : 'booking';
            return redirect()->route('otp.send.form', ['purpose' => $purpose])
                ->with('error', 'Your verification has expired. Please verify again to continue.');
        }

        return $next($request);
    }
}
