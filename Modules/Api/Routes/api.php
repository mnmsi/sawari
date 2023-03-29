<?php

use Illuminate\Support\Facades\Route;
use Modules\Api\Http\Controllers\Auth\ApiAuthController;
use Modules\Api\Http\Controllers\OTP\OtpController;
use Modules\Api\Http\Controllers\System\BannerController;
use Modules\Api\Http\Controllers\System\TestimonialController;
use Modules\Api\Http\Controllers\User\UserController;

Route::match(['get', 'post'], 'login', [ApiAuthController::class, 'login']);
Route::post('register', [ApiAuthController::class, 'register']);
Route::post('send-otp', [OtpController::class, 'sendOtp']);

Route::middleware('guest')->group(function () {
    Route::get('banners', [BannerController::class, 'banners']);
    Route::get('testimonials', [TestimonialController::class, 'testimonials']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [UserController::class, 'user']);
    Route::get('logout', [ApiAuthController::class, 'logout']);
});


