<?php

use Illuminate\Support\Facades\Route;
use Modules\Api\Http\Controllers\Auth\ApiAuthController;
use Modules\Api\Http\Controllers\OTP\OtpController;
use Modules\Api\Http\Controllers\Product\FeatureProductController;
use Modules\Api\Http\Controllers\Product\ProductBrandController;
use Modules\Api\Http\Controllers\Product\ProductCategoryController;
use Modules\Api\Http\Controllers\Product\ProductController;
use Modules\Api\Http\Controllers\System\BannerController;
use Modules\Api\Http\Controllers\System\ShowroomController;
use Modules\Api\Http\Controllers\System\TestimonialController;
use Modules\Api\Http\Controllers\User\UserAddressController;
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

    // Routes on user prefix
    Route::prefix('user')->group(function () {

        // Routes on user prefix
        Route::controller(UserController::class)->group(function () {
            Route::get('me', 'user');                     // User Info Routes
            Route::post('update', 'update');              // User Update Routes
        });

        // User Address List Routes
        Route::get('addresses', [UserAddressController::class, 'addresses']);  // User Address Routes
    });

    // Routes on address prefix
    Route::controller(UserAddressController::class)->prefix('address')->group(function () {
        Route::post('store', 'store');               // Address Store Routes
        Route::put('update/{id}', 'update');         // Address Update Routes
        Route::delete('delete/{id}', 'delete');      // Address Delete Routes
    });
});

// Product Routes (Auth) or (Guest) Mode
Route::middleware('guest')->group(function () {

    // Routes on product prefix
    Route::controller(ProductController::class)->prefix('product')->group(function () {
        Route::get('counts', 'totalProductType');    // Total Product Count
        Route::get('bikes', 'bikes');                // Product List Routes
    });

    // Routes on bike prefix for bike brand and bike category
    Route::controller(ProductBrandController::class)->group(function () {

        // Routes on bike prefix for bike brand and popular bike brand
        Route::prefix('bike')->group(function () {
            Route::get('brands', 'bikeBrands');                    // Product Brands
            Route::get('popular-brands', 'popularBikeBrands');     // Product Popular Brands
        });

        // Accessory Brand Route
        Route::prefix('accessory')->group(function () {
            Route::get('brands', 'accessoryBrands');                // Accessory Brands
            Route::get('popular-brands', 'popularAccessoryBrands'); // Accessory Popular Brands
        });
    });

    // Routes on accessory prefix for accessory category
    Route::controller(ProductCategoryController::class)->prefix('accessory')->group(function () {
        Route::get('categories', 'categories');                // Product Categories
        Route::get('popular-categories', 'popularCategories'); // Product Popular Categories
    });

    // Routes on feature prefix
    Route::controller(FeatureProductController::class)->prefix('featured')->group(function () {
        Route::get('new-bike', 'newBike');   // Feature new bikes
        Route::get('used-bike', 'usedBike'); // Feature used bikes
    });
});

