<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GlobalCategoryController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

// الصفحة الرئيسية - للجميع
Route::get('/', [HomeController::class, 'index'])->name('home');

// Search Routes
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/search/suggestions', [SearchController::class, 'suggestions'])->name('search.suggestions');

// Global Categories Routes
Route::get('/categories', [GlobalCategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{slug}', [GlobalCategoryController::class, 'show'])->name('categories.show');

// Store Routes
Route::get('/stores', [StoreController::class, 'index'])->name('stores.index');
Route::get('/stores/{slug}', [StoreController::class, 'show'])->name('stores.show');

// Product Routes
Route::get('/stores/{merchant}/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Cart Routes
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Checkout Routes

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
});

// Orders Routes
Route::middleware('auth')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});

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
