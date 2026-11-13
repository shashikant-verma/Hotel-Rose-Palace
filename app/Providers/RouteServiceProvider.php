<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * @var string
     */
    public const HOME = '/admin/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        // API Rate Limiting
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        // OTP Rate Limiting - Form views (higher limit for just viewing)
        RateLimiter::for('otp_form', function (Request $request) {
            return Limit::perMinute(10)->by($request->ip());
        });

        // OTP Send Rate Limiting - 3 OTP requests per mobile per 15 minutes
        // (enforced in OtpService via Cache, this is additional HTTP-level throttle)
        RateLimiter::for('otp_send', function (Request $request) {
            return Limit::perMinute(3)->by($request->ip())->response(function () {
                return response()->json([
                    'message' => 'Too many OTP requests. Please wait before trying again.',
                ], 429);
            });
        });

        // OTP Verify Rate Limiting - 5 verification attempts per minute per IP
        RateLimiter::for('otp_verify', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip())->response(function () {
                return response()->json([
                    'message' => 'Too many verification attempts. Please try again later.',
                ], 429);
            });
        });

        // OTP Resend Rate Limiting - 3 resend attempts per 10 minutes
        RateLimiter::for('otp_resend', function (Request $request) {
            return Limit::perMinutes(10, 3)->by($request->ip())->response(function () {
                return response()->json([
                    'message' => 'Too many resend attempts. Please try again later.',
                ], 429);
            });
        });

        // Enquiry Form Rate Limiting - 3 enquiries per hour per IP
        RateLimiter::for('enquiry', function (Request $request) {
            return Limit::perHour(3)->by($request->ip())->response(function () {
                return response()->json([
                    'message' => 'Too many enquiry requests. Please try again later.',
                ], 429);
            });
        });

        // Admin Login Rate Limiting - 5 attempts per minute
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip())->response(function () {
                return redirect()->back()->withErrors([
                    'email' => 'Too many login attempts. Please try again in a few minutes.',
                ]);
            });
        });
    }
}
