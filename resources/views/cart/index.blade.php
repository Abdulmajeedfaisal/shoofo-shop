<x-guest-luxury :title="__('cart.cart') . ' - ' . config('app.name', 'SHOOFO')">

    <div class="bg-white dark:bg-gray-900 min-h-screen transition-smooth" 
         x-data="cartPage()"
         @cart-updated.window="updateFromEvent($event.detail)">
        
        <!-- Toast Notification -->
        <div x-show="toast.show" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 translate-y-2"
             :class="toast.type === 'success' ? 'bg-green-500' : 'bg-red-500'"
             class="fixed bottom-4 {{ app()->getLocale() === 'ar' ? 'left-4' : 'right-4' }} z-50 px-4 py-2 rounded-lg text-white text-sm font-medium shadow-lg flex items-center gap-2"
             style="display: none;">
            <svg x-show="toast.type === 'success'" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            <span x-text="toast.message"></span>
        </div>

        <!-- Breadcrumb -->
        <div class="bg-cream dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <nav class="flex items-center gap-2 text-sm">
                    <a href="{{ route('home') }}" class="text-slate dark:text-gray-400 hover:text-royal-gold transition-colors">{{ __('general.home') }}</a>
                    <svg class="w-4 h-4 text-slate {{ app()->getLocale() === 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    <span class="text-charcoal dark:text-white font-medium">{{ __('cart.cart') }}</span>
                </nav>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
            <!-- Page Title -->
            <div class="text-center mb-8">
                <h1 class="text-3xl md:text-4xl font-playfair font-bold text-charcoal dark:text-white">{{ __('cart.your_cart') }}</h1>
                <p class="text-slate dark:text-gray-400 mt-2" x-show="itemsCount > 0">
                    <span x-text="itemsCount"></span> {{ __('cart.items') }}
                </p>
            </div>

            <template x-if="!isEmpty">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Cart Items -->
                    <div class="lg:col-span-2 space-y-4">
                        @foreach($items as $index => $item)
                        <div class="bg-cream dark:bg-gray-800 rounded-2xl p-4 md:p-6 shadow-elegant transition-all"
                             x-show="!removedItems.includes({{ $item->id }})"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95">
                            <div class="flex gap-4">
                                <!-- Product Image -->
                                <a href="{{ route('products.show', [$item->product->merchant, $item->product]) }}" class="flex-shrink-0">
                                    <div class="w-24 h-24 md:w-32 md:h-32 bg-white dark:bg-gray-700 rounded-xl overflow-hidden">
                                        @if($item->product->images->first())
                                            <img src="{{ $item->product->images->first()->image_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover hover:scale-105 transition-transform">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <svg class="w-12 h-12 text-slate/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                        @endif
                                    </div>
                                </a>

                                <!-- Product Details -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-2">
                                        <div>
                                            <a href="{{ route('products.show', [$item->product->merchant, $item->product]) }}" class="text-lg font-semibold text-charcoal dark:text-white hover:text-royal-gold transition-colors line-clamp-2">
                                                {{ app()->getLocale() === 'ar' && $item->product->name_ar ? $item->product->name_ar : $item->product->name }}
                                            </a>
                                            <a href="{{ route('stores.show', $item->product->merchant->slug) }}" class="text-sm text-slate dark:text-gray-400 hover:text-royal-gold transition-colors">
                                                {{ app()->getLocale() === 'ar' && $item->product->merchant->store_name_ar ? $item->product->merchant->store_name_ar : $item->product->merchant->store_name }}
                                            </a>
                                        </div>
                                        <p class="text-lg font-bold text-royal-gold">{{ number_format($item->price, 2) }} SAR</p>
                                    </div>

                                    <!-- Quantity & Actions -->
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mt-4">
                                        <!-- Quantity Control -->
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm text-slate dark:text-gray-400">{{ __('cart.quantity') }}:</span>
                                            <div class="flex items-center">
                                                <button type="button" 
                                                        @click="decreaseQty({{ $item->id }}, {{ $index }})"
                                                        :disabled="items[{{ $index }}].qty <= 1 || items[{{ $index }}].loading"
                                                        :class="{ 'opacity-50 cursor-not-allowed': items[{{ $index }}].qty <= 1 || items[{{ $index }}].loading }"
                                                        class="w-8 h-8 rounded-{{ app()->getLocale() === 'ar' ? 'r' : 'l' }}-lg border border-gray-300 dark:border-gray-600 flex items-center justify-center hover:border-royal-gold hover:text-royal-gold transition-colors bg-white dark:bg-gray-700">
                                                    <svg x-show="!items[{{ $index }}].loading" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                                    <svg x-show="items[{{ $index }}].loading" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                                </button>
                                                <input type="number" 
                                                       x-model.number="items[{{ $index }}].qty"
                                                       @change="updateQty({{ $item->id }}, {{ $index }})"
                                                       min="1" max="{{ $item->product->quantity }}"
                                                       :disabled="items[{{ $index }}].loading"
                                                       class="w-12 h-8 text-center text-sm font-bold border-y border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-charcoal dark:text-white">
                                                <button type="button" 
                                                        @click="increaseQty({{ $item->id }}, {{ $index }}, {{ $item->product->quantity }})"
                                                        :disabled="items[{{ $index }}].qty >= {{ $item->product->quantity }} || items[{{ $index }}].loading"
                                                        :class="{ 'opacity-50 cursor-not-allowed': items[{{ $index }}].qty >= {{ $item->product->quantity }} || items[{{ $index }}].loading }"
                                                        class="w-8 h-8 rounded-{{ app()->getLocale() === 'ar' ? 'l' : 'r' }}-lg border border-gray-300 dark:border-gray-600 flex items-center justify-center hover:border-royal-gold hover:text-royal-gold transition-colors bg-white dark:bg-gray-700">
                                                    <svg x-show="!items[{{ $index }}].loading" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                                    <svg x-show="items[{{ $index }}].loading" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-4">
                                            <p class="text-sm text-slate dark:text-gray-400">
                                                {{ __('cart.subtotal') }}: <span class="font-semibold text-charcoal dark:text-white" x-text="items[{{ $index }}].subtotalFormatted"></span> SAR
                                            </p>
                                            <button type="button" @click="removeItem({{ $item->id }})" class="text-red-500 hover:text-red-700 transition-colors p-2 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        <!-- Clear Cart -->
                        <div class="flex justify-end">
                            <form action="{{ route('cart.clear') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-red-500 hover:text-red-700 transition-colors flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    {{ __('cart.clear_cart') }}
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-cream dark:bg-gray-800 rounded-2xl p-6 shadow-elegant sticky top-28">
                            <h2 class="text-xl font-playfair font-bold text-charcoal dark:text-white mb-6">{{ __('cart.order_summary') }}</h2>

                            <div class="space-y-4">
                                <div class="flex justify-between text-slate dark:text-gray-400">
                                    <span>{{ __('cart.subtotal') }} (<span x-text="itemsCount"></span> {{ __('cart.items') }})</span>
                                    <span class="font-semibold text-charcoal dark:text-white"><span x-text="subtotalFormatted"></span> SAR</span>
                                </div>

                                <div class="flex justify-between text-slate dark:text-gray-400">
                                    <span>{{ __('cart.shipping') }}</span>
                                    <span x-show="shippingTotal > 0" class="font-semibold text-charcoal dark:text-white"><span x-text="shippingFormatted"></span> SAR</span>
                                    <span x-show="shippingTotal <= 0" class="text-green-600 font-medium">{{ __('general.free') }}</span>
                                </div>

                                <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                                    <div class="flex justify-between">
                                        <span class="text-lg font-semibold text-charcoal dark:text-white">{{ __('cart.total') }}</span>
                                        <span class="text-xl font-bold text-royal-gold"><span x-text="totalFormatted"></span> SAR</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 space-y-3">
                                <a href="{{ route('checkout.index') }}" class="block w-full bg-gradient-gold text-midnight px-6 py-4 rounded-xl font-semibold text-center hover:scale-[1.02] hover:shadow-elegant-xl transition-all">{{ __('cart.proceed_to_checkout') }}</a>
                                <a href="{{ route('stores.index') }}" class="block w-full border-2 border-gray-300 dark:border-gray-600 text-charcoal dark:text-white px-6 py-3 rounded-xl font-medium text-center hover:border-royal-gold hover:text-royal-gold transition-colors">{{ __('cart.continue_shopping') }}</a>
                            </div>

                            <!-- Trust Badges -->
                            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                                <div class="flex items-center justify-center gap-4 text-slate dark:text-gray-400">
                                    <div class="flex items-center gap-1 text-xs">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                        {{ __('general.secure_payment') }}
                                    </div>
                                    <div class="flex items-center gap-1 text-xs">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                        {{ __('general.quality_guarantee') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            <!-- Empty Cart -->
            <template x-if="isEmpty">
                <div class="text-center py-16">
                    <div class="w-32 h-32 mx-auto mb-6 bg-cream dark:bg-gray-800 rounded-full flex items-center justify-center">
                        <svg class="w-16 h-16 text-slate/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h2 class="text-2xl font-playfair font-bold text-charcoal dark:text-white mb-2">{{ __('cart.empty_cart') }}</h2>
                    <p class="text-slate dark:text-gray-400 mb-8">{{ __('general.start_shopping') }}</p>
                    <a href="{{ route('stores.index') }}" class="inline-flex items-center gap-2 bg-gradient-gold text-midnight px-8 py-4 rounded-xl font-semibold hover:scale-105 hover:shadow-elegant-xl transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        {{ __('cart.continue_shopping') }}
                    </a>
                </div>
            </template>
        </div>
    </div>

    @push('scripts')
    <script>
    function cartPage() {
        return {
            // بيانات العناصر
            items: [
                @foreach($items as $item)
                {
                    id: {{ $item->id }},
                    qty: {{ $item->quantity }},
                    price: {{ $item->price }},
                    subtotal: {{ $item->getSubtotal() }},
                    subtotalFormatted: '{{ number_format($item->getSubtotal(), 2) }}',
                    loading: false
                },
                @endforeach
            ],
            
            // المجاميع
            subtotal: {{ $subtotal }},
            shippingTotal: {{ $shippingTotal }},
            total: {{ $total }},
            itemsCount: {{ $itemsCount }},
            isEmpty: {{ $items->count() === 0 ? 'true' : 'false' }},
            removedItems: [],
            
            // للعرض المنسق
            subtotalFormatted: '{{ number_format($subtotal, 2) }}',
            shippingFormatted: '{{ number_format($shippingTotal, 2) }}',
            totalFormatted: '{{ number_format($total, 2) }}',
            
            // Toast
            toast: { show: false, message: '', type: 'success' },
            
            csrfToken: '{{ csrf_token() }}',
            
            formatNumber(num) {
                return parseFloat(num).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            },
            
            showToast(message, type = 'success') {
                this.toast = { show: true, message, type };
                setTimeout(() => { this.toast.show = false; }, 2000);
            },
            
            updateItemSubtotal(index) {
                const item = this.items[index];
                item.subtotal = item.qty * item.price;
                item.subtotalFormatted = this.formatNumber(item.subtotal);
            },
            
            decreaseQty(itemId, index) {
                if (this.items[index].qty > 1) {
                    this.items[index].qty--;
                    this.updateItemSubtotal(index);
                    this.syncWithServer(itemId, index);
                }
            },
            
            increaseQty(itemId, index, maxQty) {
                if (this.items[index].qty < maxQty) {
                    this.items[index].qty++;
                    this.updateItemSubtotal(index);
                    this.syncWithServer(itemId, index);
                }
            },
            
            updateQty(itemId, index) {
                this.updateItemSubtotal(index);
                this.syncWithServer(itemId, index);
            },
            
            async syncWithServer(itemId, index) {
                this.items[index].loading = true;
                
                try {
                    const response = await fetch(`/cart/update/${itemId}`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': this.csrfToken,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({ quantity: this.items[index].qty })
                    });
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        this.subtotal = data.cart.subtotal;
                        this.subtotalFormatted = data.cart.subtotal_formatted;
                        this.shippingTotal = data.cart.shipping;
                        this.shippingFormatted = data.cart.shipping_formatted || '0.00';
                        this.total = data.cart.total;
                        this.totalFormatted = data.cart.total_formatted;
                        this.itemsCount = data.cart.items_count;
                        
                        // تحديث عداد السلة في Navigation
                        this.updateNavCartCount(this.itemsCount);
                    }
                } catch (error) {
                    console.error('Error:', error);
                    this.showToast('{{ app()->getLocale() === "ar" ? "حدث خطأ" : "Error occurred" }}', 'error');
                }
                
                this.items[index].loading = false;
            },
            
            async removeItem(itemId) {
                if (!confirm('{{ app()->getLocale() === "ar" ? "هل أنت متأكد؟" : "Are you sure?" }}')) return;
                
                try {
                    const response = await fetch(`/cart/remove/${itemId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': this.csrfToken,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        this.removedItems.push(itemId);
                        this.subtotal = data.cart.subtotal;
                        this.subtotalFormatted = data.cart.subtotal_formatted;
                        this.shippingTotal = data.cart.shipping;
                        this.shippingFormatted = data.cart.shipping_formatted || '0.00';
                        this.total = data.cart.total;
                        this.totalFormatted = data.cart.total_formatted;
                        this.itemsCount = data.cart.items_count;
                        this.isEmpty = data.cart.is_empty;
                        
                        this.updateNavCartCount(this.itemsCount);
                        this.showToast('{{ app()->getLocale() === "ar" ? "تم الحذف" : "Removed" }}');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    this.showToast('{{ app()->getLocale() === "ar" ? "حدث خطأ" : "Error" }}', 'error');
                }
            },
            
            updateNavCartCount(count) {
                // تحديث عداد السلة في Navigation
                const badge = document.getElementById('nav-cart-badge');
                if (badge) {
                    if (count > 0) {
                        badge.textContent = count;
                        badge.classList.remove('hidden');
                        badge.classList.add('flex');
                    } else {
                        badge.classList.add('hidden');
                        badge.classList.remove('flex');
                    }
                }
            }
        }
    }
    </script>
    @endpush

</x-guest-luxury>
