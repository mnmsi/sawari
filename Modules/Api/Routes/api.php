<?php

use Illuminate\Support\Facades\Route;
use Modules\Api\Http\Controllers\Auth\ApiAuthController;
use Modules\Api\Http\Controllers\Order\CartController;
use Modules\Api\Http\Controllers\Order\OrderController;
use Modules\Api\Http\Controllers\OTP\OtpController;
use Modules\Api\Http\Controllers\Product\AccessoryController;
use Modules\Api\Http\Controllers\Product\BikeController;
use Modules\Api\Http\Controllers\Product\FeatureController;
use Modules\Api\Http\Controllers\Product\BrandController;
use Modules\Api\Http\Controllers\Product\CategoryController;
use Modules\Api\Http\Controllers\Product\ProductController;
use Modules\Api\Http\Controllers\System\BannerController;
use Modules\Api\Http\Controllers\System\ColorController;
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
    Route::get('colors', [ColorController::class, 'colors']);                   // Color Routes

    // Routes on OrderController
    Route::controller(OrderController::class)->group(function () {
        Route::get('delivery-options', 'deliveryOptions'); // Delivery Options
        Route::get('payment-methods', 'paymentMethods');   // Payment Methods
    });
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
    Route::prefix('product')->group(function () {

        // Route for product count
        Route::get('counts', [ProductController::class, 'totalProductType']);          // Total Product Count
    });

    // Routes on BikeController
    Route::controller(BikeController::class)->group(function () {
        Route::get('bikes', 'bikes');                                                // Bikes Routes
        Route::get('related-bikes', 'relatedBikes');                                 // Related Bikes Routes
        Route::get('bike-body-types', 'bikeBodyTypes');                              // Related Bikes Routes
        Route::get('bike/details/{id}', 'details');                                  // Bike Details Routes
    });

    // Routes on AccessoryController
    Route::controller(AccessoryController::class)->group(function () {
        Route::get('accessories', 'accessories');                        // Accessories Routes
        Route::get('related-accessories', 'relatedAccessories');         // Related Accessories Routes
        Route::get('featured-accessories', 'featuredAccessories');        // Featured Accessories Routes
        Route::get('accessory/details/{id}', 'details');                 // Accessory Details Routes
    });

    // Routes on bike prefix for bike brand and bike category
    Route::controller(BrandController::class)->group(function () {

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

        Route::get('category/brands/{id}', 'categoryBrands');       // Accessory Category Brands
    });

    // Routes on accessory prefix for accessory category
    Route::controller(CategoryController::class)->prefix('accessory')->group(function () {
        Route::get('categories', 'categories');                // Product Categories
        Route::get('popular-categories', 'popularCategories'); // Product Popular Categories
    });

    // Routes on feature prefix
    Route::controller(FeatureController::class)->prefix('featured')->group(function () {
        Route::get('new-bike', 'newBike');   // Feature new bikes
        Route::get('used-bike', 'usedBike'); // Feature used bikes
    });

    // Routes on cart prefix
    Route::controller(CartController::class)->prefix('cart')->group(function () {
        Route::post('/', 'cart');                      // Cart Add/Increase/Decreased Routes
        Route::get('products', 'carts');               // Get Carted Products
        Route::delete('remove/{sku}', 'removeCart');   // Cart Remove Routes
    });
});

