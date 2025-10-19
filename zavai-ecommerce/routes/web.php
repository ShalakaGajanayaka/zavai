<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductPageController;
use App\Http\Controllers\CartController;
use Inertia\Inertia;



Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Common for both admin & staff
    Route::resource('/products', ProductController::class);

    // Only admins can access user management
    Route::middleware('can:manage-users')->group(function () {
        Route::resource('/users', UserManagementController::class);
    });
});

Route::get('/products/{product}', [ProductPageController::class, 'show'])->name('products.show');
Route::post('/cart/{product}', [CartController::class, 'store'])->name('cart.store');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::delete('/cart/{product}', [CartController::class, 'destroy'])->name('cart.destroy');

require __DIR__ . '/auth.php';
