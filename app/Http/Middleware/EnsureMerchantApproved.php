<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureMerchantApproved
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        
        // التحقق من أن المستخدم تاجر
        if (!$user || !$user->isMerchant()) {
            return redirect()->route('home');
        }
        
        // التحقق من وجود ملف التاجر
        $merchant = $user->merchant;
        
        if (!$merchant) {
            return redirect()->route('merchant.pending');
        }
        
        // التحقق من حالة التاجر
        if ($merchant->status === 'pending') {
            return redirect()->route('merchant.pending');
        }
        
        if ($merchant->status === 'rejected') {
            return redirect()->route('merchant.rejected');
        }
        
        // التاجر معتمد - السماح بالمرور
        return $next($request);
    }
}
