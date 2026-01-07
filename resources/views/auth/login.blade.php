<x-guest-layout>
    <h2 class="text-xl font-bold text-charcoal dark:text-white text-center mb-4">
        {{ app()->getLocale() === 'ar' ? 'تسجيل الدخول' : 'Sign In' }}
    </h2>

    <x-auth-session-status class="mb-3 text-sm" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-3">
        @csrf
        <div>
            <x-text-input id="email" class="w-full py-2.5 px-4 text-sm rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-royal-gold focus:ring-royal-gold" type="email" name="email" :value="old('email')" required autofocus placeholder="{{ app()->getLocale() === 'ar' ? 'البريد الإلكتروني' : 'Email' }}" />
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs" />
        </div>

        <div>
            <x-text-input id="password" class="w-full py-2.5 px-4 text-sm rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-royal-gold focus:ring-royal-gold" type="password" name="password" required placeholder="{{ app()->getLocale() === 'ar' ? 'كلمة المرور' : 'Password' }}" />
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs" />
        </div>

        <div class="flex items-center justify-between text-sm">
            <label class="flex items-center cursor-pointer">
                <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-royal-gold focus:ring-royal-gold" name="remember">
                <span class="ms-2 text-slate dark:text-gray-400">{{ app()->getLocale() === 'ar' ? 'تذكرني' : 'Remember me' }}</span>
            </label>
            @if (Route::has('password.request'))
                <a class="text-royal-gold hover:underline" href="{{ route('password.request') }}">{{ app()->getLocale() === 'ar' ? 'نسيت كلمة المرور؟' : 'Forgot?' }}</a>
            @endif
        </div>

        <button type="submit" class="w-full bg-gradient-to-r from-royal-gold to-gold-light text-midnight py-2.5 rounded-xl font-semibold text-sm hover:shadow-lg transition-all">
            {{ app()->getLocale() === 'ar' ? 'تسجيل الدخول' : 'Sign In' }}
        </button>

        <p class="text-center text-sm text-slate dark:text-gray-400 pt-2">
            {{ app()->getLocale() === 'ar' ? 'ليس لديك حساب؟' : "Don't have an account?" }}
            <a href="{{ route('register') }}" class="text-royal-gold font-semibold hover:underline">{{ app()->getLocale() === 'ar' ? 'سجل الآن' : 'Register' }}</a>
        </p>
    </form>
</x-guest-layout>
