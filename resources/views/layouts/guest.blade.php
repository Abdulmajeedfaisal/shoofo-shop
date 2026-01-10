<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
      dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}"
      x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" 
      x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))" 
      :class="{ 'dark': darkMode }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ app()->getLocale() === 'ar' ? 'شوفو' : 'SHOOFO' }}</title>
        
        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="font-inter antialiased bg-cream dark:bg-gray-900 min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-sm">
            <!-- Card -->
            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl border border-gray-100 dark:border-gray-700 p-6">
                <!-- Header: Back + Logo -->
                <div class="flex items-center justify-between mb-4">
                    <a href="/" class="text-slate dark:text-gray-400 hover:text-royal-gold transition-colors p-1">
                        <svg class="w-5 h-5 {{ app()->getLocale() === 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                    <a href="/" class="flex items-center">
                        <!-- Light Mode Logo -->
                        <img 
                            src="{{ asset('images/logo_shoofo_shop_1.png') }}" 
                            alt="{{ app()->getLocale() === 'ar' ? 'شوفو' : 'SHOOFO' }}"
                            class="h-10 w-auto dark:hidden"
                        >
                        <!-- Dark Mode Logo -->
                        <img 
                            src="{{ asset('images/logo_shoofo_shop_in_dark.png') }}" 
                            alt="{{ app()->getLocale() === 'ar' ? 'شوفو' : 'SHOOFO' }}"
                            class="h-10 w-auto hidden dark:block"
                        >
                    </a>
                    <div class="w-7"></div>
                </div>
                
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
