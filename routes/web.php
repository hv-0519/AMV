<?php

use App\Http\Controllers\Admin\BestSellerShowcaseController;
use App\Http\Controllers\Admin\CateringController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FranchiseController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SiteImageController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\OrderController as FrontOrderController;
use Illuminate\Support\Facades\Route;

// =============================================
// PUBLIC / FRONTEND ROUTES
// =============================================

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu', [HomeController::class, 'menu'])->name('menu');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'sendContact'])->name('contact.send');
Route::get('/catering', [HomeController::class, 'catering'])->name('catering');
Route::post('/catering', [HomeController::class, 'submitCatering'])->name('catering.submit');
Route::get('/franchise', [HomeController::class, 'franchise'])->name('franchise');
Route::post('/franchise', [HomeController::class, 'submitFranchise'])->name('franchise.submit');
Route::get('/gallery', [HomeController::class, 'gallery'])->name('gallery');
Route::get('/careers', [HomeController::class, 'careers'])->name('careers');
Route::get('/order', [FrontOrderController::class, 'index'])->name('order.index');
Route::post('/order', [FrontOrderController::class, 'store'])->name('order.store');
Route::get('/order/track', [FrontOrderController::class, 'latest'])->name('order.latest');

// Order confirmation (kept for backwards compatibility)
Route::get('/order/confirmation/{order}', [FrontOrderController::class, 'confirmation'])->name('order.confirmation');
Route::get('/order/confirmation/{order}/status', [FrontOrderController::class, 'status'])->name('order.status');

// Cart
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::patch('/update', [CartController::class, 'update'])->name('update');
    Route::delete('/remove', [CartController::class, 'remove'])->name('remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
});

// Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

// =============================================
// AUTH ROUTES
// =============================================

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// =============================================
// ADMIN ROUTES (admin middleware)
// =============================================

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {

    // Dashboard (admin only)
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard')->middleware('admin_only');

    // Menu Management (staff + admin)
    Route::resource('menu', MenuController::class)->except(['show'])->parameters(['menu' => 'menu_item']);

    // Orders Management (staff + admin)
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::delete('orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');

    // Admin-only routes
    Route::middleware('admin_only')->group(function () {

        // Stock Management
        Route::resource('stocks', StockController::class)->except(['show']);
        Route::get('stocks/{stock}/restock', [StockController::class, 'restock'])->name('stocks.restock');
        Route::post('stocks/{stock}/restock', [StockController::class, 'processRestock'])->name('stocks.processRestock');

        // Users
        Route::resource('users', UserController::class)->except(['create', 'store']);

        // Catering Requests
        Route::get('catering', [CateringController::class, 'index'])->name('catering.index');
        Route::get('catering/{catering}', [CateringController::class, 'show'])->name('catering.show');
        Route::patch('catering/{catering}/status', [CateringController::class, 'updateStatus'])->name('catering.updateStatus');

        // Franchise Enquiries
        Route::get('franchise', [FranchiseController::class, 'index'])->name('franchise.index');
        Route::get('franchise/{franchise}', [FranchiseController::class, 'show'])->name('franchise.show');
        Route::patch('franchise/{franchise}/status', [FranchiseController::class, 'updateStatus'])->name('franchise.updateStatus');

        // Website Images
        Route::get('site-images', [SiteImageController::class, 'index'])->name('site-images.index');
        Route::post('site-images/gallery', [SiteImageController::class, 'uploadGallery'])->name('site-images.gallery.upload');
        Route::delete('site-images/gallery/{galleryImage}', [SiteImageController::class, 'destroyGallery'])->name('site-images.gallery.destroy');
        Route::post('site-images/{siteImage}', [SiteImageController::class, 'update'])->name('site-images.update');
        Route::delete('site-images/{siteImage}', [SiteImageController::class, 'destroy'])->name('site-images.destroy');

        // Best Sellers Showcase
        Route::get('best-sellers', [BestSellerShowcaseController::class, 'index'])->name('best-sellers.index');
        Route::post('best-sellers', [BestSellerShowcaseController::class, 'store'])->name('best-sellers.store');
        Route::post('best-sellers/interval', [BestSellerShowcaseController::class, 'updateInterval'])->name('best-sellers.interval');
        Route::post('best-sellers/{bestSeller}/update', [BestSellerShowcaseController::class, 'update'])->name('best-sellers.update');
        Route::post('best-sellers/{bestSeller}/toggle', [BestSellerShowcaseController::class, 'toggleActive'])->name('best-sellers.toggle');
        Route::delete('best-sellers/{bestSeller}', [BestSellerShowcaseController::class, 'destroy'])->name('best-sellers.destroy');
    });
});
