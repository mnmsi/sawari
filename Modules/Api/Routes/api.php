<?php

use Illuminate\Support\Facades\Route;
use Modules\Api\Http\Controllers\Auth\ApiAuthController;
use Modules\Api\Http\Controllers\OTP\OtpController;
use Modules\Api\Http\Controllers\Product\FeatureProductController;
use Modules\Api\Http\Controllers\Product\ProductController;
use Modules\Api\Http\Controllers\System\BannerController;
use Modules\Api\Http\Controllers\System\ShowroomController;
use Modules\Api\Http\Controllers\System\TestimonialController;
use Modules\Api\Http\Controllers\User\UserController;

// Authenticating Routes
Route::controller(ApiAuthController::class)->group(function () {
    Route::match(['get', 'post'], 'login', 'login');
    Route::post('register', 'register');
    Route::get('logout', 'logout')->middleware('auth:sanctum');
});

Route::post('send-otp', [OtpController::class, 'sendOtp']); // Send OTP Routes

// System Routes (Public) or (Guest) Mode
Route::middleware('guest')->group(function () {
    Route::get('banners', [BannerController::class, 'banners']);                // Banner Routes
    Route::get('testimonials', [TestimonialController::class, 'testimonials']); // Testimonial Routes
    Route::get('showrooms', [ShowroomController::class, 'showrooms']);          // Showroom Routes
});

// User Routes (Auth) or (User) Mode
Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [UserController::class, 'user']); // User Info Routes
});

// Product Routes (Auth) or (Guest) Mode
Route::middleware('guest')->group(function () {
    // Routes on product prefix
    Route::prefix('product')->group(function () {
        Route::get('count', [ProductController::class, 'totalProductType']); // Total Product Count
    });

    // Routes on feature prefix
    Route::prefix('feature')->group(function () {
        Route::controller(FeatureProductController::class)->group(function () {
            Route::get('new-bike', 'newBike');   // Feature new bikes
            Route::get('used-bike', 'usedBike'); // Feature used bikes
        });
    });
});

