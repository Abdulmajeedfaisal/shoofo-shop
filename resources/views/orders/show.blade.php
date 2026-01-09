<x-guest-luxury :title="__('orders.order_details') . ' - ' . $order->order_number . ' - ' . config('app.name', 'SHOOFO')">

    <div class="bg-white dark:bg-gray-900 min-h-screen transition-smooth">
        <!-- Breadcrumb -->
        <div class="bg-cream dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <nav class="flex items-center gap-2 text-sm">
                    <a href="{{ route('home') }}" class="text-slate dark:text-gray-400 hover:text-royal-gold transition-colors">
                        {{ app()->getLocale() === 'ar' ? 'الرئيسية' : 'Home' }}
                    </a>
                    <svg class="w-4 h-4 text-slate {{ app()->getLocale() === 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <a href="{{ route('orders.index') }}" class="text-slate dark:text-gray-400 hover:text-royal-gold transition-colors">
                        {{ __('orders.my_orders') }}
                    </a>
                    <svg class="w-4 h-4 text-slate {{ app()->getLocale() === 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <span class="text-charcoal dark:text-white font-medium">{{ $order->order_number }}</span>
                </nav>
            </div>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
            <!-- Page Title -->
            <div class="text-center mb-8">
                <h1 class="text-3xl md:text-4xl font-playfair font-bold text-charcoal dark:text-white">
                    {{ __('orders.order_details') }}
                </h1>
            </div>

            <!-- Order Info Card -->
            <div class="bg-cream dark:bg-gray-800 rounded-2xl p-6 md:p-8 shadow-elegant mb-6">
                <!-- Order Header -->
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

                <!-- Order Status with Timeline -->
                <div class="mb-8">
                    <h3 class="font-semibold text-charcoal dark:text-white mb-4">{{ __('orders.order_status') }}</h3>
                    @php
                        $statuses = ['pending', 'confirmed', 'processing', 'shipped', 'delivered'];
                        $currentIndex = array_search($order->status, $statuses);
                        if ($order->status === 'cancelled') $currentIndex = -1;
                        
                        $statusColors = [
                            'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                            'confirmed' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                            'processing' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400',
                            'shipped' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-400',
                            'delivered' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                            'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                        ];
                        $statusDots = [
                            'pending' => 'bg-yellow-500',
                            'confirmed' => 'bg-blue-500',
                            'processing' => 'bg-purple-500',
                            'shipped' => 'bg-indigo-500',
                            'delivered' => 'bg-green-500',
                            'cancelled' => 'bg-red-500',
                        ];
                    @endphp
                    
                    @if($order->status === 'cancelled')
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold {{ $statusColors['cancelled'] }}">
                            <span class="w-2 h-2 rounded-full {{ $statusDots['cancelled'] }} {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}"></span>
                            {{ __('orders.status.cancelled') }}
                        </span>
                    @else
                        <!-- Status Timeline -->
                        <div class="flex items-center justify-between relative">
                            <!-- Progress Line -->
                            <div class="absolute top-4 {{ app()->getLocale() === 'ar' ? 'right-4 left-4' : 'left-4 right-4' }} h-1 bg-gray-200 dark:bg-gray-700 rounded-full">
                                <div class="h-full bg-royal-gold rounded-full transition-all" style="width: {{ $currentIndex !== false ? ($currentIndex / (count($statuses) - 1)) * 100 : 0 }}%"></div>
                            </div>
                            
                            @foreach($statuses as $index => $status)
                                <div class="relative z-10 flex flex-col items-center">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center {{ $index <= $currentIndex ? 'bg-royal-gold text-midnight' : 'bg-gray-200 dark:bg-gray-700 text-slate dark:text-gray-400' }}">
                                        @if($index < $currentIndex)
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                        @elseif($index === $currentIndex)
                                            <span class="w-3 h-3 bg-midnight rounded-full"></span>
                                        @else
                                            <span class="w-2 h-2 bg-current rounded-full"></span>
                                        @endif
                                    </div>
                                    <span class="mt-2 text-xs font-medium {{ $index <= $currentIndex ? 'text-charcoal dark:text-white' : 'text-slate dark:text-gray-400' }} hidden sm:block">
                                        {{ __('orders.status.' . $status) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Current Status Badge (Mobile) -->
                        <div class="mt-4 sm:hidden">
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold {{ $statusColors[$order->status] }}">
                                <span class="w-2 h-2 rounded-full {{ $statusDots[$order->status] }} {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}"></span>
                                {{ __('orders.status.' . $order->status) }}
                            </span>
                        </div>
                    @endif
                </div>

                <!-- Merchant Orders (Sub-orders) -->
                @if($order->merchantOrders && $order->merchantOrders->count() > 0)
                    <div class="mb-6">
                        <h3 class="font-semibold text-charcoal dark:text-white mb-4">
                            {{ app()->getLocale() === 'ar' ? 'حالة الطلب حسب المتجر' : 'Order Status by Store' }}
                        </h3>
                        
                        @php
                            $merchantStatusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400 border-yellow-200 dark:border-yellow-800',
                                'confirmed' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400 border-blue-200 dark:border-blue-800',
                                'processing' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400 border-purple-200 dark:border-purple-800',
                                'shipped' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-400 border-indigo-200 dark:border-indigo-800',
                                'delivered' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 border-green-200 dark:border-green-800',
                                'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400 border-red-200 dark:border-red-800',
                            ];
                            $merchantStatusLabels = [
                                'pending' => app()->getLocale() === 'ar' ? 'قيد الانتظار' : 'Pending',
                                'confirmed' => app()->getLocale() === 'ar' ? 'مؤكد' : 'Confirmed',
                                'processing' => app()->getLocale() === 'ar' ? 'قيد التجهيز' : 'Processing',
                                'shipped' => app()->getLocale() === 'ar' ? 'تم الشحن' : 'Shipped',
                                'delivered' => app()->getLocale() === 'ar' ? 'تم التسليم' : 'Delivered',
                                'cancelled' => app()->getLocale() === 'ar' ? 'ملغي' : 'Cancelled',
                            ];
                            $merchantStatusIcons = [
                                'pending' => '⏳',
                                'confirmed' => '✅',
                                'processing' => '🔄',
                                'shipped' => '🚚',
                                'delivered' => '📦',
                                'cancelled' => '❌',
                            ];
                        @endphp
                        
                        <div class="space-y-4">
                            @foreach($order->merchantOrders as $merchantOrder)
                                <div class="bg-white dark:bg-gray-700 rounded-xl border border-gray-200 dark:border-gray-600 overflow-hidden">
                                    <!-- Merchant Header with Status -->
                                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-600">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-royal-gold/10 rounded-full flex items-center justify-center">
                                                <svg class="w-5 h-5 text-royal-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-charcoal dark:text-white">
                                                    {{ app()->getLocale() === 'ar' && $merchantOrder->merchant->store_name_ar ? $merchantOrder->merchant->store_name_ar : $merchantOrder->merchant->store_name }}
                                                </p>
                                                <p class="text-xs text-slate dark:text-gray-400">
                                                    {{ $merchantOrder->sub_order_number }}
                                                </p>
                                            </div>
                                        </div>
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-sm font-medium border {{ $merchantStatusColors[$merchantOrder->status] ?? $merchantStatusColors['pending'] }}">
                                            <span>{{ $merchantStatusIcons[$merchantOrder->status] ?? '⏳' }}</span>
                                            {{ $merchantStatusLabels[$merchantOrder->status] ?? $merchantOrder->status }}
                                        </span>
                                    </div>
                                    
                                    <!-- Products in this Merchant Order -->
                                    <div class="p-4 space-y-3">
                                        @foreach($merchantOrder->items as $item)
                                            <div class="flex items-center gap-4">
                                                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-600 rounded-lg overflow-hidden flex-shrink-0">
                                                    @if($item->product && $item->product->images->first())
                                                        <img src="{{ $item->product->images->first()->image_url }}" alt="{{ $item->product_name }}" class="w-full h-full object-cover">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center">
                                                            <svg class="w-6 h-6 text-slate/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="font-medium text-charcoal dark:text-white">
                                                        {{ app()->getLocale() === 'ar' && $item->product_name_ar ? $item->product_name_ar : $item->product_name }}
                                                    </p>
                                                    <p class="text-sm text-slate dark:text-gray-400">
                                                        {{ __('cart.quantity') }}: {{ $item->quantity }} × {{ number_format($item->price, 2) }} SAR
                                                    </p>
                                                </div>
                                                <p class="font-bold text-royal-gold">{{ number_format($item->subtotal, 2) }} SAR</p>
                                            </div>
                                        @endforeach
                                    </div>
                                    
                                    <!-- Merchant Order Subtotal -->
                                    <div class="px-4 py-3 bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-600 flex justify-between items-center">
                                        <span class="text-sm text-slate dark:text-gray-400">
                                            {{ app()->getLocale() === 'ar' ? 'إجمالي المتجر' : 'Store Subtotal' }}
                                        </span>
                                        <span class="font-bold text-charcoal dark:text-white">{{ number_format($merchantOrder->subtotal, 2) }} SAR</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <!-- Fallback: Old style for orders without merchant_orders -->
                    <div class="mb-6">
                        <h3 class="font-semibold text-charcoal dark:text-white mb-4">{{ app()->getLocale() === 'ar' ? 'المنتجات' : 'Products' }}</h3>
                        <div class="space-y-3">
                            @foreach($order->items as $item)
                                <div class="flex items-center gap-4 p-4 bg-white dark:bg-gray-700 rounded-xl">
                                    <div class="w-20 h-20 bg-gray-100 dark:bg-gray-600 rounded-lg overflow-hidden flex-shrink-0">
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
                                    <div class="flex-1 min-w-0">
                                        <p class="font-semibold text-charcoal dark:text-white">
                                            {{ app()->getLocale() === 'ar' && $item->product_name_ar ? $item->product_name_ar : $item->product_name }}
                                        </p>
                                        @if($item->merchant)
                                            <p class="text-sm text-slate dark:text-gray-400">
                                                {{ app()->getLocale() === 'ar' && $item->merchant->store_name_ar ? $item->merchant->store_name_ar : $item->merchant->store_name }}
                                            </p>
                                        @endif
                                        <p class="text-sm text-slate dark:text-gray-400 mt-1">
                                            {{ __('cart.quantity') }}: {{ $item->quantity }} × {{ number_format($item->price, 2) }} SAR
                                        </p>
                                    </div>
                                    <p class="font-bold text-royal-gold text-lg">{{ number_format($item->subtotal, 2) }} SAR</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Shipping Info -->
                <div class="mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="font-semibold text-charcoal dark:text-white mb-3">{{ __('checkout.shipping_information') }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div class="space-y-2">
                            <div class="flex items-center gap-2 text-slate dark:text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                <span>{{ $order->shipping_name }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-slate dark:text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                <span dir="ltr">{{ $order->shipping_phone }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-slate dark:text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                <span>{{ $order->shipping_email }}</span>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <div class="flex items-start gap-2 text-slate dark:text-gray-400">
                                <svg class="w-4 h-4 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span>{{ $order->shipping_address }}<br>{{ $order->shipping_city }}, {{ $order->shipping_country }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Info -->
                <div class="mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="font-semibold text-charcoal dark:text-white mb-3">{{ __('checkout.payment_method') }}</h3>
                    <div class="flex items-center gap-3">
                        @if($order->payment_method === 'cod')
                            <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <div>
                                <p class="font-medium text-charcoal dark:text-white">{{ __('checkout.cash_on_delivery') }}</p>
                                <p class="text-sm text-slate dark:text-gray-400">{{ app()->getLocale() === 'ar' ? 'الدفع عند الاستلام' : 'Pay when you receive' }}</p>
                            </div>
                        @else
                            <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            </div>
                            <div>
                                <p class="font-medium text-charcoal dark:text-white">{{ $order->payment_method }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Order Total -->
                <div class="space-y-3">
                    <div class="flex justify-between text-slate dark:text-gray-400">
                        <span>{{ __('cart.subtotal') }}</span>
                        <span>{{ number_format($order->subtotal, 2) }} SAR</span>
                    </div>
                    @if($order->tax > 0)
                        <div class="flex justify-between text-slate dark:text-gray-400">
                            <span>{{ app()->getLocale() === 'ar' ? 'الضريبة' : 'Tax' }}</span>
                            <span>{{ number_format($order->tax, 2) }} SAR</span>
                        </div>
                    @endif
                    <div class="flex justify-between text-slate dark:text-gray-400">
                        <span>{{ __('cart.shipping') }}</span>
                        <span>{{ $order->shipping > 0 ? number_format($order->shipping, 2) . ' SAR' : (app()->getLocale() === 'ar' ? 'مجاني' : 'Free') }}</span>
                    </div>
                    <div class="flex justify-between text-xl font-bold pt-4 border-t border-gray-200 dark:border-gray-700">
                        <span class="text-charcoal dark:text-white">{{ __('cart.total') }}</span>
                        <span class="text-royal-gold">{{ number_format($order->total, 2) }} SAR</span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('orders.index') }}" class="inline-flex items-center justify-center gap-2 bg-gradient-gold text-midnight px-8 py-4 rounded-xl font-semibold hover:scale-105 hover:shadow-elegant-xl transition-all">
                    <svg class="w-5 h-5 {{ app()->getLocale() === 'ar' ? '' : 'rotate-180' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    {{ app()->getLocale() === 'ar' ? 'العودة للطلبات' : 'Back to Orders' }}
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
