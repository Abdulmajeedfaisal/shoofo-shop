<x-guest-luxury :title="__('orders.order_confirmation') . ' - ' . config('app.name', 'SHOOFO')">

    <div class="bg-white dark:bg-gray-900 min-h-screen transition-smooth">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-20">
            <!-- Success Icon -->
            <div class="text-center mb-8">
                <div class="w-24 h-24 mx-auto mb-6 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h1 class="text-3xl md:text-4xl font-playfair font-bold text-charcoal dark:text-white mb-2">
                    {{ __('orders.thank_you') }}
                </h1>
                <p class="text-slate dark:text-gray-400">
                    {{ __('orders.order_received') }}
                </p>
            </div>

            <!-- Order Details Card -->
            <div class="bg-cream dark:bg-gray-800 rounded-2xl p-6 md:p-8 shadow-elegant mb-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                    <div>
                        <p class="text-sm text-slate dark:text-gray-400">{{ __('orders.order_number') }}</p>
                        <p class="text-xl font-bold text-royal-gold">{{ $order->order_number }}</p>
                    </div>
                    <div class="text-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }}">
                        <p class="text-sm text-slate dark:text-gray-400">{{ __('orders.order_date') }}</p>
                        <p class="font-semibold text-charcoal dark:text-white">{{ $order->created_at->format('Y/m/d - H:i') }}</p>
                    </div>
                </div>

                <!-- Order Status -->
                <div class="mb-6">
                    <p class="text-sm text-slate dark:text-gray-400 mb-2">{{ __('orders.order_status') }}</p>
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                        <span class="w-2 h-2 rounded-full bg-yellow-500 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}"></span>
                        {{ __('orders.status.' . $order->status) }}
                    </span>
                </div>

                <!-- Order Items -->
                <div class="mb-6">
                    <h3 class="font-semibold text-charcoal dark:text-white mb-4">{{ app()->getLocale() === 'ar' ? 'المنتجات' : 'Products' }}</h3>
                    <div class="space-y-3">
                        @foreach($order->items as $item)
                            <div class="flex items-center gap-4 p-3 bg-white dark:bg-gray-700 rounded-xl">
                                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-600 rounded-lg overflow-hidden flex-shrink-0">
                                    @if($item->product && $item->product->images->first())
                                        <img src="{{ $item->product->images->first()->image_url }}" alt="{{ $item->product_name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-8 h-8 text-slate/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-charcoal dark:text-white">
                                        {{ app()->getLocale() === 'ar' && $item->product_name_ar ? $item->product_name_ar : $item->product_name }}
                                    </p>
                                    <p class="text-sm text-slate dark:text-gray-400">{{ __('cart.quantity') }}: {{ $item->quantity }} × {{ number_format($item->price, 2) }} SAR</p>
                                </div>
                                <p class="font-semibold text-royal-gold">{{ number_format($item->subtotal, 2) }} SAR</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Shipping Info -->
                <div class="mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="font-semibold text-charcoal dark:text-white mb-3">{{ __('checkout.shipping_information') }}</h3>
                    <div class="text-slate dark:text-gray-400 text-sm space-y-1">
                        <p>{{ $order->shipping_name }}</p>
                        <p>{{ $order->shipping_phone }}</p>
                        <p>{{ $order->shipping_address }}</p>
                        <p>{{ $order->shipping_city }}, {{ $order->shipping_country }}</p>
                    </div>
                </div>

                <!-- Order Total -->
                <div class="space-y-2">
                    <div class="flex justify-between text-slate dark:text-gray-400">
                        <span>{{ __('cart.subtotal') }}</span>
                        <span>{{ number_format($order->subtotal, 2) }} SAR</span>
                    </div>
                    <div class="flex justify-between text-slate dark:text-gray-400">
                        <span>{{ __('cart.shipping') }}</span>
                        <span>{{ $order->shipping > 0 ? number_format($order->shipping, 2) . ' SAR' : (app()->getLocale() === 'ar' ? 'مجاني' : 'Free') }}</span>
                    </div>
                    <div class="flex justify-between text-xl font-bold pt-3 border-t border-gray-200 dark:border-gray-700">
                        <span class="text-charcoal dark:text-white">{{ __('cart.total') }}</span>
                        <span class="text-royal-gold">{{ number_format($order->total, 2) }} SAR</span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('orders.index') }}" class="inline-flex items-center justify-center gap-2 bg-gradient-gold text-midnight px-8 py-4 rounded-xl font-semibold hover:scale-105 hover:shadow-elegant-xl transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    {{ __('orders.my_orders') }}
                </a>
                <a href="{{ route('stores.index') }}" class="inline-flex items-center justify-center gap-2 border-2 border-gray-300 dark:border-gray-600 text-charcoal dark:text-white px-8 py-4 rounded-xl font-semibold hover:border-royal-gold hover:text-royal-gold transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    {{ __('cart.continue_shopping') }}
                </a>
            </div>
        </div>
    </div>

</x-guest-luxury>
