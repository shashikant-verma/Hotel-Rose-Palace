<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\EnquiryController;

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
