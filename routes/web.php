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

// Legal Pages
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/cancellation', [PageController::class, 'cancellation'])->name('cancellation');

/**
 * Enquiry Routes
 */
Route::post('/enquiry', [EnquiryController::class, 'store'])->name('enquiry.store');
Route::get('/enquiry/success/{reference}', [EnquiryController::class, 'success'])->name('enquiry.success');

/**
 * Admin Routes
 */

// Admin Authentication Routes (accessible without login)
Route::prefix('admin')->name('admin.')->group(function () {
    // Login routes (guest only)
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    });

    // Logout (must be authenticated)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

    // Protected admin routes (require authentication)
    Route::middleware(['auth', 'admin'])->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Admin profile (placeholder routes for now)
        Route::get('/profile', [AuthController::class, 'showProfile'])->name('profile.show');
        Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');

        // Enquiries management
        Route::prefix('enquiries')->name('enquiries.')->group(function () {
            Route::get('/', function () {
                return view('admin.enquiries.index', [
                    'enquiries' => \App\Models\Enquiry::with('roomType')->latest()->paginate(15),
                ]);
            })->name('index');
            
            Route::get('/{enquiry}', function (\App\Models\Enquiry $enquiry) {
                return view('admin.enquiries.show', ['enquiry' => $enquiry->load('roomType')]);
            })->name('show');
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

        // Rooms Management - Full CRUD with Image Upload
        Route::prefix('rooms')->name('rooms.')->controller(\App\Http\Controllers\Admin\RoomController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{room}/edit', 'edit')->name('edit');
            Route::put('/{room}', 'update')->name('update');
            Route::delete('/{room}', 'destroy')->name('destroy');
            Route::patch('/{room}/toggle-availability', 'toggleAvailability')->name('toggle-availability');
            Route::post('/{room}/upload-images', 'uploadImages')->name('upload-images');
            Route::delete('/images/{image}', 'deleteImage')->name('delete-image');
            Route::patch('/images/{image}/set-featured', 'setFeaturedImage')->name('set-featured');
        });

        // Settings management (placeholder)
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/', function () {
                return view('admin.settings.index');
            })->name('index');
        });
    });
});
