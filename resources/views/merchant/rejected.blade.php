<x-guest-luxury :title="(app()->getLocale() === 'ar' ? 'تم رفض الطلب' : 'Request Rejected') . ' - ' . config('app.name', 'SHOOFO')">

    <div class="min-h-[70vh] flex items-center justify-center py-16">
        <div class="max-w-lg mx-auto px-6 text-center">
            <!-- Icon -->
            <div class="w-24 h-24 mx-auto bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mb-8">
                <svg class="w-12 h-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>

            <!-- Title -->
            <h1 class="font-playfair text-4xl font-bold text-midnight dark:text-white mb-4">
                {{ app()->getLocale() === 'ar' ? 'تم رفض طلبك' : 'Your Request Was Rejected' }}
            </h1>

            <!-- Message -->
            <p class="text-lg text-slate dark:text-gray-300 mb-8 leading-relaxed">
                {{ app()->getLocale() === 'ar' 
                    ? 'نأسف لإبلاغك أن طلب فتح متجرك لم يتم قبوله. يمكنك التواصل معنا لمعرفة المزيد أو تقديم طلب جديد.' 
                    : 'We regret to inform you that your store application was not accepted. You can contact us to learn more or submit a new application.' }}
            </p>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="mailto:support@shoofo.com" 
                   class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-gold text-midnight rounded-xl font-semibold hover:scale-105 hover:shadow-elegant-lg transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    {{ app()->getLocale() === 'ar' ? 'تواصل معنا' : 'Contact Us' }}
                </a>
                
                <a href="{{ route('home') }}" 
                   class="inline-flex items-center justify-center gap-2 px-6 py-3 border-2 border-gray-300 dark:border-gray-600 text-charcoal dark:text-white rounded-xl font-semibold hover:border-royal-gold hover:text-royal-gold transition-all duration-300">
                    {{ app()->getLocale() === 'ar' ? 'العودة للرئيسية' : 'Back to Home' }}
                </a>
            </div>
        </div>
    </div>

</x-guest-luxury>
