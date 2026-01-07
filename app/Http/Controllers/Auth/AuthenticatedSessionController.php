<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     * Smart redirect based on user role and merchant status
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // التوجيه الذكي حسب دور المستخدم وحالة التاجر
        $user = Auth::user();
        
        // Admin → لوحة تحكم الأدمن
        if ($user->isAdmin()) {
            return redirect()->intended('/admin');
        }
        
        // Merchant → التحقق من حالة الموافقة
        if ($user->isMerchant()) {
            $merchant = $user->merchant;
            
            // إذا لم يكن لديه ملف تاجر، أنشئ واحد
            if (!$merchant) {
                return redirect()->route('merchant.pending');
            }
            
            // التحقق من حالة التاجر
            return match($merchant->status) {
                'approved' => redirect()->intended('/merchant'),
                'rejected' => redirect()->route('merchant.rejected'),
                default => redirect()->route('merchant.pending'), // pending
            };
        }
        
        // Customer → الصفحة الرئيسية
        return redirect()->intended('/');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
