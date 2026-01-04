<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// الصفحة الرئيسية - للجميع
Route::get('/', function () {
    return view('welcome');
})->name('home');

// لوحة تحكم المستخدم العادي
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Routes للأدمن
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

// Routes للتاجر
Route::prefix('merchant')->middleware(['auth', 'role:merchant'])->group(function () {
    Route::get('/', function () {
        return view('merchant.dashboard');
    })->name('merchant.dashboard');
});

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
