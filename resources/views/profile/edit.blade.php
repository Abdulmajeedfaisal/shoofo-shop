<x-guest-luxury :title="(app()->getLocale() === 'ar' ? 'الملف الشخصي' : 'Profile') . ' - ' . config('app.name', 'SHOOFO')">

    <!-- Page Header -->
    <section class="bg-gradient-to-br from-midnight via-charcoal to-midnight text-white py-8 md:py-10">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h1 class="font-playfair text-3xl md:text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-white via-royal-gold to-white mb-4">
                {{ app()->getLocale() === 'ar' ? 'الملف الشخصي' : 'My Profile' }}
            </h1>
            <div class="flex items-center justify-center gap-4">
                <div class="w-16 h-1 bg-gradient-to-r from-transparent via-royal-gold to-royal-gold rounded-full"></div>
                <div class="w-3 h-3 bg-royal-gold rounded-full animate-pulse"></div>
                <div class="w-16 h-1 bg-gradient-to-l from-transparent via-royal-gold to-royal-gold rounded-full"></div>
            </div>
        </div>
    </section>

    <!-- Profile Content -->
    <section class="py-8 md:py-12 bg-cream dark:bg-gray-900">
        <div class="max-w-2xl mx-auto px-6 space-y-6">
            
            <!-- Profile Information -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-elegant p-6 border border-gray-100 dark:border-gray-700">
                <h3 class="text-lg font-bold text-charcoal dark:text-white mb-1">
                    {{ app()->getLocale() === 'ar' ? 'معلومات الحساب' : 'Account Information' }}
                </h3>
                <p class="text-sm text-slate dark:text-gray-400 mb-4">
                    {{ app()->getLocale() === 'ar' ? 'تحديث اسمك وبريدك الإلكتروني' : 'Update your name and email address' }}
                </p>

                <form method="post" action="{{ route('profile.update') }}" class="space-y-4">
                    @csrf
                    @method('patch')

                    <div>
                        <label class="block text-sm font-medium text-charcoal dark:text-gray-300 mb-1">
                            {{ app()->getLocale() === 'ar' ? 'الاسم' : 'Name' }}
                        </label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                               class="w-full py-2.5 px-4 text-sm rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-royal-gold focus:ring-royal-gold">
                        <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-charcoal dark:text-gray-300 mb-1">
                            {{ app()->getLocale() === 'ar' ? 'البريد الإلكتروني' : 'Email' }}
                        </label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                               class="w-full py-2.5 px-4 text-sm rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-royal-gold focus:ring-royal-gold">
                        <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs" />
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="submit" class="bg-gradient-to-r from-royal-gold to-gold-light text-midnight px-6 py-2.5 rounded-xl font-semibold text-sm hover:shadow-lg transition-all">
                            {{ app()->getLocale() === 'ar' ? 'حفظ' : 'Save' }}
                        </button>
                        @if (session('status') === 'profile-updated')
                            <span class="text-sm text-green-600 dark:text-green-400">✓ {{ app()->getLocale() === 'ar' ? 'تم الحفظ' : 'Saved' }}</span>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Update Password -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-elegant p-6 border border-gray-100 dark:border-gray-700">
                <h3 class="text-lg font-bold text-charcoal dark:text-white mb-1">
                    {{ app()->getLocale() === 'ar' ? 'تغيير كلمة المرور' : 'Change Password' }}
                </h3>
                <p class="text-sm text-slate dark:text-gray-400 mb-4">
                    {{ app()->getLocale() === 'ar' ? 'استخدم كلمة مرور قوية للحفاظ على أمان حسابك' : 'Use a strong password to keep your account secure' }}
                </p>

                <form method="post" action="{{ route('password.update') }}" class="space-y-4">
                    @csrf
                    @method('put')

                    <div>
                        <label class="block text-sm font-medium text-charcoal dark:text-gray-300 mb-1">
                            {{ app()->getLocale() === 'ar' ? 'كلمة المرور الحالية' : 'Current Password' }}
                        </label>
                        <input type="password" name="current_password"
                               class="w-full py-2.5 px-4 text-sm rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-royal-gold focus:ring-royal-gold">
                        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1 text-xs" />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-charcoal dark:text-gray-300 mb-1">
                                {{ app()->getLocale() === 'ar' ? 'كلمة المرور الجديدة' : 'New Password' }}
                            </label>
                            <input type="password" name="password"
                                   class="w-full py-2.5 px-4 text-sm rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-royal-gold focus:ring-royal-gold">
                            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1 text-xs" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-charcoal dark:text-gray-300 mb-1">
                                {{ app()->getLocale() === 'ar' ? 'تأكيد كلمة المرور' : 'Confirm Password' }}
                            </label>
                            <input type="password" name="password_confirmation"
                                   class="w-full py-2.5 px-4 text-sm rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-royal-gold focus:ring-royal-gold">
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="submit" class="bg-gradient-to-r from-royal-gold to-gold-light text-midnight px-6 py-2.5 rounded-xl font-semibold text-sm hover:shadow-lg transition-all">
                            {{ app()->getLocale() === 'ar' ? 'تحديث كلمة المرور' : 'Update Password' }}
                        </button>
                        @if (session('status') === 'password-updated')
                            <span class="text-sm text-green-600 dark:text-green-400">✓ {{ app()->getLocale() === 'ar' ? 'تم التحديث' : 'Updated' }}</span>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Delete Account -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-elegant p-6 border border-red-100 dark:border-red-900/30">
                <h3 class="text-lg font-bold text-red-600 dark:text-red-400 mb-1">
                    {{ app()->getLocale() === 'ar' ? 'حذف الحساب' : 'Delete Account' }}
                </h3>
                <p class="text-sm text-slate dark:text-gray-400 mb-4">
                    {{ app()->getLocale() === 'ar' ? 'بمجرد حذف حسابك، سيتم حذف جميع بياناتك نهائياً.' : 'Once deleted, all your data will be permanently removed.' }}
                </p>

                <div x-data="{ showDelete: false }">
                    <button @click="showDelete = true" class="px-4 py-2 bg-red-600 text-white text-sm rounded-xl hover:bg-red-700 transition-colors">
                        {{ app()->getLocale() === 'ar' ? 'حذف الحساب' : 'Delete Account' }}
                    </button>

                    <!-- Delete Modal -->
                    <div x-show="showDelete" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50">
                        <div @click.away="showDelete = false" class="bg-white dark:bg-gray-800 rounded-2xl p-6 max-w-md w-full shadow-2xl">
                            <h4 class="text-lg font-bold text-charcoal dark:text-white mb-2">
                                {{ app()->getLocale() === 'ar' ? 'هل أنت متأكد؟' : 'Are you sure?' }}
                            </h4>
                            <p class="text-sm text-slate dark:text-gray-400 mb-4">
                                {{ app()->getLocale() === 'ar' ? 'أدخل كلمة المرور لتأكيد حذف حسابك نهائياً.' : 'Enter your password to confirm permanent deletion.' }}
                            </p>

                            <form method="post" action="{{ route('profile.destroy') }}" class="space-y-4">
                                @csrf
                                @method('delete')

                                <input type="password" name="password" placeholder="{{ app()->getLocale() === 'ar' ? 'كلمة المرور' : 'Password' }}"
                                       class="w-full py-2.5 px-4 text-sm rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-red-500 focus:ring-red-500">
                                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-1 text-xs" />

                                <div class="flex gap-3">
                                    <button type="button" @click="showDelete = false" class="flex-1 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        {{ app()->getLocale() === 'ar' ? 'إلغاء' : 'Cancel' }}
                                    </button>
                                    <button type="submit" class="flex-1 py-2.5 bg-red-600 text-white rounded-xl text-sm font-medium hover:bg-red-700 transition-colors">
                                        {{ app()->getLocale() === 'ar' ? 'حذف نهائياً' : 'Delete Forever' }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

</x-guest-luxury>
