<nav x-data="{ mobileMenuOpen: false }" class="bg-white dark:bg-gray-900 shadow-elegant sticky top-0 z-50 backdrop-blur-luxury border-b border-gray-100 dark:border-gray-800 transition-smooth">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20 md:h-24">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="flex items-center group">
                    <div class="flex flex-col">
                        <span class="font-playfair text-xl md:text-2xl lg:text-3xl font-bold text-midnight dark:text-white group-hover:text-royal-gold transition-elegant">
                            {{ app()->getLocale() === 'ar' ? 'شوفو' : 'SHOOFO' }}
                        </span>
                        <span class="text-royal-gold text-[10px] md:text-xs font-inter tracking-wider hidden sm:block">
                            {{ app()->getLocale() === 'ar' ? 'سوق رقمي فاخر' : 'Luxury Digital Mall' }}
                        </span>
                    </div>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center gap-8">
                <a href="{{ route('home') }}" class="font-inter font-medium text-base text-charcoal dark:text-gray-300 hover:text-royal-gold transition-elegant relative group">
                    {{ app()->getLocale() === 'ar' ? 'الرئيسية' : 'Home' }}
                    <span class="absolute bottom-0 {{ app()->getLocale() === 'ar' ? 'right-0' : 'left-0' }} w-0 h-0.5 bg-royal-gold group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="{{ route('categories.index') }}" class="font-inter font-medium text-base text-charcoal dark:text-gray-300 hover:text-royal-gold transition-elegant relative group">
                    {{ app()->getLocale() === 'ar' ? 'الفئات' : 'Categories' }}
                    <span class="absolute bottom-0 {{ app()->getLocale() === 'ar' ? 'right-0' : 'left-0' }} w-0 h-0.5 bg-royal-gold group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="{{ route('stores.index') }}" class="font-inter font-medium text-base text-charcoal dark:text-gray-300 hover:text-royal-gold transition-elegant relative group">
                    {{ app()->getLocale() === 'ar' ? 'المتاجر' : 'Stores' }}
                    <span class="absolute bottom-0 {{ app()->getLocale() === 'ar' ? 'right-0' : 'left-0' }} w-0 h-0.5 bg-royal-gold group-hover:w-full transition-all duration-300"></span>
                </a>
            </div>

            <!-- Right Side -->
            <div class="flex items-center gap-2 md:gap-4">
                <!-- Dark Mode Toggle -->
                <button 
                    @click="darkMode = !darkMode" 
                    class="p-2 text-charcoal dark:text-gray-300 hover:text-royal-gold transition-elegant hover:bg-cream dark:hover:bg-gray-800 rounded-lg"
                >
                    <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                    </svg>
                </button>

                <!-- Language Switcher (Desktop) -->
                <div class="hidden md:block">
                    <x-language-switcher />
                </div>

                <!-- Cart Icon -->
                @auth
                <a href="{{ route('cart.index') }}" class="relative p-2 text-charcoal dark:text-gray-300 hover:text-royal-gold transition-elegant hover:bg-cream dark:hover:bg-gray-800 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    @if(auth()->user()->cart && auth()->user()->cart->items->count() > 0)
                    <span class="absolute -top-1 {{ app()->getLocale() === 'ar' ? '-left-1' : '-right-1' }} bg-royal-gold text-midnight text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center shadow-md">
                        {{ auth()->user()->cart->items->sum('quantity') }}
                    </span>
                    @endif
                </a>
                @endauth

                <!-- User Menu (Desktop) -->
                @auth
                <div x-data="{ open: false }" class="relative hidden md:block">
                    <button @click="open = !open" class="flex items-center gap-2 p-2 text-charcoal dark:text-gray-300 hover:text-royal-gold transition-elegant hover:bg-cream dark:hover:bg-gray-800 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span class="text-sm font-medium hidden lg:inline">{{ auth()->user()->name }}</span>
                    </button>
                    
                    <div 
                        x-show="open" 
                        @click.away="open = false"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        class="absolute {{ app()->getLocale() === 'ar' ? 'left-0' : 'right-0' }} mt-2 w-48 bg-white dark:bg-gray-800 rounded-xl shadow-elegant-lg overflow-hidden border border-gray-100 dark:border-gray-700"
                        style="display: none;"
                    >
                        <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700">
                            <p class="text-sm font-medium text-charcoal dark:text-white">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate dark:text-gray-400 truncate">{{ auth()->user()->email }}</p>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-3 text-charcoal dark:text-gray-300 hover:bg-cream dark:hover:bg-gray-700 hover:text-royal-gold transition-elegant">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            {{ app()->getLocale() === 'ar' ? 'الملف الشخصي' : 'Profile' }}
                        </a>
                        <a href="{{ route('orders.index') }}" class="flex items-center gap-2 px-4 py-3 text-charcoal dark:text-gray-300 hover:bg-cream dark:hover:bg-gray-700 hover:text-royal-gold transition-elegant">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            {{ app()->getLocale() === 'ar' ? 'طلباتي' : 'My Orders' }}
                        </a>
                        @if(auth()->user()->isMerchant())
                        <a href="/merchant" class="flex items-center gap-2 px-4 py-3 text-charcoal dark:text-gray-300 hover:bg-cream dark:hover:bg-gray-700 hover:text-royal-gold transition-elegant">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            {{ app()->getLocale() === 'ar' ? 'لوحة التحكم' : 'Dashboard' }}
                        </a>
                        @endif
                        @if(auth()->user()->isAdmin())
                        <a href="/admin" class="flex items-center gap-2 px-4 py-3 text-charcoal dark:text-gray-300 hover:bg-cream dark:hover:bg-gray-700 hover:text-royal-gold transition-elegant">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            {{ app()->getLocale() === 'ar' ? 'لوحة الإدارة' : 'Admin Panel' }}
                        </a>
                        @endif
                        <div class="border-t border-gray-100 dark:border-gray-700">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center gap-2 w-full px-4 py-3 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition-elegant">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    {{ app()->getLocale() === 'ar' ? 'تسجيل الخروج' : 'Logout' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @else
                <!-- Login/Register Buttons (Desktop) -->
                <div class="hidden md:flex items-center gap-2">
                    <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-charcoal dark:text-gray-300 hover:text-royal-gold transition-elegant">
                        {{ app()->getLocale() === 'ar' ? 'دخول' : 'Login' }}
                    </a>
                    <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-medium bg-gradient-gold text-midnight rounded-lg hover:scale-105 transition-all shadow-sm">
                        {{ app()->getLocale() === 'ar' ? 'تسجيل' : 'Register' }}
                    </a>
                </div>
                @endauth

                <!-- Mobile Menu Button -->
                <button 
                    @click="mobileMenuOpen = !mobileMenuOpen"
                    class="lg:hidden p-2 text-charcoal dark:text-gray-300 hover:text-royal-gold transition-elegant hover:bg-cream dark:hover:bg-gray-800 rounded-lg"
                >
                    <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div 
        x-show="mobileMenuOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4"
        @click.away="mobileMenuOpen = false"
        class="lg:hidden bg-white dark:bg-gray-900 border-t border-gray-100 dark:border-gray-800 shadow-elegant-lg"
        style="display: none;"
    >
        <div class="max-w-7xl mx-auto px-4 py-4 space-y-2">
            <!-- Navigation Links -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-3 text-charcoal dark:text-gray-300 hover:bg-cream dark:hover:bg-gray-800 hover:text-royal-gold rounded-xl transition-elegant">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                {{ app()->getLocale() === 'ar' ? 'الرئيسية' : 'Home' }}
            </a>
            <a href="{{ route('categories.index') }}" class="flex items-center gap-3 px-4 py-3 text-charcoal dark:text-gray-300 hover:bg-cream dark:hover:bg-gray-800 hover:text-royal-gold rounded-xl transition-elegant">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                {{ app()->getLocale() === 'ar' ? 'الفئات' : 'Categories' }}
            </a>
            <a href="{{ route('stores.index') }}" class="flex items-center gap-3 px-4 py-3 text-charcoal dark:text-gray-300 hover:bg-cream dark:hover:bg-gray-800 hover:text-royal-gold rounded-xl transition-elegant">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                {{ app()->getLocale() === 'ar' ? 'المتاجر' : 'Stores' }}
            </a>

            <!-- Divider -->
            <div class="border-t border-gray-100 dark:border-gray-800 my-2"></div>

            <!-- Language Switcher (Mobile) -->
            <div class="px-4 py-2">
                <p class="text-xs text-slate dark:text-gray-500 mb-2">{{ app()->getLocale() === 'ar' ? 'اللغة' : 'Language' }}</p>
                <div class="flex gap-2">
                    <a href="{{ route('locale.switch', 'en') }}" 
                       class="flex-1 px-4 py-2 text-center text-sm rounded-lg transition-elegant {{ app()->getLocale() === 'en' ? 'bg-royal-gold text-midnight font-semibold' : 'bg-gray-100 dark:bg-gray-800 text-charcoal dark:text-gray-300' }}">
                        English
                    </a>
                    <a href="{{ route('locale.switch', 'ar') }}" 
                       class="flex-1 px-4 py-2 text-center text-sm rounded-lg transition-elegant {{ app()->getLocale() === 'ar' ? 'bg-royal-gold text-midnight font-semibold' : 'bg-gray-100 dark:bg-gray-800 text-charcoal dark:text-gray-300' }}">
                        العربية
                    </a>
                </div>
            </div>

            <!-- Auth Section -->
            @auth
                <div class="border-t border-gray-100 dark:border-gray-800 pt-2">
                    <div class="px-4 py-3 flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-gold rounded-full flex items-center justify-center">
                            <span class="text-midnight font-bold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <p class="font-medium text-charcoal dark:text-white">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate dark:text-gray-400">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 text-charcoal dark:text-gray-300 hover:bg-cream dark:hover:bg-gray-800 hover:text-royal-gold rounded-xl transition-elegant">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        {{ app()->getLocale() === 'ar' ? 'الملف الشخصي' : 'Profile' }}
                    </a>
                    @if(auth()->user()->isMerchant())
                    <a href="/merchant" class="flex items-center gap-3 px-4 py-3 text-charcoal dark:text-gray-300 hover:bg-cream dark:hover:bg-gray-800 hover:text-royal-gold rounded-xl transition-elegant">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        {{ app()->getLocale() === 'ar' ? 'لوحة التحكم' : 'Dashboard' }}
                    </a>
                    @endif
                    @if(auth()->user()->isAdmin())
                    <a href="/admin" class="flex items-center gap-3 px-4 py-3 text-charcoal dark:text-gray-300 hover:bg-cream dark:hover:bg-gray-800 hover:text-royal-gold rounded-xl transition-elegant">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        {{ app()->getLocale() === 'ar' ? 'لوحة الإدارة' : 'Admin Panel' }}
                    </a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-3 w-full px-4 py-3 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-elegant">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            {{ app()->getLocale() === 'ar' ? 'تسجيل الخروج' : 'Logout' }}
                        </button>
                    </form>
                </div>
            @else
                <div class="border-t border-gray-100 dark:border-gray-800 pt-4 px-4 space-y-2">
                    <a href="{{ route('login') }}" class="block w-full px-4 py-3 text-center text-charcoal dark:text-gray-300 border border-gray-200 dark:border-gray-700 rounded-xl hover:border-royal-gold hover:text-royal-gold transition-elegant">
                        {{ app()->getLocale() === 'ar' ? 'تسجيل الدخول' : 'Login' }}
                    </a>
                    <a href="{{ route('register') }}" class="block w-full px-4 py-3 text-center bg-gradient-gold text-midnight rounded-xl font-semibold hover:scale-[1.02] transition-all">
                        {{ app()->getLocale() === 'ar' ? 'إنشاء حساب' : 'Create Account' }}
                    </a>
                </div>
            @endauth
        </div>
    </div>
</nav>
