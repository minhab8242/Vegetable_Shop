<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminCustomerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


// Home page
Route::get('/', [HomeController::class, 'index'])->name('home');



// Product routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// Category routes
Route::get('/categories', function () {
    return view('categories.index');
})->name('categories.index');

Route::get('/categories/{slug}', function ($slug) {
    return view('categories.show', compact('slug'));
})->name('categories.show');

// Cart routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/cart/confirm', [CartController::class, 'confirm'])->name('cart.confirm');

// Checkout routes
Route::get('/checkout', function () {
    $checkoutItems = session('checkout_items', []);
    $checkoutTotal = session('checkout_total', 0);

    if (empty($checkoutItems)) {
        return redirect()->route('cart.index')->with('error', 'Không có sản phẩm nào để thanh toán');
    }

    return view('checkout.index', compact('checkoutItems', 'checkoutTotal'));
})->name('checkout.index');

// API routes for user info
Route::get('/api/user-info', function () {
    if (!Auth::check()) {
        return response()->json(['success' => false, 'message' => 'Chưa đăng nhập']);
    }

    $user = Auth::user();
    return response()->json([
        'success' => true,
        'user' => [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone ?? null,
            'address' => $user->address ?? null,
        ]
    ]);
})->middleware('auth');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
});

// Review routes
Route::middleware('auth')->group(function () {
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});
Route::post('/reviews/{review}/helpful', [ReviewController::class, 'markHelpful'])->name('reviews.helpful');

Route::get('/products/{product}/reviews', [ReviewController::class, 'getProductReviews'])->name('reviews.index');

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->middleware('guest');

// Password reset routes
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetPasswordLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Email verification routes
Route::get('/email/verify', [AuthController::class, 'showVerificationNotice'])->name('verification.notice');
Route::get('/email/verify/{id}/{token}', [AuthController::class, 'verifyEmail'])->name('email.verify');
Route::post('/email/verification-notification', [AuthController::class, 'resendVerificationEmail'])->name('verification.resend');

// Static pages
Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

Route::get('/privacy', function () {
    return view('pages.privacy');
})->name('privacy');

Route::get('/terms', function () {
    return view('pages.terms');
})->name('terms');

Route::get('/refund', function () {
    return view('pages.refund');
})->name('refund');

// Admin routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');

    Route::middleware(['admin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        // Product management routes
        Route::resource('products', AdminProductController::class)->names([
            'index' => 'admin.products',
            'create' => 'admin.products.create',
            'store' => 'admin.products.store',
            'edit' => 'admin.products.edit',
            'update' => 'admin.products.update',
            'destroy' => 'admin.products.destroy',
        ]);

        // Category management routes
        Route::resource('categories', AdminCategoryController::class)->names([
            'index' => 'admin.categories',
            'create' => 'admin.categories.create',
            'store' => 'admin.categories.store',
            'edit' => 'admin.categories.edit',
            'update' => 'admin.categories.update',
            'destroy' => 'admin.categories.destroy',
        ]);

        // Order management routes
        Route::get('orders', [AdminOrderController::class, 'index'])->name('admin.orders');
        Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
        Route::post('orders/{order}/update-status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.update-status');

        // Customer management routes
        Route::resource('customers', AdminCustomerController::class)->names([
            'index' => 'admin.customers.index',
            'show' => 'admin.customers.show',
            'edit' => 'admin.customers.edit',
            'update' => 'admin.customers.update',
            'destroy' => 'admin.customers.destroy',
        ]);

        // Analytics API routes
        Route::get('api/analytics', [AdminController::class, 'getAnalyticsData'])->name('admin.api.analytics');
        Route::get('api/orders-chart', [AdminController::class, 'getOrdersChartData'])->name('admin.api.orders-chart');
        Route::get('api/revenue-chart', [AdminController::class, 'getRevenueChartData'])->name('admin.api.revenue-chart');
    });
});


Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
Route::post('/orders/{order}/receive', [OrderController::class, 'receive'])->name('orders.receive');
