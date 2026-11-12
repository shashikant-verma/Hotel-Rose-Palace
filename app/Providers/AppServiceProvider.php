<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureRateLimiters();
    }

    /**
     * Configure the rate limiters for the application.
     * (Moved here from RouteServiceProvider which is not auto-registered in Laravel 12)
     */
    protected function configureRateLimiters(): void
    {
        // API Rate Limiting
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        // Enquiry Form Rate Limiting - 3 enquiries per hour per IP
        RateLimiter::for('enquiry', function (Request $request) {
            return Limit::perHour(3)->by($request->ip())->response(function () {
                return response()->json([
                    'message' => 'Too many enquiry requests. Please try again later.',
                ], 429);
            });
        });

        // Admin Login Rate Limiting - 5 attempts per minute per IP
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip())->response(function () {
                return redirect()->back()->withErrors([
                    'email' => 'Too many login attempts. Please try again in a few minutes.',
                ]);
            });
        });
    }
}
