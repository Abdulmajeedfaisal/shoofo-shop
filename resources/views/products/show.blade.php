<x-guest-luxury :title="$product->name . ' - ' . $merchant->store_name . ' - ' . config('app.name', 'SHOOFO')">

    @php
        // Check if user came from category page, search page, or home (not from store page)
        $showCinematicEntrance = false;
        $referer = request()->headers->get('referer');
        if ($referer) {
            $refererPath = parse_url($referer, PHP_URL_PATH);
            // Show cinematic entrance if coming from categories, search, or home, but not from store
            if ($refererPath && (str_contains($refererPath, '/categories') || str_contains($refererPath, '/search') || $refererPath === '/' || $refererPath === '')) {
                $showCinematicEntrance = true;
            }
        }
        // Also check query parameter for direct control
        if (request()->has('entrance')) {
            $showCinematicEntrance = request()->get('entrance') === '1';
        }
    @endphp

    <!-- ✨ CINEMATIC LUXURY BOUTIQUE ENTRANCE - Using Component ✨ -->
    <x-cinematic-entrance 
        :show="$showCinematicEntrance" 
        :store-name="$merchant->store_name" 
        :store-name-ar="$merchant->store_name_ar" 
        :logo-url="$merchant->logo_url">

        <div class="bg-white dark:bg-gray-900 transition-smooth">
            <!-- Breadcrumb -->
            <div class="bg-cream dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                    <nav class="flex items-center gap-2 text-sm flex-wrap">
                        <a href="{{ route('home') }}" class="text-slate dark:text-gray-400 hover:text-royal-gold transition-colors">
                            {{ __('general.home') }}
                        </a>
                        <svg class="w-4 h-4 text-slate {{ app()->getLocale() === 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        
                        @php
                            $cameFromSearch = $referer && str_contains(parse_url($referer, PHP_URL_PATH) ?? '', '/search');
                            $cameFromCategory = $referer && str_contains(parse_url($referer, PHP_URL_PATH) ?? '', '/categories');
                        @endphp
                        
                        @if($cameFromSearch)
                            {{-- User came from search page --}}
                            <a href="{{ route('search') }}" class="text-slate dark:text-gray-400 hover:text-royal-gold transition-colors">
                                {{ __('general.search') }}
                            </a>
                        @elseif($cameFromCategory && $product->globalCategory)
                            {{-- User came from categories page --}}
                            <a href="{{ route('categories.show', $product->globalCategory->slug) }}" class="text-slate dark:text-gray-400 hover:text-royal-gold transition-colors">
                                {{ app()->getLocale() === 'ar' && $product->globalCategory->name_ar ? $product->globalCategory->name_ar : $product->globalCategory->name }}
                            </a>
                        @else
                            {{-- User came from store page or direct --}}
                            <a href="{{ route('stores.show', $merchant->slug) }}" class="text-slate dark:text-gray-400 hover:text-royal-gold transition-colors">
                                {{ app()->getLocale() === 'ar' && $merchant->store_name_ar ? $merchant->store_name_ar : $merchant->store_name }}
                            </a>
                        @endif
                        
                        <svg class="w-4 h-4 text-slate {{ app()->getLocale() === 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <span class="text-charcoal dark:text-white font-medium truncate max-w-[200px]">
                            {{ app()->getLocale() === 'ar' && $product->name_ar ? $product->name_ar : $product->name }}
                        </span>
                    </nav>
                </div>
            </div>

            <!-- Product Details -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-10" 
                 x-data="{ 
                     mainImage: '{{ $product->images->first() ? $product->images->first()->image_url : '' }}',
                     currentIndex: 0,
                     quantity: 1,
                     maxQuantity: {{ $product->quantity }},
                     lightboxOpen: false,
                     images: {{ json_encode($product->images->map(fn($img) => $img->image_url)) }}
                 }">            
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-10">
                    <!-- Left Column: Image Gallery -->
                    <div class="space-y-3">
                        <!-- Main Image - Smaller -->
                        <div class="relative aspect-[4/3] max-h-[400px] bg-cream dark:bg-gray-800 rounded-2xl overflow-hidden shadow-elegant group">
                            @if($product->images->count() > 0)
                                <img :src="mainImage" 
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-cover cursor-zoom-in transition-transform duration-500 group-hover:scale-105"
                                     @click="lightboxOpen = true">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-24 h-24 text-slate/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif

                            @if($product->is_featured)
                                <div class="absolute top-4 {{ app()->getLocale() === 'ar' ? 'right-4' : 'left-4' }} bg-royal-gold text-midnight px-4 py-2 rounded-full text-sm font-semibold shadow-lg">
                                    {{ app()->getLocale() === 'ar' ? 'مميز' : 'Featured' }}
                                </div>
                            @endif

                            @if($product->sale_price)
                                <div class="absolute top-4 {{ app()->getLocale() === 'ar' ? 'left-4' : 'right-4' }} bg-red-500 text-white px-4 py-2 rounded-full text-sm font-semibold shadow-lg">
                                    -{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                                </div>
                            @endif
                        </div>

                        @if($product->images->count() > 1)
                            <div class="grid grid-cols-5 sm:grid-cols-6 gap-2">
                                @foreach($product->images as $index => $image)
                                    <button @click="mainImage = '{{ $image->image_url }}'; currentIndex = {{ $index }}"
                                            :class="currentIndex === {{ $index }} ? 'ring-2 ring-royal-gold' : 'ring-1 ring-gray-200'"
                                            class="aspect-square bg-cream rounded-lg overflow-hidden hover:ring-2 hover:ring-royal-gold transition-all">
                                        <img src="{{ $image->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Right Column: Product Info -->
                    <div class="space-y-4">
                        <a href="{{ route('stores.show', $merchant->slug) }}" class="inline-flex items-center gap-2 bg-cream dark:bg-gray-800 px-3 py-2 rounded-xl hover:bg-royal-gold/10 transition-colors group">
                            @if($merchant->logo)
                                <img src="{{ $merchant->logo_url }}" alt="{{ $merchant->store_name }}" class="w-10 h-10 rounded-full object-cover">
                            @else
                                <div class="w-10 h-10 rounded-full bg-gradient-gold flex items-center justify-center">
                                    <span class="text-sm font-playfair font-bold text-midnight">{{ substr($merchant->store_name, 0, 1) }}</span>
                                </div>
                            @endif
                            <div>
                                <p class="text-xs text-slate">{{ app()->getLocale() === 'ar' ? 'المتجر' : 'Store' }}</p>
                                <p class="font-semibold text-sm text-charcoal dark:text-white group-hover:text-royal-gold transition-colors">
                                    {{ app()->getLocale() === 'ar' && $merchant->store_name_ar ? $merchant->store_name_ar : $merchant->store_name }}
                                </p>
                            </div>
                        </a>

                        <h1 class="text-2xl md:text-3xl font-playfair font-bold text-charcoal dark:text-white">
                            {{ app()->getLocale() === 'ar' && $product->name_ar ? $product->name_ar : $product->name }}
                        </h1>

                        <div class="bg-cream dark:bg-gray-800 rounded-xl p-4">
                            @if($product->sale_price)
                                <div class="flex items-center gap-3 flex-wrap">
                                    <span class="text-2xl font-bold text-royal-gold">{{ number_format($product->sale_price, 2) }} SAR</span>
                                    <span class="text-lg text-slate line-through">{{ number_format($product->price, 2) }} SAR</span>
                                </div>
                            @else
                                <span class="text-2xl font-bold text-royal-gold">{{ number_format($product->price, 2) }} SAR</span>
                            @endif
                        </div>

                        <div>
                            @if($product->quantity > 0)
                                <span class="inline-flex items-center text-green-600 font-medium bg-green-50 px-3 py-1.5 rounded-full text-sm">
                                    <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ app()->getLocale() === 'ar' ? 'متوفر' : 'In Stock' }}
                                </span>
                            @else
                                <span class="inline-flex items-center text-red-600 font-medium bg-red-50 px-3 py-1.5 rounded-full text-sm">
                                    {{ app()->getLocale() === 'ar' ? 'غير متوفر' : 'Out of Stock' }}
                                </span>
                            @endif
                        </div>

                        @if($product->quantity > 0)
                            <form action="{{ route('cart.add', $product) }}" method="POST" class="space-y-3">
                                @csrf
                                <div class="space-y-1">
                                    <label class="block text-sm font-medium text-charcoal dark:text-white">{{ app()->getLocale() === 'ar' ? 'الكمية' : 'Quantity' }}</label>
                                    <div class="flex items-center gap-2">
                                        <button type="button" @click="if(quantity > 1) quantity--" class="w-10 h-10 rounded-lg border-2 border-gray-300 flex items-center justify-center hover:border-royal-gold hover:text-royal-gold transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                        </button>
                                        <input type="number" name="quantity" x-model="quantity" readonly class="w-16 h-10 text-center text-lg font-bold border-2 border-gray-300 rounded-lg">
                                        <button type="button" @click="if(quantity < maxQuantity) quantity++" class="w-10 h-10 rounded-lg border-2 border-gray-300 flex items-center justify-center hover:border-royal-gold hover:text-royal-gold transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        </button>
                                    </div>
                                </div>

                                @auth
                                    <button type="submit" class="w-full bg-gradient-gold text-midnight px-6 py-3 rounded-xl font-semibold text-base hover:scale-[1.02] hover:shadow-elegant-xl transition-all flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        <span>{{ app()->getLocale() === 'ar' ? 'أضف إلى السلة' : 'Add to Cart' }}</span>
                                    </button>
                                @else
                                    <a href="{{ route('login') }}" class="block w-full bg-gradient-gold text-midnight px-6 py-3 rounded-xl font-semibold text-base hover:scale-[1.02] hover:shadow-elegant-xl transition-all text-center">
                                        {{ app()->getLocale() === 'ar' ? 'سجل دخولك للشراء' : 'Login to Buy' }}
                                    </a>
                                @endauth
                            </form>
                        @endif

                        @if($product->description || $product->description_ar)
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                                <h3 class="text-lg font-playfair font-semibold text-charcoal dark:text-white mb-2">{{ app()->getLocale() === 'ar' ? 'الوصف' : 'Description' }}</h3>
                                <div class="text-slate dark:text-gray-300 leading-relaxed text-sm prose prose-sm max-w-none">
                                    {!! app()->getLocale() === 'ar' && $product->description_ar ? $product->description_ar : $product->description !!}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Lightbox -->
                <div x-show="lightboxOpen" x-transition @keydown.escape.window="lightboxOpen = false" class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 p-4" style="display: none;">
                    <button @click="lightboxOpen = false" class="absolute top-4 {{ app()->getLocale() === 'ar' ? 'left-4' : 'right-4' }} text-white hover:text-royal-gold">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                    <img :src="mainImage" alt="{{ $product->name }}" class="max-w-full max-h-[85vh] object-contain rounded-lg">
                </div>
            </div>

            @if(isset($relatedProducts) && $relatedProducts->count() > 0)
                <div class="bg-cream dark:bg-gray-800 py-12 md:py-16">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <h2 class="text-2xl md:text-3xl font-playfair font-bold text-charcoal dark:text-white mb-8 text-center">
                            {{ app()->getLocale() === 'ar' ? 'منتجات ذات صلة' : 'Related Products' }}
                        </h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                            @foreach($relatedProducts as $relatedProduct)
                                <x-product-card-store :product="$relatedProduct" />
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

    </x-cinematic-entrance>

</x-guest-luxury>
