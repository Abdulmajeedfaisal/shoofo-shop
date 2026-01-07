<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GlobalCategoryController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

// الصفحة الرئيسية - للجميع
Route::get('/', [HomeController::class, 'index'])->name('home');

// Global Categories Routes
Route::get('/categories', [GlobalCategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{slug}', [GlobalCategoryController::class, 'show'])->name('categories.show');

// Store Routes
Route::get('/stores', [StoreController::class, 'index'])->name('stores.index');
Route::get('/stores/{slug}', [StoreController::class, 'show'])->name('stores.show');

// Product Routes
Route::get('/stores/{merchant}/products/{product}', [ProductController::class, 'show'])->name('products.show');

Route::get('/cart', function () {
    return redirect()->route('home');
})->middleware('auth')->name('cart.index');

// Temporary cart.add route (will be implemented in Phase 9)
Route::post('/cart/add/{product}', function () {
    return redirect()->back()->with('success', 'Product added to cart');
})->middleware('auth')->name('cart.add');

Route::get('/orders', function () {
    return redirect()->route('home');
})->middleware('auth')->name('orders.index');

// Language Switcher
Route::get('/locale/{locale}', function ($locale) {
    if (in_array($locale, config('app.available_locales'))) {
        Session::put('locale', $locale);
        
        // If user is authenticated, save preference to database
        if (auth()->check()) {
            auth()->user()->update(['locale' => $locale]);
        }
    }
    
    return redirect()->back();
})->name('locale.switch');

// لوحة تحكم المستخدم العادي
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// صفحة انتظار موافقة التاجر
Route::get('/merchant/pending', function () {
    // التحقق من أن المستخدم تاجر
    if (!auth()->check() || !auth()->user()->isMerchant()) {
        return redirect()->route('home');
    }
    
    // إذا كان التاجر معتمد، وجهه للوحة التحكم
    $merchant = auth()->user()->merchant;
    if ($merchant && $merchant->status === 'approved') {
        return redirect('/merchant');
    }
    
    return view('merchant.pending');
})->middleware('auth')->name('merchant.pending');

// صفحة رفض التاجر
Route::get('/merchant/rejected', function () {
    if (!auth()->check() || !auth()->user()->isMerchant()) {
        return redirect()->route('home');
    }
    
    return view('merchant.rejected');
})->middleware('auth')->name('merchant.rejected');

// ملاحظة: Filament Admin Panel يعمل على /admin
// راجع: app/Providers/Filament/AdminPanelProvider.php

// ملاحظة: Filament Merchant Panel يعمل على /merchant
// راجع: app/Providers/Filament/MerchantPanelProvider.php

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
