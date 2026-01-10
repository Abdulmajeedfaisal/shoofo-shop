<x-guest-luxury :title="__('orders.my_orders') . ' - ' . config('app.name', 'SHOOFO')">

    <div class="bg-white dark:bg-gray-900 min-h-screen transition-smooth">
        <!-- Breadcrumb -->
        <div class="bg-cream dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <nav class="flex items-center gap-2 text-sm">
                    <a href="{{ route('home') }}" class="text-slate dark:text-gray-400 hover:text-royal-gold transition-colors">
                        {{ __('general.home') }}
                    </a>
                    <svg class="w-4 h-4 text-slate {{ app()->getLocale() === 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <span class="text-charcoal dark:text-white font-medium">{{ __('orders.my_orders') }}</span>
                </nav>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
            <!-- Page Title -->
            <div class="text-center mb-8">
                <h1 class="text-3xl md:text-4xl font-playfair font-bold text-charcoal dark:text-white">
                    {{ __('orders.my_orders') }}
                </h1>
                @if($orders->total() > 0)
                    <p class="text-slate dark:text-gray-400 mt-2">
                        {{ $orders->total() }} {{ $orders->total() == 1 ? __('orders.order') : __('orders.orders') }}
                    </p>
                @endif
            </div>

            @if($orders->count() > 0)
                <!-- Orders List -->
                <div class="space-y-4">
                    @foreach($orders as $order)
                        <div class="bg-cream dark:bg-gray-800 rounded-2xl p-4 md:p-6 shadow-elegant hover:shadow-elegant-lg transition-all">
                            <!-- Order Header -->
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4 pb-4 border-b border-gray-200 dark:border-gray-700">
                                <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-6">
                                    <div>
                                        <p class="text-xs text-slate dark:text-gray-400">{{ __('orders.order_number') }}</p>
                                        <p class="font-bold text-royal-gold">{{ $order->order_number }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate dark:text-gray-400">{{ __('orders.order_date') }}</p>
                                        <p class="font-medium text-charcoal dark:text-white">{{ $order->created_at->format('Y/m/d') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate dark:text-gray-400">{{ __('orders.order_total') }}</p>
                                        <p class="font-bold text-charcoal dark:text-white">{{ number_format($order->total, 2) }} SAR</p>
                                    </div>
                                </div>
                                
                                <!-- Status Badge -->
                                @php
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
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    <span class="w-2 h-2 rounded-full {{ $statusDots[$order->status] ?? 'bg-gray-500' }} {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}"></span>
                                    {{ __('orders.status.' . $order->status) }}
                                </span>
                            </div>

                            <!-- Order Items Preview -->
                            <div class="flex flex-wrap gap-3 mb-4">
                                @foreach($order->items->take(4) as $item)
                                    <div class="w-16 h-16 bg-white dark:bg-gray-700 rounded-lg overflow-hidden flex-shrink-0 shadow-sm">
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
                                @endforeach
                                @if($order->items->count() > 4)
                                    <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                        <span class="text-sm font-semibold text-slate dark:text-gray-400">+{{ $order->items->count() - 4 }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Order Footer -->
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                <p class="text-sm text-slate dark:text-gray-400">
                                    {{ $order->items->count() }} {{ $order->items->count() == 1 ? (app()->getLocale() === 'ar' ? 'منتج' : 'item') : (app()->getLocale() === 'ar' ? 'منتجات' : 'items') }}
                                </p>
                                <a href="{{ route('orders.show', $order) }}" class="inline-flex items-center gap-2 text-royal-gold hover:text-royal-gold/80 font-semibold transition-colors">
                                    {{ __('orders.view_order') }}
                                    <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($orders->hasPages())
                    <div class="mt-8">
                        {{ $orders->links() }}
                    </div>
                @endif

            @else
                <!-- Empty Orders -->
                <div class="text-center py-16">
                    <div class="w-32 h-32 mx-auto mb-6 bg-cream dark:bg-gray-800 rounded-full flex items-center justify-center">
                        <svg class="w-16 h-16 text-slate/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-playfair font-bold text-charcoal dark:text-white mb-2">
                        {{ __('orders.no_orders') }}
                    </h2>
                    <p class="text-slate dark:text-gray-400 mb-8">
                        {{ app()->getLocale() === 'ar' ? 'ابدأ التسوق واكتشف منتجاتنا الفاخرة' : 'Start shopping and discover our luxury products' }}
                    </p>
                    <a href="{{ route('stores.index') }}" class="inline-flex items-center gap-2 bg-gradient-gold text-midnight px-8 py-4 rounded-xl font-semibold hover:scale-105 hover:shadow-elegant-xl transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        {{ __('orders.start_shopping') }}
                    </a>
                </div>
            @endif
        </div>
    </div>

</x-guest-luxury>
