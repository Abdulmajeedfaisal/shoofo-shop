<x-guest-luxury :title="__('checkout.checkout') . ' - ' . config('app.name', 'SHOOFO')">

    <div class="bg-white dark:bg-gray-900 min-h-screen transition-smooth">
        <!-- Breadcrumb -->
        <div class="bg-cream dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <nav class="flex items-center gap-2 text-sm">
                    <a href="{{ route('home') }}" class="text-slate dark:text-gray-400 hover:text-royal-gold transition-colors">{{ app()->getLocale() === 'ar' ? 'الرئيسية' : 'Home' }}</a>
                    <svg class="w-4 h-4 text-slate {{ app()->getLocale() === 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    <a href="{{ route('cart.index') }}" class="text-slate dark:text-gray-400 hover:text-royal-gold transition-colors">{{ __('cart.cart') }}</a>
                    <svg class="w-4 h-4 text-slate {{ app()->getLocale() === 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    <span class="text-charcoal dark:text-white font-medium">{{ __('checkout.checkout') }}</span>
                </nav>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
            <!-- Page Title -->
            <div class="text-center mb-8">
                <h1 class="text-3xl md:text-4xl font-playfair font-bold text-charcoal dark:text-white">{{ __('checkout.checkout') }}</h1>
            </div>

            <!-- Flash Messages -->
            @if(session('error'))
                <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 px-4 py-3 rounded-xl flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Shipping & Payment Form -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Shipping Information -->
                        <div class="bg-cream dark:bg-gray-800 rounded-2xl p-6 shadow-elegant">
                            <h2 class="text-xl font-playfair font-bold text-charcoal dark:text-white mb-6 flex items-center gap-2">
                                <svg class="w-6 h-6 text-royal-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                {{ __('checkout.shipping_information') }}
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Full Name -->
                                <div>
                                    <label class="block text-sm font-medium text-charcoal dark:text-white mb-2">{{ __('checkout.full_name') }} *</label>
                                    <input type="text" name="shipping_name" value="{{ old('shipping_name', $user->name) }}" required class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-charcoal dark:text-white focus:ring-2 focus:ring-royal-gold focus:border-transparent transition-all">
                                </div>
                                <!-- Email -->
                                <div>
                                    <label class="block text-sm font-medium text-charcoal dark:text-white mb-2">{{ __('checkout.email') }} *</label>
                                    <input type="email" name="shipping_email" value="{{ old('shipping_email', $user->email) }}" required class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-charcoal dark:text-white focus:ring-2 focus:ring-royal-gold focus:border-transparent transition-all">
                                </div>
                                <!-- Phone - Professional Input with Country Code -->
                                <div x-data="phoneInput()" class="relative">
                                    <label class="block text-sm font-medium text-charcoal dark:text-white mb-2">{{ __('checkout.phone') }} *</label>
                                    <input type="hidden" name="shipping_phone" x-model="fullNumber" required>
                                    
                                    <div class="flex">
                                        <!-- Country Code Selector -->
                                        <div class="relative">
                                            <button type="button" @click="openDropdown = !openDropdown" @click.away="openDropdown = false"
                                                class="h-full px-3 py-3 rounded-{{ app()->getLocale() === 'ar' ? 'r' : 'l' }}-xl border border-{{ app()->getLocale() === 'ar' ? 'l' : 'r' }}-0 border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-600 text-charcoal dark:text-white flex items-center gap-2 hover:bg-gray-100 dark:hover:bg-gray-500 transition-colors min-w-[100px]">
                                                <img :src="'https://cdn.jsdelivr.net/npm/flag-icons@7.2.3/flags/4x3/' + selectedCountry.code + '.svg'" class="w-5 h-4 rounded shadow-sm object-cover">
                                                <span class="text-sm font-medium" x-text="'+' + selectedCountry.dialCode"></span>
                                                <svg class="w-4 h-4 text-gray-400" :class="{ 'rotate-180': openDropdown }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                            </button>
                                            
                                            <!-- Dropdown -->
                                            <div x-show="openDropdown" x-transition
                                                class="absolute z-50 mt-1 w-72 bg-white dark:bg-gray-800 rounded-xl shadow-elegant-xl border border-gray-200 dark:border-gray-700 overflow-hidden {{ app()->getLocale() === 'ar' ? 'right-0' : 'left-0' }}">
                                                <!-- Search -->
                                                <div class="p-2 border-b border-gray-200 dark:border-gray-700">
                                                    <input type="text" x-model="searchPhone" @input="filterPhoneCountries()" placeholder="{{ app()->getLocale() === 'ar' ? 'ابحث...' : 'Search...' }}"
                                                        class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-charcoal dark:text-white text-sm focus:ring-2 focus:ring-royal-gold">
                                                </div>
                                                <!-- List -->
                                                <div class="max-h-48 overflow-y-auto">
                                                    <template x-for="country in filteredPhoneCountries" :key="country.code">
                                                        <button type="button" @click="selectPhoneCountry(country)"
                                                            class="w-full px-3 py-2 flex items-center gap-3 hover:bg-royal-gold/10 transition-colors text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}">
                                                            <img :src="'https://cdn.jsdelivr.net/npm/flag-icons@7.2.3/flags/4x3/' + country.code + '.svg'" class="w-5 h-4 rounded shadow-sm object-cover">
                                                            <span class="text-charcoal dark:text-white text-sm flex-1" x-text="country.name"></span>
                                                            <span class="text-slate dark:text-gray-400 text-sm" x-text="'+' + country.dialCode"></span>
                                                        </button>
                                                    </template>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Phone Number Input -->
                                        <input type="tel" x-model="phoneNumber" @input="updateFullNumber()" 
                                            placeholder="{{ app()->getLocale() === 'ar' ? '5XX XXX XXXX' : '5XX XXX XXXX' }}"
                                            class="flex-1 px-4 py-3 rounded-{{ app()->getLocale() === 'ar' ? 'l' : 'r' }}-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-charcoal dark:text-white focus:ring-2 focus:ring-royal-gold focus:border-transparent transition-all"
                                            dir="ltr">
                                    </div>
                                </div>
                                
                                <!-- Country - Professional Dropdown with Flags -->
                                <div x-data="countrySelect()" class="relative">
                                    <label class="block text-sm font-medium text-charcoal dark:text-white mb-2">{{ __('checkout.country') }} *</label>
                                    <input type="hidden" name="shipping_country" x-model="selectedValue" required>
                                    
                                    <!-- Custom Select Button -->
                                    <button type="button" @click="open = !open" @click.away="open = false"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-charcoal dark:text-white focus:ring-2 focus:ring-royal-gold focus:border-transparent transition-all flex items-center justify-between">
                                        <span class="flex items-center gap-3">
                                            <template x-if="selectedCode">
                                                <span class="w-6 h-4 rounded overflow-hidden shadow-sm" x-html="getFlag(selectedCode)"></span>
                                            </template>
                                            <span x-text="selectedLabel || '{{ app()->getLocale() === 'ar' ? '-- اختر الدولة --' : '-- Select Country --' }}'"></span>
                                        </span>
                                        <svg class="w-5 h-5 text-gray-400 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>
                                    
                                    <!-- Dropdown -->
                                    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-1"
                                        class="absolute z-50 mt-2 w-full bg-white dark:bg-gray-800 rounded-xl shadow-elegant-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                                        
                                        <!-- Search -->
                                        <div class="p-3 border-b border-gray-200 dark:border-gray-700">
                                            <input type="text" x-model="search" @input="filterCountries()" placeholder="{{ app()->getLocale() === 'ar' ? 'ابحث عن دولة...' : 'Search country...' }}"
                                                class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-charcoal dark:text-white text-sm focus:ring-2 focus:ring-royal-gold focus:border-transparent">
                                        </div>
                                        
                                        <!-- Countries List -->
                                        <div class="max-h-64 overflow-y-auto">
                                            <template x-for="group in filteredGroups" :key="group.name">
                                                <div>
                                                    <div class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-xs font-semibold text-slate dark:text-gray-400 uppercase tracking-wider" x-text="group.name"></div>
                                                    <template x-for="country in group.countries" :key="country.code">
                                                        <button type="button" @click="selectCountry(country)" class="w-full px-4 py-3 flex items-center gap-3 hover:bg-royal-gold/10 transition-colors text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}">
                                                            <span class="w-6 h-4 rounded overflow-hidden shadow-sm flex-shrink-0" x-html="getFlag(country.code)"></span>
                                                            <span class="text-charcoal dark:text-white" x-text="country.name"></span>
                                                        </button>
                                                    </template>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                                <!-- City -->
                                <div>
                                    <label class="block text-sm font-medium text-charcoal dark:text-white mb-2">{{ __('checkout.city') }} *</label>
                                    <input type="text" name="shipping_city" value="{{ old('shipping_city') }}" required class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-charcoal dark:text-white focus:ring-2 focus:ring-royal-gold focus:border-transparent transition-all">
                                </div>
                                <!-- Postal Code -->
                                <div>
                                    <label class="block text-sm font-medium text-charcoal dark:text-white mb-2">{{ __('checkout.postal_code') }}</label>
                                    <input type="text" name="shipping_postal_code" value="{{ old('shipping_postal_code') }}" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-charcoal dark:text-white focus:ring-2 focus:ring-royal-gold focus:border-transparent transition-all">
                                </div>
                                <!-- Address -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-charcoal dark:text-white mb-2">{{ __('checkout.address') }} *</label>
                                    <textarea name="shipping_address" rows="3" required class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-charcoal dark:text-white focus:ring-2 focus:ring-royal-gold focus:border-transparent transition-all resize-none">{{ old('shipping_address') }}</textarea>
                                </div>
                                <!-- Notes -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-charcoal dark:text-white mb-2">{{ __('checkout.notes') }}</label>
                                    <textarea name="notes" rows="2" placeholder="{{ __('checkout.notes_placeholder') }}" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-charcoal dark:text-white focus:ring-2 focus:ring-royal-gold focus:border-transparent transition-all resize-none">{{ old('notes') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="bg-cream dark:bg-gray-800 rounded-2xl p-6 shadow-elegant">
                            <h2 class="text-xl font-playfair font-bold text-charcoal dark:text-white mb-6 flex items-center gap-2">
                                <svg class="w-6 h-6 text-royal-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                {{ __('checkout.payment_method') }}
                            </h2>
                            <div class="space-y-3">
                                <label class="flex items-center gap-4 p-4 rounded-xl border-2 border-gray-200 dark:border-gray-600 hover:border-royal-gold cursor-pointer transition-all has-[:checked]:border-royal-gold has-[:checked]:bg-royal-gold/5">
                                    <input type="radio" name="payment_method" value="cod" checked class="w-5 h-5 text-royal-gold focus:ring-royal-gold">
                                    <div class="flex-1">
                                        <p class="font-semibold text-charcoal dark:text-white">{{ __('checkout.cash_on_delivery') }}</p>
                                        <p class="text-sm text-slate dark:text-gray-400">{{ app()->getLocale() === 'ar' ? 'ادفع نقداً عند استلام طلبك' : 'Pay cash when you receive your order' }}</p>
                                    </div>
                                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                </label>
                                <label class="flex items-center gap-4 p-4 rounded-xl border-2 border-gray-200 dark:border-gray-600 opacity-50 cursor-not-allowed">
                                    <input type="radio" name="payment_method" value="credit_card" disabled class="w-5 h-5">
                                    <div class="flex-1">
                                        <p class="font-semibold text-charcoal dark:text-white">{{ __('checkout.credit_card') }}</p>
                                        <p class="text-sm text-slate dark:text-gray-400">{{ app()->getLocale() === 'ar' ? 'قريباً' : 'Coming Soon' }}</p>
                                    </div>
                                    <svg class="w-8 h-8 text-slate" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-cream dark:bg-gray-800 rounded-2xl p-6 shadow-elegant sticky top-28">
                            <h2 class="text-xl font-playfair font-bold text-charcoal dark:text-white mb-6">{{ __('checkout.order_summary') }}</h2>
                            <div class="space-y-4 max-h-64 overflow-y-auto mb-6">
                                @foreach($items as $item)
                                    <div class="flex gap-3">
                                        <div class="w-16 h-16 bg-white dark:bg-gray-700 rounded-lg overflow-hidden flex-shrink-0">
                                            @if($item->product->images->first())
                                                <img src="{{ $item->product->images->first()->image_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-charcoal dark:text-white truncate">{{ app()->getLocale() === 'ar' && $item->product->name_ar ? $item->product->name_ar : $item->product->name }}</p>
                                            <p class="text-xs text-slate dark:text-gray-400">{{ __('cart.quantity') }}: {{ $item->quantity }}</p>
                                            <p class="text-sm font-semibold text-royal-gold">{{ number_format($item->getSubtotal(), 2) }} SAR</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-4 space-y-3">
                                <div class="flex justify-between text-slate dark:text-gray-400">
                                    <span>{{ __('cart.subtotal') }}</span>
                                    <span>{{ number_format($subtotal, 2) }} SAR</span>
                                </div>
                                <div class="flex justify-between text-slate dark:text-gray-400">
                                    <span>{{ __('cart.shipping') }}</span>
                                    @if($shippingTotal > 0)
                                        <span>{{ number_format($shippingTotal, 2) }} SAR</span>
                                    @else
                                        <span class="text-green-600">{{ app()->getLocale() === 'ar' ? 'مجاني' : 'Free' }}</span>
                                    @endif
                                </div>
                                @if(count($shippingByMerchant) > 1 && $shippingTotal > 0)
                                    <div class="text-xs text-slate dark:text-gray-500 space-y-1 pr-4">
                                        @foreach($shippingByMerchant as $merchantId => $details)
                                            <div class="flex justify-between">
                                                <span>• {{ app()->getLocale() === 'ar' && $details['merchant']->store_name_ar ? $details['merchant']->store_name_ar : $details['merchant']->store_name }}</span>
                                                <span>{{ $details['shipping'] > 0 ? number_format($details['shipping'], 2) . ' SAR' : (app()->getLocale() === 'ar' ? 'مجاني' : 'Free') }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                                <div class="flex justify-between text-lg font-bold border-t border-gray-200 dark:border-gray-700 pt-3">
                                    <span class="text-charcoal dark:text-white">{{ __('cart.total') }}</span>
                                    <span class="text-royal-gold">{{ number_format($total, 2) }} SAR</span>
                                </div>
                            </div>
                            <div class="mt-6 space-y-3">
                                <button type="submit" class="w-full bg-gradient-gold text-midnight px-6 py-4 rounded-xl font-semibold hover:scale-[1.02] hover:shadow-elegant-xl transition-all flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    {{ __('checkout.place_order') }}
                                </button>
                                <a href="{{ route('cart.index') }}" class="block w-full border-2 border-gray-300 dark:border-gray-600 text-charcoal dark:text-white px-6 py-3 rounded-xl font-medium text-center hover:border-royal-gold hover:text-royal-gold transition-colors">{{ __('checkout.back_to_cart') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
    function countrySelect() {
        return {
            open: false,
            search: '',
            selectedCode: '{{ old('shipping_country') ? strtolower(substr(old('shipping_country'), 0, 2)) : '' }}',
            selectedValue: '{{ old('shipping_country', '') }}',
            selectedLabel: '{{ old('shipping_country', '') }}',
            
            // All countries grouped
            groups: [
                {
                    name: '{{ app()->getLocale() === "ar" ? "⭐ الدول المفضلة" : "⭐ Preferred" }}',
                    countries: [
                        { code: 'ye', name: '{{ app()->getLocale() === "ar" ? "اليمن" : "Yemen" }}', value: 'Yemen' },
                        { code: 'sa', name: '{{ app()->getLocale() === "ar" ? "المملكة العربية السعودية" : "Saudi Arabia" }}', value: 'Saudi Arabia' },
                        { code: 'ae', name: '{{ app()->getLocale() === "ar" ? "الإمارات العربية المتحدة" : "United Arab Emirates" }}', value: 'United Arab Emirates' },
                        { code: 'kw', name: '{{ app()->getLocale() === "ar" ? "الكويت" : "Kuwait" }}', value: 'Kuwait' },
                        { code: 'bh', name: '{{ app()->getLocale() === "ar" ? "البحرين" : "Bahrain" }}', value: 'Bahrain' },
                        { code: 'qa', name: '{{ app()->getLocale() === "ar" ? "قطر" : "Qatar" }}', value: 'Qatar' },
                        { code: 'om', name: '{{ app()->getLocale() === "ar" ? "عُمان" : "Oman" }}', value: 'Oman' },
                        { code: 'eg', name: '{{ app()->getLocale() === "ar" ? "مصر" : "Egypt" }}', value: 'Egypt' },
                        { code: 'jo', name: '{{ app()->getLocale() === "ar" ? "الأردن" : "Jordan" }}', value: 'Jordan' },
                    ]
                },
                {
                    name: '{{ app()->getLocale() === "ar" ? "🌍 الشرق الأوسط" : "🌍 Middle East" }}',
                    countries: [
                        { code: 'iq', name: '{{ app()->getLocale() === "ar" ? "العراق" : "Iraq" }}', value: 'Iraq' },
                        { code: 'lb', name: '{{ app()->getLocale() === "ar" ? "لبنان" : "Lebanon" }}', value: 'Lebanon' },
                        { code: 'sy', name: '{{ app()->getLocale() === "ar" ? "سوريا" : "Syria" }}', value: 'Syria' },
                        { code: 'ps', name: '{{ app()->getLocale() === "ar" ? "فلسطين" : "Palestine" }}', value: 'Palestine' },
                        { code: 'tr', name: '{{ app()->getLocale() === "ar" ? "تركيا" : "Turkey" }}', value: 'Turkey' },
                        { code: 'ir', name: '{{ app()->getLocale() === "ar" ? "إيران" : "Iran" }}', value: 'Iran' },
                    ]
                },
                {
                    name: '{{ app()->getLocale() === "ar" ? "🌍 شمال أفريقيا" : "🌍 North Africa" }}',
                    countries: [
                        { code: 'ly', name: '{{ app()->getLocale() === "ar" ? "ليبيا" : "Libya" }}', value: 'Libya' },
                        { code: 'tn', name: '{{ app()->getLocale() === "ar" ? "تونس" : "Tunisia" }}', value: 'Tunisia' },
                        { code: 'dz', name: '{{ app()->getLocale() === "ar" ? "الجزائر" : "Algeria" }}', value: 'Algeria' },
                        { code: 'ma', name: '{{ app()->getLocale() === "ar" ? "المغرب" : "Morocco" }}', value: 'Morocco' },
                        { code: 'sd', name: '{{ app()->getLocale() === "ar" ? "السودان" : "Sudan" }}', value: 'Sudan' },
                    ]
                },
                {
                    name: '{{ app()->getLocale() === "ar" ? "🌍 أوروبا" : "🌍 Europe" }}',
                    countries: [
                        { code: 'gb', name: '{{ app()->getLocale() === "ar" ? "المملكة المتحدة" : "United Kingdom" }}', value: 'United Kingdom' },
                        { code: 'de', name: '{{ app()->getLocale() === "ar" ? "ألمانيا" : "Germany" }}', value: 'Germany' },
                        { code: 'fr', name: '{{ app()->getLocale() === "ar" ? "فرنسا" : "France" }}', value: 'France' },
                        { code: 'it', name: '{{ app()->getLocale() === "ar" ? "إيطاليا" : "Italy" }}', value: 'Italy' },
                        { code: 'es', name: '{{ app()->getLocale() === "ar" ? "إسبانيا" : "Spain" }}', value: 'Spain' },
                        { code: 'nl', name: '{{ app()->getLocale() === "ar" ? "هولندا" : "Netherlands" }}', value: 'Netherlands' },
                        { code: 'se', name: '{{ app()->getLocale() === "ar" ? "السويد" : "Sweden" }}', value: 'Sweden' },
                        { code: 'ch', name: '{{ app()->getLocale() === "ar" ? "سويسرا" : "Switzerland" }}', value: 'Switzerland' },
                        { code: 'be', name: '{{ app()->getLocale() === "ar" ? "بلجيكا" : "Belgium" }}', value: 'Belgium' },
                        { code: 'at', name: '{{ app()->getLocale() === "ar" ? "النمسا" : "Austria" }}', value: 'Austria' },
                        { code: 'pl', name: '{{ app()->getLocale() === "ar" ? "بولندا" : "Poland" }}', value: 'Poland' },
                        { code: 'pt', name: '{{ app()->getLocale() === "ar" ? "البرتغال" : "Portugal" }}', value: 'Portugal' },
                        { code: 'gr', name: '{{ app()->getLocale() === "ar" ? "اليونان" : "Greece" }}', value: 'Greece' },
                        { code: 'no', name: '{{ app()->getLocale() === "ar" ? "النرويج" : "Norway" }}', value: 'Norway' },
                        { code: 'dk', name: '{{ app()->getLocale() === "ar" ? "الدنمارك" : "Denmark" }}', value: 'Denmark' },
                        { code: 'fi', name: '{{ app()->getLocale() === "ar" ? "فنلندا" : "Finland" }}', value: 'Finland' },
                        { code: 'ie', name: '{{ app()->getLocale() === "ar" ? "أيرلندا" : "Ireland" }}', value: 'Ireland' },
                        { code: 'ru', name: '{{ app()->getLocale() === "ar" ? "روسيا" : "Russia" }}', value: 'Russia' },
                    ]
                },
                {
                    name: '{{ app()->getLocale() === "ar" ? "🌍 أمريكا الشمالية" : "🌍 North America" }}',
                    countries: [
                        { code: 'us', name: '{{ app()->getLocale() === "ar" ? "الولايات المتحدة" : "United States" }}', value: 'United States' },
                        { code: 'ca', name: '{{ app()->getLocale() === "ar" ? "كندا" : "Canada" }}', value: 'Canada' },
                        { code: 'mx', name: '{{ app()->getLocale() === "ar" ? "المكسيك" : "Mexico" }}', value: 'Mexico' },
                    ]
                },
                {
                    name: '{{ app()->getLocale() === "ar" ? "🌍 أمريكا الجنوبية" : "🌍 South America" }}',
                    countries: [
                        { code: 'br', name: '{{ app()->getLocale() === "ar" ? "البرازيل" : "Brazil" }}', value: 'Brazil' },
                        { code: 'ar', name: '{{ app()->getLocale() === "ar" ? "الأرجنتين" : "Argentina" }}', value: 'Argentina' },
                        { code: 'co', name: '{{ app()->getLocale() === "ar" ? "كولومبيا" : "Colombia" }}', value: 'Colombia' },
                        { code: 'cl', name: '{{ app()->getLocale() === "ar" ? "تشيلي" : "Chile" }}', value: 'Chile' },
                    ]
                },
                {
                    name: '{{ app()->getLocale() === "ar" ? "🌍 آسيا" : "🌍 Asia" }}',
                    countries: [
                        { code: 'in', name: '{{ app()->getLocale() === "ar" ? "الهند" : "India" }}', value: 'India' },
                        { code: 'pk', name: '{{ app()->getLocale() === "ar" ? "باكستان" : "Pakistan" }}', value: 'Pakistan' },
                        { code: 'cn', name: '{{ app()->getLocale() === "ar" ? "الصين" : "China" }}', value: 'China' },
                        { code: 'jp', name: '{{ app()->getLocale() === "ar" ? "اليابان" : "Japan" }}', value: 'Japan' },
                        { code: 'kr', name: '{{ app()->getLocale() === "ar" ? "كوريا الجنوبية" : "South Korea" }}', value: 'South Korea' },
                        { code: 'my', name: '{{ app()->getLocale() === "ar" ? "ماليزيا" : "Malaysia" }}', value: 'Malaysia' },
                        { code: 'id', name: '{{ app()->getLocale() === "ar" ? "إندونيسيا" : "Indonesia" }}', value: 'Indonesia' },
                        { code: 'sg', name: '{{ app()->getLocale() === "ar" ? "سنغافورة" : "Singapore" }}', value: 'Singapore' },
                        { code: 'th', name: '{{ app()->getLocale() === "ar" ? "تايلاند" : "Thailand" }}', value: 'Thailand' },
                        { code: 'ph', name: '{{ app()->getLocale() === "ar" ? "الفلبين" : "Philippines" }}', value: 'Philippines' },
                        { code: 'vn', name: '{{ app()->getLocale() === "ar" ? "فيتنام" : "Vietnam" }}', value: 'Vietnam' },
                        { code: 'bd', name: '{{ app()->getLocale() === "ar" ? "بنغلاديش" : "Bangladesh" }}', value: 'Bangladesh' },
                    ]
                },
                {
                    name: '{{ app()->getLocale() === "ar" ? "🌍 أوقيانوسيا" : "🌍 Oceania" }}',
                    countries: [
                        { code: 'au', name: '{{ app()->getLocale() === "ar" ? "أستراليا" : "Australia" }}', value: 'Australia' },
                        { code: 'nz', name: '{{ app()->getLocale() === "ar" ? "نيوزيلندا" : "New Zealand" }}', value: 'New Zealand' },
                    ]
                },
                {
                    name: '{{ app()->getLocale() === "ar" ? "🌍 أفريقيا" : "🌍 Africa" }}',
                    countries: [
                        { code: 'za', name: '{{ app()->getLocale() === "ar" ? "جنوب أفريقيا" : "South Africa" }}', value: 'South Africa' },
                        { code: 'ng', name: '{{ app()->getLocale() === "ar" ? "نيجيريا" : "Nigeria" }}', value: 'Nigeria' },
                        { code: 'ke', name: '{{ app()->getLocale() === "ar" ? "كينيا" : "Kenya" }}', value: 'Kenya' },
                        { code: 'gh', name: '{{ app()->getLocale() === "ar" ? "غانا" : "Ghana" }}', value: 'Ghana' },
                    ]
                },
            ],
            
            filteredGroups: [],
            
            init() {
                this.filteredGroups = this.groups;
                // Set initial selection if old value exists
                if (this.selectedValue) {
                    for (let group of this.groups) {
                        for (let country of group.countries) {
                            if (country.value === this.selectedValue) {
                                this.selectedCode = country.code;
                                this.selectedLabel = country.name;
                                break;
                            }
                        }
                    }
                }
            },
            
            filterCountries() {
                if (!this.search) {
                    this.filteredGroups = this.groups;
                    return;
                }
                const searchLower = this.search.toLowerCase();
                this.filteredGroups = this.groups.map(group => ({
                    name: group.name,
                    countries: group.countries.filter(c => 
                        c.name.toLowerCase().includes(searchLower) || 
                        c.value.toLowerCase().includes(searchLower)
                    )
                })).filter(group => group.countries.length > 0);
            },
            
            selectCountry(country) {
                this.selectedCode = country.code;
                this.selectedValue = country.value;
                this.selectedLabel = country.name;
                this.open = false;
                this.search = '';
                this.filteredGroups = this.groups;
            },
            
            getFlag(code) {
                // Return SVG flag using blade-flags CDN
                return `<img src="https://cdn.jsdelivr.net/npm/flag-icons@7.2.3/flags/4x3/${code}.svg" class="w-6 h-4 object-cover rounded" alt="${code}" onerror="this.style.display='none'">`;
            }
        }
    }
    
    // Phone Input Component
    function phoneInput() {
        return {
            openDropdown: false,
            searchPhone: '',
            phoneNumber: '{{ old("shipping_phone") ? preg_replace("/^\+\d+\s*/", "", old("shipping_phone")) : "" }}',
            fullNumber: '{{ old("shipping_phone", "") }}',
            selectedCountry: { code: 'ye', name: '{{ app()->getLocale() === "ar" ? "اليمن" : "Yemen" }}', dialCode: '967' },
            
            phoneCountries: [
                { code: 'ye', name: '{{ app()->getLocale() === "ar" ? "اليمن" : "Yemen" }}', dialCode: '967' },
                { code: 'sa', name: '{{ app()->getLocale() === "ar" ? "السعودية" : "Saudi Arabia" }}', dialCode: '966' },
                { code: 'ae', name: '{{ app()->getLocale() === "ar" ? "الإمارات" : "UAE" }}', dialCode: '971' },
                { code: 'kw', name: '{{ app()->getLocale() === "ar" ? "الكويت" : "Kuwait" }}', dialCode: '965' },
                { code: 'bh', name: '{{ app()->getLocale() === "ar" ? "البحرين" : "Bahrain" }}', dialCode: '973' },
                { code: 'qa', name: '{{ app()->getLocale() === "ar" ? "قطر" : "Qatar" }}', dialCode: '974' },
                { code: 'om', name: '{{ app()->getLocale() === "ar" ? "عُمان" : "Oman" }}', dialCode: '968' },
                { code: 'eg', name: '{{ app()->getLocale() === "ar" ? "مصر" : "Egypt" }}', dialCode: '20' },
                { code: 'jo', name: '{{ app()->getLocale() === "ar" ? "الأردن" : "Jordan" }}', dialCode: '962' },
                { code: 'iq', name: '{{ app()->getLocale() === "ar" ? "العراق" : "Iraq" }}', dialCode: '964' },
                { code: 'lb', name: '{{ app()->getLocale() === "ar" ? "لبنان" : "Lebanon" }}', dialCode: '961' },
                { code: 'sy', name: '{{ app()->getLocale() === "ar" ? "سوريا" : "Syria" }}', dialCode: '963' },
                { code: 'ps', name: '{{ app()->getLocale() === "ar" ? "فلسطين" : "Palestine" }}', dialCode: '970' },
                { code: 'ly', name: '{{ app()->getLocale() === "ar" ? "ليبيا" : "Libya" }}', dialCode: '218' },
                { code: 'tn', name: '{{ app()->getLocale() === "ar" ? "تونس" : "Tunisia" }}', dialCode: '216' },
                { code: 'dz', name: '{{ app()->getLocale() === "ar" ? "الجزائر" : "Algeria" }}', dialCode: '213' },
                { code: 'ma', name: '{{ app()->getLocale() === "ar" ? "المغرب" : "Morocco" }}', dialCode: '212' },
                { code: 'sd', name: '{{ app()->getLocale() === "ar" ? "السودان" : "Sudan" }}', dialCode: '249' },
                { code: 'tr', name: '{{ app()->getLocale() === "ar" ? "تركيا" : "Turkey" }}', dialCode: '90' },
                { code: 'ir', name: '{{ app()->getLocale() === "ar" ? "إيران" : "Iran" }}', dialCode: '98' },
                { code: 'gb', name: '{{ app()->getLocale() === "ar" ? "بريطانيا" : "UK" }}', dialCode: '44' },
                { code: 'de', name: '{{ app()->getLocale() === "ar" ? "ألمانيا" : "Germany" }}', dialCode: '49' },
                { code: 'fr', name: '{{ app()->getLocale() === "ar" ? "فرنسا" : "France" }}', dialCode: '33' },
                { code: 'us', name: '{{ app()->getLocale() === "ar" ? "أمريكا" : "USA" }}', dialCode: '1' },
                { code: 'ca', name: '{{ app()->getLocale() === "ar" ? "كندا" : "Canada" }}', dialCode: '1' },
                { code: 'in', name: '{{ app()->getLocale() === "ar" ? "الهند" : "India" }}', dialCode: '91' },
                { code: 'pk', name: '{{ app()->getLocale() === "ar" ? "باكستان" : "Pakistan" }}', dialCode: '92' },
                { code: 'cn', name: '{{ app()->getLocale() === "ar" ? "الصين" : "China" }}', dialCode: '86' },
                { code: 'jp', name: '{{ app()->getLocale() === "ar" ? "اليابان" : "Japan" }}', dialCode: '81' },
                { code: 'kr', name: '{{ app()->getLocale() === "ar" ? "كوريا" : "S. Korea" }}', dialCode: '82' },
                { code: 'my', name: '{{ app()->getLocale() === "ar" ? "ماليزيا" : "Malaysia" }}', dialCode: '60' },
                { code: 'id', name: '{{ app()->getLocale() === "ar" ? "إندونيسيا" : "Indonesia" }}', dialCode: '62' },
                { code: 'au', name: '{{ app()->getLocale() === "ar" ? "أستراليا" : "Australia" }}', dialCode: '61' },
            ],
            
            filteredPhoneCountries: [],
            
            init() {
                this.filteredPhoneCountries = this.phoneCountries;
                this.updateFullNumber();
            },
            
            filterPhoneCountries() {
                if (!this.searchPhone) {
                    this.filteredPhoneCountries = this.phoneCountries;
                    return;
                }
                const s = this.searchPhone.toLowerCase();
                this.filteredPhoneCountries = this.phoneCountries.filter(c => 
                    c.name.toLowerCase().includes(s) || c.dialCode.includes(s)
                );
            },
            
            selectPhoneCountry(country) {
                this.selectedCountry = country;
                this.openDropdown = false;
                this.searchPhone = '';
                this.filteredPhoneCountries = this.phoneCountries;
                this.updateFullNumber();
            },
            
            updateFullNumber() {
                const num = this.phoneNumber.replace(/\D/g, '');
                this.fullNumber = num ? '+' + this.selectedCountry.dialCode + ' ' + num : '';
            }
        }
    }
    </script>
    @endpush

</x-guest-luxury>
