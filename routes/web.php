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
