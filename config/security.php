<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Security Headers
    |--------------------------------------------------------------------------
    |
    | Configure security headers to protect against common web vulnerabilities
    |
    */

    'headers' => [
        // Prevent clickjacking attacks
        'X-Frame-Options' => 'SAMEORIGIN',
        
        // Prevent MIME type sniffing
        'X-Content-Type-Options' => 'nosniff',
        
        // Enable XSS protection
        'X-XSS-Protection' => '1; mode=block',
        
        // Referrer policy
        'Referrer-Policy' => 'strict-origin-when-cross-origin',
        
        // Permissions policy
        'Permissions-Policy' => 'geolocation=(), microphone=(), camera=()',
    ],

    /*
    |--------------------------------------------------------------------------
    | File Upload Restrictions
    |--------------------------------------------------------------------------
    |
    | Configure allowed file types and maximum sizes for uploads
    |
    */

    'uploads' => [
        'images' => [
            'max_size' => 5120, // 5MB in kilobytes
            'allowed_mimes' => ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'],
            'allowed_extensions' => ['jpg', 'jpeg', 'png', 'webp'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    |
    | Configure rate limits for various endpoints
    |
    */

    'rate_limits' => [
        'enquiry' => [
            'max_attempts' => 3,
            'decay_minutes' => 60,
        ],
        'login' => [
            'max_attempts' => 5,
            'decay_minutes' => 1,
        ],
        'api' => [
            'max_attempts' => 60,
            'decay_minutes' => 1,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Input Sanitization
    |--------------------------------------------------------------------------
    |
    | Configure which HTML tags are allowed in user input
    |
    */

    'sanitization' => [
        'allowed_tags' => '<p><br><strong><em><u><a><ul><ol><li>',
        'strip_tags' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Session Security
    |--------------------------------------------------------------------------
    |
    | Configure session security settings
    |
    */

    'session' => [
        'lifetime' => 120, // minutes
        'expire_on_close' => false,
        'encrypt' => true,
        'http_only' => true,
        'same_site' => 'lax',
        'secure' => env('SESSION_SECURE_COOKIE', false),
    ],

];
