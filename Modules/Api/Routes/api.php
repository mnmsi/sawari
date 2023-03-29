<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Api\Http\Controllers\Auth\ApiAuthController;
use Modules\Api\Http\Controllers\OTP\OtpController;

Route::match(['get', 'post'], 'login', [ApiAuthController::class, 'login']);
Route::post('register', [ApiAuthController::class, 'register']);
Route::post('send-otp', [OtpController::class, 'sendOtp']);

Route::middleware('auth:api')->get('/api', function (Request $request) {
    return $request->user();
});

