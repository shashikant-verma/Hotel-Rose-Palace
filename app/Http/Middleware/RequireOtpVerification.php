<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequireOtpVerification
{
    public function handle(Request $request, Closure $next): Response
    {
        $isVerified = session('otp_verified', false) === true;

        if (!$isVerified) {
            $purpose = $request->is('my-bookings*') ? 'manage_bookings' : 'booking';
            return redirect()->route('otp.send.form', ['purpose' => $purpose])
                ->with('error', 'Please verify your email address to continue.');
        }

        $verifiedAt = session('verified_at');
        if ($verifiedAt && now()->timestamp - $verifiedAt > 3600) {
            session()->forget(['otp_verified', 'verified_email', 'verified_purpose', 'verified_at']);

            $purpose = $request->is('my-bookings*') ? 'manage_bookings' : 'booking';
            return redirect()->route('otp.send.form', ['purpose' => $purpose])
                ->with('error', 'Your verification has expired. Please verify again to continue.');
        }

        return $next($request);
    }
}
