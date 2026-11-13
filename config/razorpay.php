<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Razorpay API Credentials
    |--------------------------------------------------------------------------
    |
    | Used for creating orders, verifying payments, fetching payment details,
    | and issuing automated refunds via the Razorpay API.
    |
    */
    'key_id' => env('RAZORPAY_KEY_ID', 'rzp_test_placeholder_key'),
    'key_secret' => env('RAZORPAY_KEY_SECRET', 'placeholder_secret_key'),
    'webhook_secret' => env('RAZORPAY_WEBHOOK_SECRET', 'placeholder_webhook_secret'),

    'currency' => 'INR',

    /*
    |--------------------------------------------------------------------------
    | Temporary Reservation Hold Duration
    |--------------------------------------------------------------------------
    |
    | Duration (in minutes) to hold rooms during the checkout and payment process.
    | Client-configurable via environment or admin settings.
    |
    */
    'reservation_duration_minutes' => (int) env('BOOKING_RESERVATION_DURATION_MINUTES', 15),

    /*
    |--------------------------------------------------------------------------
    | Branding & Checkout UI
    |--------------------------------------------------------------------------
    */
    'merchant_name' => 'Hotel Rose Palace',
    'theme_color' => '#6E2C3A', // Burgundy Rose brand color
    'api_base_url' => env('RAZORPAY_API_URL', 'https://api.razorpay.com/v1'),
];
