<x-guest-luxury :title="(app()->getLocale() === 'ar' ? $globalCategory->name_ar : $globalCategory->name) . ' - ' . config('app.name', 'SHOOFO')">

    <!-- Breadcrumb - Enhanced -->
    <div class="bg-gradient-to-r from-cream to-gray-50 dark:from-gray-900 dark:to-gray-800 border-b-2 border-royal-gold/10 transition-smooth">
        <div class="max-w-7xl mx-auto px-6 py-5">
            <nav class="flex items-center gap-3 text-sm">
                <a href="{{ route('home') }}" class="text-slate hover:text-royal-gold transition-elegant flex items-center gap-1 font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    {{ __('navigation.home') }}
                </a>
                <svg class="w-4 h-4 text-royal-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <a href="{{ route('categories.index') }}" class="text-slate hover:text-royal-gold transition-elegant font-medium">
                    {{ __('navigation.categories') }}
                </a>
                <svg class="w-4 h-4 text-royal-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="text-charcoal dark:text-royal-gold-light font-semibold">
                    {{ app()->getLocale() === 'ar' ? $globalCategory->name_ar : $globalCategory->name }}
                </span>
            </nav>
        </div>
    </div>

    <!-- PREMIUM HERO BANNER -->
    <section class="relative h-64 overflow-hidden">
        @php
            // Premium category hero images
            $categoryHeroImages = [
                'fashion' => 'https://images.unsplash.com/photo-1445205170230-053b83016050?w=1920&h=600&fit=crop&q=90',
                'electronics' => 'https://images.unsplash.com/photo-1498049794561-7780e7231661?w=1920&h=600&fit=crop&q=90',
                'sports' => 'https://images.unsplash.com/photo-1461896836934-ffe607ba8211?w=1920&h=600&fit=crop&q=90',
                'home' => 'https://images.unsplash.com/photo-1484101403633-562f891dc89a?w=1920&h=600&fit=crop&q=90',
                'beauty' => 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?w=1920&h=600&fit=crop&q=90',
                'book' => 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=1920&h=600&fit=crop&q=90',
                'toys' => 'https://images.unsplash.com/photo-1558060370-d644479cb6f7?w=1920&h=600&fit=crop&q=90',
            ];
            $categorySlug = strtolower($globalCategory->slug);
            $categoryHero = 'https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?w=1920&h=600&fit=crop&q=90'; // default luxury shopping
            
            foreach($categoryHeroImages as $key => $url) {
                if(str_contains($categorySlug, $key)) {
                    $categoryHero = $url;
                    break;
                }
            }
        @endphp
        
        <!-- Hero Image -->
        <div class="absolute inset-0">
            <img 
                src="{{ $categoryHero }}" 
                alt="{{ app()->getLocale() === 'ar' ? $globalCategory->name_ar : $globalCategory->name }}"
                class="w-full h-full object-cover"
            >
        </div>
        
        <!-- Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-b from-midnight/60 via-midnight/70 to-midnight/90"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-midnight/80 via-midnight/40 to-transparent"></div>
        
        <!-- Content -->
        <div class="absolute inset-0 flex items-center">
            <div class="max-w-7xl mx-auto px-6 w-full">
                <div class="flex flex-col md:flex-row items-center md:items-end gap-6 md:gap-10">
                    <!-- Large Icon Badge -->
                    @if($globalCategory->icon)
                    <div class="flex-shrink-0">
                        <div class="w-28 h-28 md:w-32 md:h-32 rounded-3xl bg-white/10 backdrop-blur-md border-4 border-white/20 shadow-2xl flex items-center justify-center p-4 md:p-6">
                            <img 
                                src="{{ $globalCategory->icon }}" 
                                alt="{{ app()->getLocale() === 'ar' ? $globalCategory->name_ar : $globalCategory->name }}"
                                class="w-full h-full object-contain drop-shadow-2xl"
                            >
                        </div>
                    </div>
                    @else
                    <div class="flex-shrink-0">
                        <div class="w-28 h-28 md:w-32 md:h-32 rounded-3xl bg-gradient-gold flex items-center justify-center shadow-2xl border-4 border-white/20">
                            <span class="text-6xl md:text-7xl">💎</span>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Category Info -->
                    <div class="flex-1 text-white text-center md:text-left">
                        <!-- Category Name -->
                        <h1 class="text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-playfair font-black mb-3 leading-tight">
                            {{ app()->getLocale() === 'ar' ? $globalCategory->name_ar : $globalCategory->name }}
                        </h1>
                        
                        <!-- Description -->
                        @if($globalCategory->description || $globalCategory->description_ar)
                        <p class="text-base md:text-lg lg:text-xl opacity-95 max-w-3xl font-light leading-relaxed mb-4">
                            {{ app()->getLocale() === 'ar' ? $globalCategory->description_ar : $globalCategory->description }}
                        </p>
                        @endif
                        
                        <!-- Product Count Badge -->
                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-md rounded-2xl border border-white/20">
                            <svg class="w-6 h-6 text-royal-gold-light" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <span class="text-xl md:text-2xl font-bold text-royal-gold-light">{{ $products->total() }}</span>
                            <span class="text-sm md:text-base opacity-90">{{ __('products.products') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section class="py-12 md:py-16 bg-gradient-to-b from-white via-gray-50 to-white dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 transition-smooth">
        <div class="max-w-7xl mx-auto px-6">
            <!-- Filter/Sort Bar -->
            <div class="mb-6 md:mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 p-4 md:p-6 bg-white dark:bg-gray-800 rounded-2xl shadow-elegant border-2 border-royal-gold/10">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-royal-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-charcoal dark:text-white">
                        {{ app()->getLocale() === 'ar' ? 'تصفية المنتجات' : 'Filter Products' }}
                    </h3>
                </div>
                
                <!-- Sort Options -->
                <div class="flex items-center gap-4">
                    <label class="text-sm text-slate dark:text-gray-400 font-medium">
                        {{ app()->getLocale() === 'ar' ? 'ترتيب حسب:' : 'Sort by:' }}
                    </label>
                    <select class="px-5 py-2.5 border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-charcoal dark:text-white rounded-xl focus:ring-2 focus:ring-royal-gold focus:border-royal-gold transition-elegant font-medium shadow-sm hover:border-royal-gold/50">
                        <option>{{ app()->getLocale() === 'ar' ? 'مميز' : 'Featured' }}</option>
                        <option>{{ app()->getLocale() === 'ar' ? 'السعر: من الأقل للأعلى' : 'Price: Low to High' }}</option>
                        <option>{{ app()->getLocale() === 'ar' ? 'السعر: من الأعلى للأقل' : 'Price: High to Low' }}</option>
                        <option>{{ app()->getLocale() === 'ar' ? 'الأحدث' : 'Newest' }}</option>
                    </select>
                </div>
            </div>

            @if($products->count() > 0)
            <!-- Products Grid - Enhanced -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-8 mb-12">
                @foreach($products as $product)
                <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}" data-aos-duration="600">
                    <x-product-card :product="$product" :showStore="true" />
                </div>
                @endforeach
            </div>

            <!-- Pagination - Enhanced -->
            <div class="flex justify-center">
                <div class="inline-flex rounded-2xl overflow-hidden shadow-elegant border-2 border-royal-gold/20">
                    {{ $products->links() }}
                </div>
            </div>
            @else
            <!-- Empty State - Enhanced -->
            <div class="text-center py-20">
                <div class="inline-flex items-center justify-center w-32 h-32 rounded-full bg-royal-gold/10 mb-8">
                    <svg class="w-16 h-16 text-royal-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                </div>
                <h3 class="font-playfair text-3xl font-bold text-charcoal dark:text-white mb-4">
                    {{ app()->getLocale() === 'ar' ? 'لا توجد منتجات بعد' : 'No Products Yet' }}
                </h3>
                <p class="text-slate dark:text-gray-400 text-lg mb-8 max-w-md mx-auto">
                    {{ app()->getLocale() === 'ar' ? 'تابعنا قريباً لمنتجات فاخرة في هذه الفئة' : 'Check back soon for luxury products in this category' }}
                </p>
                <x-button variant="primary" size="lg" href="{{ route('categories.index') }}">
                    <svg class="w-5 h-5 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    {{ __('navigation.categories') }}
                </x-button>
            </div>
            @endif
        </div>
    </section>

</x-guest-luxury>
