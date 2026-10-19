<?php

use Illuminate\Support\Facades\Route;

// Admin Controllers
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;

// Storefront Controllers
use App\Http\Controllers\Storefront\AuthController as StorefrontAuthController;
use App\Http\Controllers\Storefront\CartController;
use App\Http\Controllers\Storefront\CategoryController;
use App\Http\Controllers\Storefront\CheckoutController;
use App\Http\Controllers\Storefront\OrderController;
use App\Http\Controllers\Storefront\ProductController as StorefrontProductController;
use App\Http\Controllers\Storefront\WishlistController;
use App\Http\Controllers\Storefront\ReviewController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Storefront\RegisterController;
use App\Http\Controllers\Storefront\ContactController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;


/*
|--------------------------------------------------------------------------
| Storefront
|--------------------------------------------------------------------------
*/





 // Home
Route::get('/', function () {
    $categories = \App\Models\Category::where('is_active', true)
        ->orderBy('sort_order')
        ->orderBy('name')
        ->take(12)
        ->get();

    $featuredProducts = \App\Models\Product::with(['category', 'brand', 'images'])
        ->where('status', 'published')
        ->where('featured', true)
        ->latest()
        ->take(8)
        ->get();

    return view('home', compact('categories', 'featuredProducts'));
})->name('home');


// Customer Authentication
Route::get('/login', [StorefrontAuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [StorefrontAuthController::class, 'login'])
    ->name('login.submit');

Route::post('/logout', [StorefrontAuthController::class, 'logout'])
    ->name('logout');


// Customer Registration
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])
    ->middleware('guest')
    ->name('register');

Route::post('/register', [RegisterController::class, 'register'])
    ->middleware('guest')
    ->name('register.submit');


//Contact Details

Route::get('/contact', [ContactController::class, 'index'])
    ->name('contact.index');

Route::post('/contact', [ContactController::class, 'store'])
    ->name('contact.store');





 // Categories
Route::get('/categories', [CategoryController::class, 'index'])
    ->name('categories.index');

Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])
    ->name('categories.show');



// Products
Route::get('/products', [StorefrontProductController::class, 'index'])
    ->name('products.index');

Route::get('/products/{product:slug}', [StorefrontProductController::class, 'show'])
    ->name('products.show');


// Cart
Route::get('/cart', [CartController::class, 'index'])
    ->name('cart.index');

Route::post('/cart/add/{product}', [CartController::class, 'add'])
    ->name('cart.add');

Route::post('/cart/update/{product}', [CartController::class, 'update'])
    ->name('cart.update');

Route::post('/cart/remove/{product}', [CartController::class, 'remove'])
    ->name('cart.remove');

Route::post('/cart/clear', [CartController::class, 'clear'])
    ->name('cart.clear');


// Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])
    ->middleware('auth')
    ->name('checkout.index');

Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])
    ->middleware('auth')
    ->name('checkout.place-order');


// Stripe Payment
Route::middleware('auth')->group(function () {
    Route::get('/stripe/checkout/{order}', [
        \App\Http\Controllers\Storefront\StripePaymentController::class,
        'createCheckoutSession',
    ])->name('stripe.checkout');

    Route::get('/stripe/success', [
        \App\Http\Controllers\Storefront\StripePaymentController::class,
        'success',
    ])->name('stripe.success');

    Route::get('/stripe/cancel/{order}', [
        \App\Http\Controllers\Storefront\StripePaymentController::class,
        'cancel',
    ])->name('stripe.cancel');
});    



Route::post('/stripe/webhook', [
    \App\Http\Controllers\Storefront\StripePaymentController::class,
    'webhook',
])->name('stripe.webhook');

//Review 
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])
    ->middleware('auth')
    ->name('reviews.store');


// Order Confirmation
Route::get('/order-confirmation/{order}', function (\App\Models\Order $order) {

    abort_unless($order->user_id === auth()->id(), 403);

    $order->load('items');

    return view('storefront.orders.confirmation', [
        'order' => $order
    ]);

})->middleware('auth')->name('orders.confirmation');


/*
|--------------------------------------------------------------------------
| Customer Account
|--------------------------------------------------------------------------
*/

Route::get('/account', function () {

    $ordersCount = auth()->user()->orders()->count();
    $wishlistCount = auth()->user()->wishlists()->count();

    return view('storefront.account.index', compact(
        'ordersCount',
        'wishlistCount'
    ));

})->middleware('auth')->name('account.index');


// My Orders
Route::middleware('auth')->group(function () {

    Route::get('/account/orders', [OrderController::class, 'index'])
        ->name('account.orders');

    Route::get('/account/orders/{order}', [OrderController::class, 'show'])
        ->name('account.orders.show');

});


// Wishlist
Route::middleware('auth')->group(function () {

    Route::get('/wishlist', [WishlistController::class, 'index'])
        ->name('wishlist.index');

    Route::post('/wishlist/add/{product}', [WishlistController::class, 'add'])
        ->name('wishlist.add');

    Route::post('/wishlist/remove/{product}', [WishlistController::class, 'remove'])
        ->name('wishlist.remove');

});


/*
|--------------------------------------------------------------------------
| Admin Authentication
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])
    ->name('admin.login');

Route::post('/admin/login', [AdminAuthController::class, 'login'])
    ->name('admin.login.submit');

Route::post('/admin/logout', [AdminAuthController::class, 'logout'])
    ->name('admin.logout');


/*
|--------------------------------------------------------------------------
| Admin Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware('auth')->name('admin.dashboard');


/*
|--------------------------------------------------------------------------
| Admin Products, Categories & Reviews
|--------------------------------------------------------------------------
*/

Route::middleware('auth')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Products
        Route::resource('products', AdminProductController::class);

        // Categories
        Route::resource('categories', AdminCategoryController::class);

        // Reviews
        Route::get('/reviews', [AdminReviewController::class, 'index'])
            ->name('reviews.index');

        Route::post('/reviews/{review}/approve', [AdminReviewController::class, 'approve'])
            ->name('reviews.approve');

        Route::post('/reviews/{review}/reject', [AdminReviewController::class, 'reject'])
            ->name('reviews.reject');

        Route::delete('/reviews/{review}', [AdminReviewController::class, 'destroy'])
            ->name('reviews.destroy');
    });