<?php

use Illuminate\Support\Facades\Route;
use Modules\Api\Http\Controllers\Auth\ApiAuthController;
use Modules\Api\Http\Controllers\OTP\OtpController;
use Modules\Api\Http\Controllers\System\BannerController;
use Modules\Api\Http\Controllers\System\ShowroomController;
use Modules\Api\Http\Controllers\System\TestimonialController;
use Modules\Api\Http\Controllers\User\UserController;

// Authenticating Routes
Route::controller(ApiAuthController::class)->group(function () {
    Route::match(['get', 'post'], 'login', 'login');
    Route::post('register', 'register');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('logout', 'logout');
    });
});

// Send OTP Routes
Route::post('send-otp', [OtpController::class, 'sendOtp']);

// System Routes (Public) or (Guest) Mode
Route::middleware('guest')->group(function () {
    Route::get('banners', [BannerController::class, 'banners']);
    Route::get('testimonials', [TestimonialController::class, 'testimonials']);
    Route::get('showrooms', [ShowroomController::class, 'showrooms']);
});

// User Routes (Auth) or (User) Mode
Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [UserController::class, 'user']);
});

// Product Routes (Auth) or (Guest) Mode
Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [UserController::class, 'user']);
    Route::get('logout', [ApiAuthController::class, 'logout']);
});

