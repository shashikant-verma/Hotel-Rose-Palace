<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Register route middleware aliases
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminAuthenticate::class,
            'otp.verified' => \App\Http\Middleware\RequireOtpVerification::class,
        ]);

        // Exempt webhook and logout endpoints from CSRF verification
        $middleware->validateCsrfTokens(except: [
            'api/webhooks/razorpay',
            'webhooks/razorpay',
            'admin/logout',
            'otp/logout',
        ]);

        // Add security headers to all web requests
        $middleware->web(append: [
            \App\Http\Middleware\SecurityHeaders::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Gracefully handle expired sessions / CSRF token mismatches (prevent raw 419 error screens)
        $exceptions->respond(function ($response, Throwable $e, \Illuminate\Http\Request $request) {
            if ($response->getStatusCode() === 419) {
                if ($request->is('admin/*') || $request->is('admin')) {
                    return redirect()->route('admin.login')
                        ->with('error', 'Your session has expired. Please login again.');
                }

                return redirect()->route('home')
                    ->with('error', 'Your session has expired. Please try again.');
            }

            return $response;
        });
    })->create();
