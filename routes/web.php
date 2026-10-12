<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ===== Publik =====
Route::get('/', fn () => view('welcome'));
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// ===== Wajib login (semua role) =====
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

    // profil bawaan Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ===== Admin & Editor (lalu dipertajam oleh PostPolicy) =====
    Route::middleware('role:admin,editor')->group(function () {
        Route::resource('posts', PostController::class)->except(['index', 'show']);
    });

    // ===== Khusus Admin =====
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::patch('/users/{user}/role', [AdminController::class, 'updateRole'])->name('users.role');
        Route::get('/demo/eager-loading', [AdminController::class, 'eagerLoading'])->name('demo.eager');
    });
});

require __DIR__ . '/auth.php';
