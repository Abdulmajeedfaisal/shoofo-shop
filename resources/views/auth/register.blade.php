<x-guest-layout>
    <h2 class="text-xl font-bold text-charcoal dark:text-white text-center mb-4">
        {{ app()->getLocale() === 'ar' ? 'إنشاء حساب' : 'Create Account' }}
    </h2>

    <form method="POST" action="{{ route('register') }}" class="space-y-3" x-data="{ role: '{{ old('role', 'customer') }}' }">
        @csrf

        <div>
            <x-text-input id="name" class="w-full py-2.5 px-4 text-sm rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-royal-gold focus:ring-royal-gold" type="text" name="name" :value="old('name')" required placeholder="{{ app()->getLocale() === 'ar' ? 'الاسم الكامل' : 'Full Name' }}" />
            <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs" />
        </div>

        <div>
            <x-text-input id="email" class="w-full py-2.5 px-4 text-sm rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-royal-gold focus:ring-royal-gold" type="email" name="email" :value="old('email')" required placeholder="{{ app()->getLocale() === 'ar' ? 'البريد الإلكتروني' : 'Email' }}" />
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs" />
        </div>

        <div class="grid grid-cols-2 gap-3">
            <div>
                <x-text-input id="password" class="w-full py-2.5 px-4 text-sm rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-royal-gold focus:ring-royal-gold" type="password" name="password" required placeholder="{{ app()->getLocale() === 'ar' ? 'كلمة المرور' : 'Password' }}" />
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs" />
            </div>
            <div>
                <x-text-input id="password_confirmation" class="w-full py-2.5 px-4 text-sm rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-royal-gold focus:ring-royal-gold" type="password" name="password_confirmation" required placeholder="{{ app()->getLocale() === 'ar' ? 'تأكيد كلمة المرور' : 'Confirm' }}" />
            </div>
        </div>

        <!-- Role Selection -->
        <div class="flex gap-3">
            <label class="flex-1 cursor-pointer">
                <input type="radio" name="role" value="customer" class="sr-only" x-model="role">
                <div class="py-2.5 rounded-xl border-2 text-center text-sm transition-all" :class="role === 'customer' ? 'border-royal-gold bg-royal-gold/10 text-royal-gold font-semibold' : 'border-gray-200 dark:border-gray-600 text-charcoal dark:text-gray-300'">
                    {{ app()->getLocale() === 'ar' ? 'عميل' : 'Customer' }}
                </div>
            </label>
            <label class="flex-1 cursor-pointer">
                <input type="radio" name="role" value="merchant" class="sr-only" x-model="role">
                <div class="py-2.5 rounded-xl border-2 text-center text-sm transition-all" :class="role === 'merchant' ? 'border-royal-gold bg-royal-gold/10 text-royal-gold font-semibold' : 'border-gray-200 dark:border-gray-600 text-charcoal dark:text-gray-300'">
                    {{ app()->getLocale() === 'ar' ? 'تاجر' : 'Merchant' }}
                </div>
            </label>
        </div>

        <!-- Merchant Fields -->
        <div x-show="role === 'merchant'" x-transition class="space-y-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
            <div>
                <x-text-input id="store_name" class="w-full py-2.5 px-4 text-sm rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-royal-gold focus:ring-royal-gold" type="text" name="store_name" :value="old('store_name')" placeholder="{{ app()->getLocale() === 'ar' ? 'اسم المتجر *' : 'Store Name *' }}" />
                <x-input-error :messages="$errors->get('store_name')" class="mt-1 text-xs" />
            </div>
            <div>
                <x-text-input id="phone" class="w-full py-2.5 px-4 text-sm rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-royal-gold focus:ring-royal-gold" type="tel" name="phone" :value="old('phone')" placeholder="{{ app()->getLocale() === 'ar' ? 'رقم الهاتف *' : 'Phone *' }}" />
                <x-input-error :messages="$errors->get('phone')" class="mt-1 text-xs" />
            </div>
        </div>

        <button type="submit" class="w-full bg-gradient-to-r from-royal-gold to-gold-light text-midnight py-2.5 rounded-xl font-semibold text-sm hover:shadow-lg transition-all">
            <span x-text="role === 'merchant' ? '{{ app()->getLocale() === 'ar' ? 'تقديم طلب التاجر' : 'Submit Request' }}' : '{{ app()->getLocale() === 'ar' ? 'إنشاء حساب' : 'Create Account' }}'"></span>
        </button>

        <p class="text-center text-sm text-slate dark:text-gray-400 pt-1">
            {{ app()->getLocale() === 'ar' ? 'لديك حساب؟' : 'Already have an account?' }}
            <a href="{{ route('login') }}" class="text-royal-gold font-semibold hover:underline">{{ app()->getLocale() === 'ar' ? 'سجل دخولك' : 'Sign in' }}</a>
        </p>
    </form>
</x-guest-layout>
