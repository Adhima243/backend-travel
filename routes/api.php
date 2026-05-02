<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\BlogPostController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\DestinationController;
use App\Http\Controllers\Api\FaqController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\TripController;
use App\Http\Controllers\Api\Admin\BlogPostController as AdminBlogPostController;
use App\Http\Controllers\Api\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Api\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Api\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Api\Admin\DestinationController as AdminDestinationController;
use App\Http\Controllers\Api\Admin\FaqController as AdminFaqController;
use App\Http\Controllers\Api\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Api\Admin\TripController as AdminTripController;
use App\Http\Controllers\Api\Admin\UserController as AdminUserController;

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::get('/destinations', [DestinationController::class, 'index']);
Route::get('/destinations/{destination:slug}', [DestinationController::class, 'show']);

Route::get('/trips', [TripController::class, 'index']);
Route::get('/trips/{trip:slug}', [TripController::class, 'show']);

Route::get('/blog', [BlogPostController::class, 'index']);
Route::get('/blog/{blogPost:slug}', [BlogPostController::class, 'show']);

Route::get('/faq', [FaqController::class, 'index']);
Route::post('/contact', [ContactController::class, 'store']);
Route::get('/reviews', [ReviewController::class, 'index']);

Route::middleware(['auth:sanctum', 'token.fresh'])->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', [AuthController::class, 'me']);

    Route::post('/bookings', [BookingController::class, 'store']);
    Route::get('/bookings', [BookingController::class, 'index']);
    Route::get('/bookings/{booking}', [BookingController::class, 'show']);

    Route::post('/reviews', [ReviewController::class, 'store']);
});

Route::middleware(['auth:sanctum', 'token.fresh', 'admin'])->prefix('admin')->group(function () {
    Route::get('/summary', [AdminDashboardController::class, 'summary']);

    Route::get('/users', [AdminUserController::class, 'index']);
    Route::post('/users', [AdminUserController::class, 'store']);
    Route::get('/users/{user}', [AdminUserController::class, 'show']);
    Route::put('/users/{user}', [AdminUserController::class, 'update']);
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy']);
    Route::post('/users/{user}/reset-password', [AdminUserController::class, 'resetPassword']);

    Route::get('/bookings', [AdminBookingController::class, 'index']);
    Route::post('/bookings', [AdminBookingController::class, 'store']);
    Route::get('/bookings/{booking}', [AdminBookingController::class, 'show']);
    Route::put('/bookings/{booking}', [AdminBookingController::class, 'update']);
    Route::delete('/bookings/{booking}', [AdminBookingController::class, 'destroy']);

    Route::get('/destinations', [AdminDestinationController::class, 'index']);
    Route::post('/destinations', [AdminDestinationController::class, 'store']);
    Route::get('/destinations/{destination}', [AdminDestinationController::class, 'show']);
    Route::put('/destinations/{destination}', [AdminDestinationController::class, 'update']);
    Route::delete('/destinations/{destination}', [AdminDestinationController::class, 'destroy']);

    Route::get('/trips', [AdminTripController::class, 'index']);
    Route::post('/trips', [AdminTripController::class, 'store']);
    Route::get('/trips/{trip}', [AdminTripController::class, 'show']);
    Route::put('/trips/{trip}', [AdminTripController::class, 'update']);
    Route::delete('/trips/{trip}', [AdminTripController::class, 'destroy']);

    Route::get('/blog', [AdminBlogPostController::class, 'index']);
    Route::post('/blog', [AdminBlogPostController::class, 'store']);
    Route::get('/blog/{blogPost}', [AdminBlogPostController::class, 'show']);
    Route::put('/blog/{blogPost}', [AdminBlogPostController::class, 'update']);
    Route::delete('/blog/{blogPost}', [AdminBlogPostController::class, 'destroy']);

    Route::get('/faq', [AdminFaqController::class, 'index']);
    Route::post('/faq', [AdminFaqController::class, 'store']);
    Route::get('/faq/{faq}', [AdminFaqController::class, 'show']);
    Route::put('/faq/{faq}', [AdminFaqController::class, 'update']);
    Route::delete('/faq/{faq}', [AdminFaqController::class, 'destroy']);

    Route::get('/reviews', [AdminReviewController::class, 'index']);
    Route::post('/reviews', [AdminReviewController::class, 'store']);
    Route::put('/reviews/{review}', [AdminReviewController::class, 'update']);
    Route::delete('/reviews/{review}', [AdminReviewController::class, 'destroy']);

    Route::get('/contacts', [AdminContactController::class, 'index']);
    Route::post('/contacts', [AdminContactController::class, 'store']);
    Route::get('/contacts/{contact}', [AdminContactController::class, 'show']);
    Route::put('/contacts/{contact}', [AdminContactController::class, 'update']);
    Route::delete('/contacts/{contact}', [AdminContactController::class, 'destroy']);
});
