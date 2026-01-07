<x-guest-layout>
    <div class="text-center">
        <!-- Icon -->
        <div class="w-16 h-16 mx-auto bg-royal-gold/10 rounded-full flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-royal-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
        </div>

        <h2 class="text-xl font-bold text-charcoal dark:text-white mb-3">
            {{ app()->getLocale() === 'ar' ? 'تأكيد البريد الإلكتروني' : 'Verify Your Email' }}
        </h2>

        <p class="text-sm text-slate dark:text-gray-400 mb-4">
            {{ app()->getLocale() === 'ar' 
                ? 'شكراً للتسجيل! يرجى التحقق من بريدك الإلكتروني والنقر على رابط التأكيد.' 
                : 'Thanks for signing up! Please check your email and click the verification link.' }}
        </p>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 p-3 bg-green-50 dark:bg-green-900/20 rounded-xl">
                <p class="text-sm text-green-600 dark:text-green-400">
                    {{ app()->getLocale() === 'ar' 
                        ? '✓ تم إرسال رابط تأكيد جديد إلى بريدك الإلكتروني.' 
                        : '✓ A new verification link has been sent to your email.' }}
                </p>
            </div>
        @endif

        <div class="space-y-3">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="w-full bg-gradient-to-r from-royal-gold to-gold-light text-midnight py-2.5 rounded-xl font-semibold text-sm hover:shadow-lg transition-all">
                    {{ app()->getLocale() === 'ar' ? 'إعادة إرسال رابط التأكيد' : 'Resend Verification Email' }}
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full py-2.5 text-sm text-slate dark:text-gray-400 hover:text-royal-gold transition-colors">
                    {{ app()->getLocale() === 'ar' ? 'تسجيل الخروج' : 'Log Out' }}
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
