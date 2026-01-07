<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated and has locale preference
        if (auth()->check() && auth()->user()->locale) {
            $locale = auth()->user()->locale;
        }
        // Otherwise check session
        elseif (Session::has('locale')) {
            $locale = Session::get('locale');
        }
        // Otherwise use browser language
        else {
            $locale = $request->getPreferredLanguage(config('app.available_locales'));
        }

        // Validate locale
        if (!in_array($locale, config('app.available_locales'))) {
            $locale = config('app.fallback_locale');
        }

        // Set application locale
        App::setLocale($locale);

        return $next($request);
    }
}
