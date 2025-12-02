<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\OrderManagementController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\TestUploadController;

// User Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/category/{slug}', [HomeController::class, 'category'])->name('category');
Route::get('/category/{categorySlug}/product/{productSlug}', [HomeController::class, 'product'])->name('product');

// Cart & Order Routes
Route::post('/cart/add/{product}', [OrderController::class, 'addToCart'])->name('cart.add');
Route::delete('/cart/remove/{product}', [OrderController::class, 'removeFromCart'])->name('cart.remove');
Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
Route::post('/order', [OrderController::class, 'store'])->name('order.store');
Route::get('/payment/{orderNumber}', [OrderController::class, 'payment'])->name('payment');
Route::post('/payment/{orderNumber}/upload', [OrderController::class, 'uploadPaymentProof'])->name('payment.upload');
Route::get('/orders', [OrderController::class, 'history'])->name('orders.history')->middleware('auth');
Route::get('/order/{orderNumber}', [OrderController::class, 'detail'])->name('order.detail');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Auth Routes
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Protected Admin Routes
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Test Upload (untuk debug)
        Route::get('/test-upload', [TestUploadController::class, 'index'])->name('test-upload.index');
        Route::post('/test-upload', [TestUploadController::class, 'store'])->name('test-upload.store');

        // Category Management
        Route::resource('categories', CategoryController::class);

        // Product Management
        Route::resource('products', ProductController::class);

        // Account Management
        Route::resource('accounts', AccountController::class);

        // Order Management
        Route::get('orders', [OrderManagementController::class, 'index'])->name('orders.index');
        Route::get('orders/{id}', [OrderManagementController::class, 'show'])->name('orders.show');
        Route::put('orders/{id}/status', [OrderManagementController::class, 'updateStatus'])->name('orders.update-status');
        Route::delete('orders/{id}', [OrderManagementController::class, 'destroy'])->name('orders.destroy');

        // Payment Management
        Route::get('payments', [AdminPaymentController::class, 'index'])->name('payments.index');
        Route::get('payments/{id}', [AdminPaymentController::class, 'show'])->name('payments.show');
        Route::post('payments/{id}/approve', [AdminPaymentController::class, 'approve'])->name('payments.approve');
        Route::post('payments/{id}/reject', [AdminPaymentController::class, 'reject'])->name('payments.reject');
    });
});
