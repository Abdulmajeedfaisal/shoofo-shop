<x-guest-layout>
    <h2 class="text-xl font-bold text-charcoal dark:text-white text-center mb-4">
        {{ app()->getLocale() === 'ar' ? 'تأكيد كلمة المرور' : 'Confirm Password' }}
    </h2>

    <p class="text-sm text-slate dark:text-gray-400 text-center mb-4">
        {{ app()->getLocale() === 'ar' 
            ? 'هذه منطقة آمنة. يرجى تأكيد كلمة المرور قبل المتابعة.' 
            : 'This is a secure area. Please confirm your password before continuing.' }}
    </p>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-3">
        @csrf

        <div>
            <x-text-input id="password" class="w-full py-2.5 px-4 text-sm rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-royal-gold focus:ring-royal-gold" type="password" name="password" required autocomplete="current-password" placeholder="{{ app()->getLocale() === 'ar' ? 'كلمة المرور' : 'Password' }}" />
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs" />
        </div>

        <button type="submit" class="w-full bg-gradient-to-r from-royal-gold to-gold-light text-midnight py-2.5 rounded-xl font-semibold text-sm hover:shadow-lg transition-all">
            {{ app()->getLocale() === 'ar' ? 'تأكيد' : 'Confirm' }}
        </button>
    </form>
</x-guest-layout>
