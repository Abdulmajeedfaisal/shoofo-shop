<x-guest-layout>
    <h2 class="text-xl font-bold text-charcoal dark:text-white text-center mb-4">
        {{ app()->getLocale() === 'ar' ? 'نسيت كلمة المرور؟' : 'Forgot Password?' }}
    </h2>

    <p class="text-sm text-slate dark:text-gray-400 text-center mb-4">
        {{ app()->getLocale() === 'ar' 
            ? 'أدخل بريدك الإلكتروني وسنرسل لك رابط إعادة تعيين كلمة المرور.' 
            : 'Enter your email and we\'ll send you a password reset link.' }}
    </p>

    <x-auth-session-status class="mb-3 text-sm" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-3">
        @csrf

        <div>
            <x-text-input id="email" class="w-full py-2.5 px-4 text-sm rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-royal-gold focus:ring-royal-gold" type="email" name="email" :value="old('email')" required autofocus placeholder="{{ app()->getLocale() === 'ar' ? 'البريد الإلكتروني' : 'Email' }}" />
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs" />
        </div>

        <button type="submit" class="w-full bg-gradient-to-r from-royal-gold to-gold-light text-midnight py-2.5 rounded-xl font-semibold text-sm hover:shadow-lg transition-all">
            {{ app()->getLocale() === 'ar' ? 'إرسال رابط إعادة التعيين' : 'Send Reset Link' }}
        </button>

        <p class="text-center text-sm text-slate dark:text-gray-400 pt-2">
            <a href="{{ route('login') }}" class="text-royal-gold font-semibold hover:underline">
                {{ app()->getLocale() === 'ar' ? '← العودة لتسجيل الدخول' : '← Back to Login' }}
            </a>
        </p>
    </form>
</x-guest-layout>
