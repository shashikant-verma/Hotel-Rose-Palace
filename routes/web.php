<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;

/**
 * Public Website Routes
 */

// Home Page
Route::get('/', [PageController::class, 'home'])->name('home');

// About Page
Route::get('/about', [PageController::class, 'about'])->name('about');

// Rooms
Route::get('/rooms', [PageController::class, 'rooms'])->name('rooms');
Route::get('/rooms/{slug}', [PageController::class, 'roomDetail'])->name('room-detail');

// Gallery
Route::get('/gallery', [PageController::class, 'gallery'])->name('gallery');

// Amenities
Route::get('/amenities', [PageController::class, 'amenities'])->name('amenities');

// Contact
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'submitContact'])->name('contact.submit');

// Legal Pages
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/cancellation', [PageController::class, 'cancellation'])->name('cancellation');

/**
 * OTP Verification Routes
 */
Route::prefix('otp')->name('otp.')->group(function () {
    // Request OTP form
    Route::get('/send-request', [\App\Http\Controllers\OtpController::class, 'showSendForm'])
        ->name('send.form');
    
    // Send OTP
    Route::post('/send', [\App\Http\Controllers\OtpController::class, 'send'])
        ->name('send');
    
    // Verify OTP form
    Route::get('/verify', [\App\Http\Controllers\OtpController::class, 'showVerifyForm'])
        ->name('verify.form');
    
    // Verify OTP
    Route::post('/verify', [\App\Http\Controllers\OtpController::class, 'verify'])
        ->name('verify');
    
    // Resend OTP
    Route::post('/resend', [\App\Http\Controllers\OtpController::class, 'resend'])
        ->name('resend');
    
    // Check verification status (AJAX)
    Route::get('/check-verification', [\App\Http\Controllers\OtpController::class, 'checkVerification'])
        ->name('check-verification');
    
    // Logout (clear OTP verification)
    Route::post('/logout', [\App\Http\Controllers\OtpController::class, 'logout'])
        ->name('logout');
});

/**
 * Direct Booking Routes (Phase 8C)
 */
Route::prefix('booking')->name('booking.')->group(function () {
    // Search form (no auth required)
    Route::get('/search', [\App\Http\Controllers\BookingController::class, 'searchForm'])
        ->name('search.form');
    
    // Check availability via AJAX (no auth required)
    Route::post('/check-availability', [\App\Http\Controllers\BookingController::class, 'checkAvailability'])
        ->name('check-availability');
    
    // Protected routes (require OTP verification)
    Route::middleware('otp.verified')->group(function () {
        // Show booking form
        Route::get('/form', [\App\Http\Controllers\BookingController::class, 'showForm'])
            ->name('form');
        
        // Store booking (create temporary reservation)
        Route::post('/store', [\App\Http\Controllers\BookingController::class, 'store'])
            ->name('store');
        
        // Review booking before payment
        Route::get('/{booking}/review', [\App\Http\Controllers\BookingController::class, 'review'])
            ->name('review');
        
        // Check booking status
        Route::get('/{booking}/status', [\App\Http\Controllers\BookingController::class, 'status'])
            ->name('status');
        
        // Payment Processing (Phase 8D - Razorpay Full Online Payment)
        Route::get('/{booking}/payment', [\App\Http\Controllers\PaymentController::class, 'checkout'])
            ->name('payment');
        Route::post('/{booking}/payment/verify', [\App\Http\Controllers\PaymentController::class, 'verify'])
            ->name('payment.verify');
        Route::post('/{booking}/payment/failed', [\App\Http\Controllers\PaymentController::class, 'failed'])
            ->name('payment.failed');
    });
});

/**
 * Razorpay Webhook Routes (Phase 8D)
 */
Route::post('/api/webhooks/razorpay', [\App\Http\Controllers\RazorpayWebhookController::class, 'handle'])
    ->name('webhooks.razorpay');
Route::post('/webhooks/razorpay', [\App\Http\Controllers\RazorpayWebhookController::class, 'handle']);

/**
 * Customer Booking Management Routes (Phase 8E)
 */
Route::prefix('my-bookings')->name('customer.bookings.')->middleware('otp.verified')->group(function () {
    Route::get('/', [\App\Http\Controllers\CustomerBookingController::class, 'index'])->name('index');
    Route::get('/{booking}', [\App\Http\Controllers\CustomerBookingController::class, 'show'])->name('show');
    Route::get('/{booking}/confirmation', [\App\Http\Controllers\CustomerBookingController::class, 'confirmation'])->name('confirmation');
    Route::get('/{booking}/cancel', [\App\Http\Controllers\CustomerBookingController::class, 'showCancelForm'])->name('cancel');
    Route::post('/{booking}/cancel', [\App\Http\Controllers\CustomerBookingController::class, 'submitCancellation'])->name('cancel.submit');
});

// Backward-compatible alias for /customer/bookings -> /my-bookings
Route::get('/customer/bookings', fn() => redirect()->route('customer.bookings.index'))->middleware('otp.verified');

/**
 * Enquiry Routes (with rate limiting)
 */
Route::middleware(['throttle:enquiry'])->group(function () {
    Route::post('/enquiry', [EnquiryController::class, 'store'])->name('enquiry.store');
});
Route::get('/enquiry/success/{reference}', [EnquiryController::class, 'success'])->name('enquiry.success');

/**
 * Admin Routes
 */

// Admin Authentication Routes (accessible without login)
Route::prefix('admin')->name('admin.')->group(function () {
    // Admin index redirect to dashboard (or login if unauthenticated)
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    // Login routes (guest only)
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:login')->name('login.post');
    });

    // Logout (must be authenticated)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('admin');

    // Protected admin routes (require authentication)
    Route::middleware(['admin'])->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Admin profile (placeholder routes for now)
        Route::get('/profile', [AuthController::class, 'showProfile'])->name('profile.show');
        Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');

        // Enquiries Management - Full System & Reception PMS
        Route::prefix('enquiries')->name('enquiries.')->controller(\App\Http\Controllers\Admin\EnquiryController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/walk-in', 'storeWalkIn')->name('walk-in');
            Route::get('/{enquiry}', 'show')->name('show');
            Route::post('/{enquiry}/check-in', 'checkIn')->name('check-in');
            Route::post('/{enquiry}/check-out', 'checkOut')->name('check-out');
            Route::get('/{enquiry}/invoice', 'printInvoice')->name('invoice');
            Route::patch('/{enquiry}/status', 'updateStatus')->name('update-status');
            Route::patch('/{enquiry}/notes', 'updateNotes')->name('update-notes');
            Route::delete('/{enquiry}', 'destroy')->name('destroy');
            Route::post('/bulk-status', 'bulkUpdateStatus')->name('bulk-status');
            Route::post('/bulk-delete', 'bulkDelete')->name('bulk-delete');
            Route::get('/export/csv', 'export')->name('export');
        });

        // General Customer Contact Inquiries
        Route::prefix('contact-messages')->name('contact-messages.')->controller(\App\Http\Controllers\Admin\ContactMessageController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{id}', 'show')->name('show');
            Route::patch('/{id}/status', 'updateStatus')->name('update-status');
            Route::delete('/{id}', 'destroy')->name('destroy');
        });

        // Visual Room Occupancy Calendar
        Route::get('/calendar', [\App\Http\Controllers\Admin\CalendarController::class, 'index'])->name('calendar');

        // Banquet & Event Bookings
        Route::prefix('banquets')->name('banquets.')->controller(\App\Http\Controllers\Admin\BanquetController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::get('/{banquet}', 'show')->name('show');
            Route::put('/{banquet}', 'update')->name('update');
            Route::patch('/{banquet}/status', 'updateStatus')->name('update-status');
            Route::delete('/{banquet}', 'destroy')->name('destroy');
        });

        // Cancellation & Refund Management (Phase 8F)
        Route::prefix('cancellations')->name('cancellations.')->controller(\App\Http\Controllers\Admin\CancellationController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{booking}', 'show')->name('show');
            Route::post('/{booking}/approve', 'approve')->name('approve');
            Route::post('/{booking}/reject', 'reject')->name('reject');
            Route::post('/{booking}/retry', 'retryRefund')->name('retry');
        });

        // Room Types Management - Full CRUD
        Route::prefix('room-types')->name('room-types.')->controller(\App\Http\Controllers\Admin\RoomTypeController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{roomType}/edit', 'edit')->name('edit');
            Route::put('/{roomType}', 'update')->name('update');
            Route::delete('/{roomType}', 'destroy')->name('destroy');
            Route::patch('/{roomType}/toggle-status', 'toggleStatus')->name('toggle-status');
        });

        // Rooms Management - Full CRUD with Image Upload & Housekeeping
        Route::prefix('rooms')->name('rooms.')->controller(\App\Http\Controllers\Admin\RoomController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{room}/edit', 'edit')->name('edit');
            Route::put('/{room}', 'update')->name('update');
            Route::delete('/{room}', 'destroy')->name('destroy');
            Route::patch('/{room}/housekeeping', 'updateHousekeeping')->name('update-housekeeping');
            Route::patch('/{room}/toggle-availability', 'toggleAvailability')->name('toggle-availability');
            Route::post('/{room}/upload-images', 'uploadImages')->name('upload-images');
            Route::delete('/images/{image}', 'deleteImage')->name('delete-image');
            Route::patch('/images/{image}/set-featured', 'setFeaturedImage')->name('set-featured');
        });

        // Settings Management - Full System
        Route::prefix('settings')->name('settings.')->controller(\App\Http\Controllers\Admin\SettingsController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::put('/', 'update')->name('update');
            Route::post('/setting', 'updateSetting')->name('update-setting');
            Route::post('/store', 'store')->name('store');
            Route::delete('/{id}', 'destroy')->name('destroy');
        });

        // Gallery Management - Full System
        Route::prefix('gallery')->name('gallery.')->controller(\App\Http\Controllers\Admin\GalleryController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{gallery}/edit', 'edit')->name('edit');
            Route::put('/{gallery}', 'update')->name('update');
            Route::delete('/{gallery}', 'destroy')->name('destroy');
            Route::patch('/{gallery}/toggle-status', 'toggleStatus')->name('toggle-status');
            Route::post('/bulk-delete', 'bulkDelete')->name('bulk-delete');
            Route::post('/update-order', 'updateOrder')->name('update-order');
        });

        // Amenities Management - Full System
        Route::prefix('amenities')->name('amenities.')->controller(\App\Http\Controllers\Admin\AmenityController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{amenity}/edit', 'edit')->name('edit');
            Route::put('/{amenity}', 'update')->name('update');
            Route::delete('/{amenity}', 'destroy')->name('destroy');
            Route::patch('/{amenity}/toggle-status', 'toggleStatus')->name('toggle-status');
        });
    });
});
