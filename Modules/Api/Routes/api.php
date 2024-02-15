<?php

use Illuminate\Support\Facades\Route;
use Modules\Api\Http\Controllers\Auth\ApiAuthController;
use Modules\Api\Http\Controllers\Cart\GuestCartController;
use Modules\Api\Http\Controllers\Guest\GuestOrderController;
use Modules\Api\Http\Controllers\Order\CartController;
use Modules\Api\Http\Controllers\Order\OrderController;
use Modules\Api\Http\Controllers\Order\ShippingChargeController;
use Modules\Api\Http\Controllers\OTP\OtpController;
use Modules\Api\Http\Controllers\Product\AccessoryController;
use Modules\Api\Http\Controllers\Product\BikeController;
use Modules\Api\Http\Controllers\Product\FeatureController;
use Modules\Api\Http\Controllers\Product\BrandController;
use Modules\Api\Http\Controllers\Product\CategoryController;
use Modules\Api\Http\Controllers\Product\ProductController;
use Modules\Api\Http\Controllers\Product\ReviewController;
use Modules\Api\Http\Controllers\Product\WishListController;
use Modules\Api\Http\Controllers\SellBike\SellBikeController;
use Modules\Api\Http\Controllers\System\BannerController;
use Modules\Api\Http\Controllers\System\BookAppointmentController;
use Modules\Api\Http\Controllers\System\ColorController;
use Modules\Api\Http\Controllers\System\HomePageSectionController;
use Modules\Api\Http\Controllers\System\PreOrderController;
use Modules\Api\Http\Controllers\System\PrivacyPolicyController;
use Modules\Api\Http\Controllers\System\SeoSettingController;
use Modules\Api\Http\Controllers\System\ShowroomController;
use Modules\Api\Http\Controllers\System\SiteSettingController;
use Modules\Api\Http\Controllers\System\SystemAddressController;
use Modules\Api\Http\Controllers\System\TermsConditionController;
use Modules\Api\Http\Controllers\System\TestimonialController;
use Modules\Api\Http\Controllers\System\VideoReviewController;
use Modules\Api\Http\Controllers\User\UserAddressController;
use Modules\Api\Http\Controllers\User\UserController;
use Modules\Api\Http\Traits\OTP\OtpTrait;

// Authenticating Routes
Route::controller(ApiAuthController::class)->group(function () {
    Route::match(['get', 'post'], 'login', 'login');
    Route::post('register', 'register');
    Route::post('forgot-password', 'forgotPassword');
    Route::post('reset-password', 'resetPassword');
    Route::get('logout', 'logout')->middleware('auth:sanctum');
});

Route::post('send-otp', [OtpController::class, 'sendOtp']);     // Send OTP Routes
Route::post('verify-otp', [OtpController::class, 'verifyOtp']); // Verify OTP Routes // Verify Phone Number Routes

// System Routes (Public) or (Guest) Mode
Route::middleware('guest')->group(function () {

    Route::get('site-settings', [SiteSettingController::class, 'siteSettings']); //-------------Cached
    Route::get('seo-settings', [SeoSettingController::class, 'seoSettings']);    //-------------Cached
    Route::get('banners', [BannerController::class, 'banners']);                 // Banner Routes //-------------Cached
    Route::get('testimonials', [TestimonialController::class, 'testimonials']);  // Testimonial Routes //-------------Cached
    Route::get('showrooms', [ShowroomController::class, 'showrooms']);           // Showroom Routes //-------------Cached
    Route::get('colors', [ColorController::class, 'colors']);                    // Color Routes //-------------Cached
    Route::get('video-review', [VideoReviewController::class, 'index']);        // Video Review Routes //-------------Cached

    // Routes on OrderController
    Route::controller(OrderController::class)->group(function () {
        Route::get('delivery-options', 'deliveryOptions'); // Delivery Options //-------------Cached
        Route::get('payment-methods', 'paymentMethods');   // Payment Methods// Shipping Charges //-------------Cached
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
        Route::post('store', 'store');                                   // Address Store Routes
        Route::put('update/{id}', 'update');                             // Address Update Routes
        Route::delete('delete/{id}', 'delete');                          // Address Delete Routes

        //        selected address
        Route::get('selected-address/{id?}', 'getSelectedAddress');      // Address Delete Routes
    });

    //   System Address Routes


    //        add review
    Route::controller(ReviewController::class)->group(function () {
        Route::post('product/add-review', 'store');
    });

    //        Wishlist
    Route::controller(WishlistController::class)->prefix("wishlist")->group(function () {
        Route::post('add', 'store');
        Route::get('list', 'list');
    });

    // Routes on cart prefix
    Route::controller(CartController::class)->prefix('cart')->group(function () {
        Route::get('/', 'carts');                               // Cart Add/Increase/Decreased Routes
        Route::post('add', 'store');                            // Get Carted Products
        Route::delete('remove/{id}', 'removeCart');             // Cart Remove Routes
        Route::post('update', 'updateCart');                    // Cart Update Routes
        Route::get('selected-product', 'getSelectedProduct');   // Cart Update Routes
    });

    Route::post('make-order', [OrderController::class, 'order']);
    Route::get('order-list', [OrderController::class, 'orderList']); // Make Order Routes

    Route::post('buy-now/make-order', [OrderController::class, 'makeOrderFromBuyNow']); // Buy Now Routes
});

Route::get('product/suggestion', [ProductController::class, 'getProductSuggestion']); // Product Review

// Product Routes (Auth) or (Guest) Mode
Route::middleware('guest')->group(function () {

    // Routes on product prefix
    Route::prefix('product')->group(function () {

        // Route for product count
        Route::get('counts', [ProductController::class, 'totalProductType']);          // Total Product Count
        Route::get('review/{id}', [ReviewController::class, 'review']);                // Product Review
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

    //        Route on Terms and Condition
    Route::controller(TermsConditionController::class)->group(function () {
        Route::get('terms', 'terms');
    });

    //        Route on Privacy Policy
    Route::controller(PrivacyPolicyController::class)->group(function () {
        Route::get('privacy-policy', 'privacyPolicy');
    });

    //        Sell Bike
    Route::controller(SellBikeController::class)->prefix('sell')->group(function () {
        Route::get('bike/{brand_id}', 'bikeByBrand');
    });

    Route::get('shipping-charges/{name?}', [ShippingChargeController::class, 'shippingCharges']);
});

//Route::get('bike/details/{name}', [BikeController::class, 'details']);
// Routes on feature prefix
Route::middleware('product')->group(function () {
    Route::controller(FeatureController::class)->prefix('featured')->group(function () {
        Route::get('new-bike', 'newBike');   // Feature new bikes
        Route::get('used-bike', 'usedBike'); // Feature used bikes
    });

    Route::controller(BikeController::class)->group(function () {
        Route::get('bikes', 'bikes');                                                  // Bikes Routes
        Route::get('related-bikes', 'relatedBikes');                                   // Related Bikes Routes
        Route::get('bike-body-types', 'bikeBodyTypes');                                // Related Bikes Routes
        Route::get('bike/details/{name}', 'details');                                  // Bike Details Routes
    });

    Route::controller(AccessoryController::class)->group(function () {
        Route::get('accessories', 'accessories');                          // Accessories Routes
        Route::get('related-accessories', 'relatedAccessories');           // Related Accessories Routes
        Route::get('featured-accessories', 'featuredAccessories');         // Featured Accessories Routes
        Route::get('accessory/details/{name}', 'details');                 // Accessory Details Routes
    });

    Route::get('home-page-sections', [HomePageSectionController::class, 'homePageSections']);
    Route::get('scooter', [BikeController::class, 'scooter']);
    Route::get('upcoming-bikes', [BikeController::class, 'upcomingBikes']);
});

Route::controller(PreOrderController::class)->prefix('pre-order')->group(function () {
    Route::post('/store', 'store');
});

Route::post('/book-appointment', [BookAppointmentController::class, 'store']);

// guest cart
Route::prefix('guest-cart')->middleware('api-session')->as('guest-cart.')->controller(GuestCartController::class)->group(function () {
    Route::post('add', 'store')->name('add');
    Route::get('list/{id}', 'getCartProduct')->name('list');
    Route::Post('/delete', 'removeProductFromCart')->name('remove');
    Route::post('update', 'updateCart')->name('update');
    Route::get('selected-product/{id}', 'getSelectedCartProduct')->name('selected-product');
});

Route::prefix('guest-order')->middleware('api-session')->as('guest-order.')->controller(GuestOrderController::class)->group(function () {
    Route::post('buy-now', 'guestOrder')->name('buy-now');
});

Route::post('create-guest-user', [GuestCartController::class, 'createGuestUser']);

Route::controller(SystemAddressController::class)->group(function () {
    Route::get('divisions', 'division');
    Route::get('city/{id?}', 'city');
    Route::get('area/{id?}', 'area');
});

Route::post('buy-now', [OrderController::class, 'buyNow']); // Buy Routes now
Route::post("sell/store", [SellBikeController::class, 'store']);

//Route::get('/send-sms',[OtpController::class,'sendTestSMS']);
