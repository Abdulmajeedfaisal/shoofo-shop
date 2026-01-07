<x-guest-luxury :title="(app()->getLocale() === 'ar' ? 'في انتظار الموافقة' : 'Pending Approval') . ' - ' . config('app.name', 'SHOOFO')">

    <div class="min-h-[70vh] flex items-center justify-center py-16">
        <div class="max-w-lg mx-auto px-6 text-center">
            <!-- Animated Icon -->
            <div class="relative mb-8">
                <div class="w-32 h-32 mx-auto bg-gradient-to-br from-royal-gold/20 to-royal-gold/5 rounded-full flex items-center justify-center animate-pulse">
                    <div class="w-24 h-24 bg-gradient-gold rounded-full flex items-center justify-center shadow-elegant-xl">
                        <svg class="w-12 h-12 text-midnight" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <!-- Decorative circles -->
                <div class="absolute top-0 left-1/2 -translate-x-1/2 w-40 h-40 border-2 border-royal-gold/20 rounded-full animate-ping" style="animation-duration: 3s;"></div>
            </div>

            <!-- Title -->
            <h1 class="font-playfair text-4xl md:text-5xl font-bold text-midnight dark:text-white mb-4">
                {{ app()->getLocale() === 'ar' ? 'طلبك قيد المراجعة' : 'Your Request is Under Review' }}
            </h1>

            <!-- Subtitle -->
            <p class="text-lg text-slate dark:text-gray-300 mb-8 leading-relaxed">
                {{ app()->getLocale() === 'ar' 
                    ? 'شكراً لانضمامك إلى عائلة شوفو! فريقنا يراجع طلبك حالياً. سنرسل لك إشعاراً فور الموافقة على متجرك.' 
                    : 'Thank you for joining the SHOOFO family! Our team is currently reviewing your request. We will notify you once your store is approved.' }}
            </p>

            <!-- Status Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-elegant-xl p-6 mb-8 border border-gray-100 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-sm text-slate dark:text-gray-400">
                        {{ app()->getLocale() === 'ar' ? 'حالة الطلب' : 'Request Status' }}
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                        <span class="w-2 h-2 bg-yellow-500 rounded-full mr-2 animate-pulse"></span>
                        {{ app()->getLocale() === 'ar' ? 'قيد المراجعة' : 'Pending Review' }}
                    </span>
                </div>

                @if(auth()->user()->merchant)
                <div class="border-t border-gray-100 dark:border-gray-700 pt-4">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-cream dark:bg-gray-700 rounded-full flex items-center justify-center">
                            <span class="text-2xl font-playfair font-bold text-royal-gold">
                                {{ substr(auth()->user()->merchant->store_name, 0, 1) }}
                            </span>
                        </div>
                        <div class="text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}">
                            <h3 class="font-semibold text-charcoal dark:text-white">
                                {{ auth()->user()->merchant->store_name }}
                            </h3>
                            @if(auth()->user()->merchant->store_name_ar)
                            <p class="text-sm text-slate dark:text-gray-400">
                                {{ auth()->user()->merchant->store_name_ar }}
                            </p>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- What's Next -->
            <div class="bg-cream dark:bg-gray-800/50 rounded-2xl p-6 mb-8 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}">
                <h3 class="font-semibold text-charcoal dark:text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-royal-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ app()->getLocale() === 'ar' ? 'ماذا بعد؟' : "What's Next?" }}
                </h3>
                <ul class="space-y-3 text-sm text-slate dark:text-gray-300">
                    <li class="flex items-start gap-3">
                        <span class="w-6 h-6 bg-royal-gold/20 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <span class="text-xs font-bold text-royal-gold">1</span>
                        </span>
                        {{ app()->getLocale() === 'ar' 
                            ? 'سيراجع فريقنا معلومات متجرك خلال 24-48 ساعة' 
                            : 'Our team will review your store information within 24-48 hours' }}
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="w-6 h-6 bg-royal-gold/20 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <span class="text-xs font-bold text-royal-gold">2</span>
                        </span>
                        {{ app()->getLocale() === 'ar' 
                            ? 'ستتلقى إشعاراً بالبريد الإلكتروني عند الموافقة' 
                            : 'You will receive an email notification upon approval' }}
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="w-6 h-6 bg-royal-gold/20 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <span class="text-xs font-bold text-royal-gold">3</span>
                        </span>
                        {{ app()->getLocale() === 'ar' 
                            ? 'بعد الموافقة، يمكنك البدء بإضافة منتجاتك' 
                            : 'After approval, you can start adding your products' }}
                    </li>
                </ul>
            </div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('home') }}" 
                   class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-gold text-midnight rounded-xl font-semibold hover:scale-105 hover:shadow-elegant-lg transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    {{ app()->getLocale() === 'ar' ? 'تصفح المتجر' : 'Browse Store' }}
                </a>
                
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" 
                            class="inline-flex items-center justify-center gap-2 px-6 py-3 border-2 border-gray-300 dark:border-gray-600 text-charcoal dark:text-white rounded-xl font-semibold hover:border-royal-gold hover:text-royal-gold transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        {{ app()->getLocale() === 'ar' ? 'تسجيل الخروج' : 'Logout' }}
                    </button>
                </form>
            </div>

            <!-- Contact Support -->
            <p class="mt-8 text-sm text-slate dark:text-gray-400">
                {{ app()->getLocale() === 'ar' ? 'هل لديك أسئلة؟' : 'Have questions?' }}
                <a href="mailto:support@shoofo.com" class="text-royal-gold hover:underline font-medium">
                    {{ app()->getLocale() === 'ar' ? 'تواصل معنا' : 'Contact us' }}
                </a>
            </p>
        </div>
    </div>

</x-guest-luxury>
