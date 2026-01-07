<x-guest-layout>
    <h2 class="text-xl font-bold text-charcoal dark:text-white text-center mb-4">
        {{ app()->getLocale() === 'ar' ? 'إعادة تعيين كلمة المرور' : 'Reset Password' }}
    </h2>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-3">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <x-text-input id="email" class="w-full py-2.5 px-4 text-sm rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-royal-gold focus:ring-royal-gold" type="email" name="email" :value="old('email', $request->email)" required autofocus placeholder="{{ app()->getLocale() === 'ar' ? 'البريد الإلكتروني' : 'Email' }}" />
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs" />
        </div>

        <div>
            <x-text-input id="password" class="w-full py-2.5 px-4 text-sm rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-royal-gold focus:ring-royal-gold" type="password" name="password" required placeholder="{{ app()->getLocale() === 'ar' ? 'كلمة المرور الجديدة' : 'New Password' }}" />
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs" />
        </div>

        <div>
            <x-text-input id="password_confirmation" class="w-full py-2.5 px-4 text-sm rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-royal-gold focus:ring-royal-gold" type="password" name="password_confirmation" required placeholder="{{ app()->getLocale() === 'ar' ? 'تأكيد كلمة المرور' : 'Confirm Password' }}" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-xs" />
        </div>

        <button type="submit" class="w-full bg-gradient-to-r from-royal-gold to-gold-light text-midnight py-2.5 rounded-xl font-semibold text-sm hover:shadow-lg transition-all">
            {{ app()->getLocale() === 'ar' ? 'إعادة تعيين كلمة المرور' : 'Reset Password' }}
        </button>
    </form>
</x-guest-layout>
