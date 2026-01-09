<x-guest-luxury :title="(app()->getLocale() === 'ar' ? $globalCategory->name_ar : $globalCategory->name) . ' - ' . config('app.name', 'SHOOFO')">

    <!-- Breadcrumb -->
    <div class="bg-gradient-to-r from-cream to-gray-50 dark:from-gray-900 dark:to-gray-800 border-b border-gray-200 dark:border-gray-700 transition-smooth">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex items-center gap-2 text-sm">
                <a href="{{ route('home') }}" class="text-slate hover:text-royal-gold transition-elegant flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    {{ app()->getLocale() === 'ar' ? 'الرئيسية' : 'Home' }}
                </a>
                <svg class="w-4 h-4 text-slate {{ app()->getLocale() === 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <a href="{{ route('categories.index') }}" class="text-slate hover:text-royal-gold transition-elegant">
                    {{ app()->getLocale() === 'ar' ? 'الفئات' : 'Categories' }}
                </a>
                <svg class="w-4 h-4 text-slate {{ app()->getLocale() === 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="text-charcoal dark:text-white font-medium">
                    {{ app()->getLocale() === 'ar' ? $globalCategory->name_ar : $globalCategory->name }}
                </span>
            </nav>
        </div>
    </div>

    <!-- Category Hero -->
    <section class="relative h-48 md:h-56 overflow-hidden">
        @php
            $categoryHeroImages = [
                'fashion' => 'https://images.unsplash.com/photo-1445205170230-053b83016050?w=1920&h=400&fit=crop&q=80',
                'electronics' => 'https://images.unsplash.com/photo-1498049794561-7780e7231661?w=1920&h=400&fit=crop&q=80',
                'sports' => 'https://images.unsplash.com/photo-1461896836934-ffe607ba8211?w=1920&h=400&fit=crop&q=80',
                'home' => 'https://images.unsplash.com/photo-1484101403633-562f891dc89a?w=1920&h=400&fit=crop&q=80',
                'beauty' => 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?w=1920&h=400&fit=crop&q=80',
                'book' => 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=1920&h=400&fit=crop&q=80',
            ];
            $categorySlug = strtolower($globalCategory->slug);
            $categoryHero = 'https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?w=1920&h=400&fit=crop&q=80';
            foreach($categoryHeroImages as $key => $url) {
                if(str_contains($categorySlug, $key)) {
                    $categoryHero = $url;
                    break;
                }
            }
        @endphp
        
        <div class="absolute inset-0">
            <img src="{{ $categoryHero }}" alt="{{ app()->getLocale() === 'ar' ? $globalCategory->name_ar : $globalCategory->name }}" class="w-full h-full object-cover">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-midnight/50 via-midnight/60 to-midnight/80"></div>
        
        <div class="absolute inset-0 flex items-center">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                <div class="flex items-center gap-4 md:gap-6">
                    @if($globalCategory->icon)
                    <div class="w-16 h-16 md:w-20 md:h-20 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center p-3">
                        <img src="{{ $globalCategory->icon }}" alt="" class="w-full h-full object-contain">
                    </div>
                    @else
                    <div class="w-16 h-16 md:w-20 md:h-20 rounded-2xl bg-gradient-gold flex items-center justify-center">
                        <span class="text-3xl md:text-4xl">💎</span>
                    </div>
                    @endif
                    
                    <div class="text-white">
                        <h1 class="text-2xl md:text-3xl lg:text-4xl font-playfair font-bold mb-1">
                            {{ app()->getLocale() === 'ar' ? $globalCategory->name_ar : $globalCategory->name }}
                        </h1>
                        <p class="text-white/80 text-sm md:text-base flex items-center gap-2">
                            <span class="font-bold text-royal-gold">{{ $totalProducts }}</span>
                            {{ app()->getLocale() === 'ar' ? 'منتج' : 'products' }}
                            @if($search)
                                <span class="text-white/60">•</span>
                                <span>{{ app()->getLocale() === 'ar' ? 'نتائج البحث عن' : 'Results for' }} "{{ $search }}"</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="bg-white dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Filters Sidebar -->
                <div class="lg:w-72 flex-shrink-0">
                    <div x-data="{ filtersOpen: window.innerWidth >= 1024 }" class="sticky top-28">
                        <!-- Mobile Filter Toggle -->
                        <button @click="filtersOpen = !filtersOpen" class="lg:hidden w-full flex items-center justify-between p-4 bg-cream dark:bg-gray-800 rounded-xl mb-4">
                            <span class="font-semibold text-charcoal dark:text-white flex items-center gap-2">
                                <svg class="w-5 h-5 text-royal-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                </svg>
                                {{ app()->getLocale() === 'ar' ? 'الفلاتر والبحث' : 'Filters & Search' }}
                            </span>
                            <svg class="w-5 h-5 transition-transform" :class="{ 'rotate-180': filtersOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <form action="{{ route('categories.show', $globalCategory->slug) }}" method="GET" x-show="filtersOpen" x-transition class="bg-cream dark:bg-gray-800 rounded-2xl p-6 space-y-6">
                            <!-- Search within Category -->
                            <div>
                                <h3 class="font-semibold text-charcoal dark:text-white mb-3 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-royal-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    {{ app()->getLocale() === 'ar' ? 'بحث في الفئة' : 'Search in Category' }}
                                </h3>
                                <div class="relative">
                                    <input type="text" 
                                           name="q" 
                                           value="{{ $search }}"
                                           placeholder="{{ app()->getLocale() === 'ar' ? 'ابحث عن منتج...' : 'Search products...' }}"
                                           class="w-full px-4 py-2.5 {{ app()->getLocale() === 'ar' ? 'pr-10' : 'pl-10' }} rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-charcoal dark:text-white placeholder-slate focus:ring-2 focus:ring-royal-gold focus:border-transparent text-sm">
                                    <svg class="w-4 h-4 absolute {{ app()->getLocale() === 'ar' ? 'right-3' : 'left-3' }} top-1/2 -translate-y-1/2 text-slate" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            
                            <!-- Store Filter -->
                            @if($categoryStores->count() > 1)
                            <div>
                                <h3 class="font-semibold text-charcoal dark:text-white mb-3">
                                    {{ app()->getLocale() === 'ar' ? 'المتجر' : 'Store' }}
                                </h3>
                                <select name="store" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-charcoal dark:text-white focus:ring-2 focus:ring-royal-gold focus:border-transparent text-sm">
                                    <option value="">{{ app()->getLocale() === 'ar' ? 'جميع المتاجر' : 'All Stores' }}</option>
                                    @foreach($categoryStores as $st)
                                        <option value="{{ $st->id }}" {{ $selectedStore == $st->id ? 'selected' : '' }}>
                                            {{ app()->getLocale() === 'ar' && $st->store_name_ar ? $st->store_name_ar : $st->store_name }}
                                            ({{ $st->products_count }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
                            
                            <!-- Price Range -->
                            <div>
                                <h3 class="font-semibold text-charcoal dark:text-white mb-3">
                                    {{ app()->getLocale() === 'ar' ? 'نطاق السعر' : 'Price Range' }}
                                </h3>
                                <div class="flex items-center gap-2">
                                    <input type="number" 
                                           name="min_price" 
                                           value="{{ $minPrice }}" 
                                           placeholder="{{ app()->getLocale() === 'ar' ? 'من' : 'Min' }}" 
                                           min="0" 
                                           class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-charcoal dark:text-white focus:ring-2 focus:ring-royal-gold focus:border-transparent text-sm">
                                    <span class="text-slate">-</span>
                                    <input type="number" 
                                           name="max_price" 
                                           value="{{ $maxPrice }}" 
                                           placeholder="{{ app()->getLocale() === 'ar' ? 'إلى' : 'Max' }}" 
                                           min="0" 
                                           class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-charcoal dark:text-white focus:ring-2 focus:ring-royal-gold focus:border-transparent text-sm">
                                </div>
                            </div>
                            
                            <!-- In Stock -->
                            <div>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="in_stock" value="1" {{ $inStock ? 'checked' : '' }} class="rounded text-royal-gold focus:ring-royal-gold">
                                    <span class="text-charcoal dark:text-gray-300 text-sm">{{ app()->getLocale() === 'ar' ? 'متوفر فقط' : 'In Stock Only' }}</span>
                                </label>
                            </div>
                            
                            <!-- Sort -->
                            <div>
                                <h3 class="font-semibold text-charcoal dark:text-white mb-3">
                                    {{ app()->getLocale() === 'ar' ? 'الترتيب' : 'Sort By' }}
                                </h3>
                                <select name="sort" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-charcoal dark:text-white focus:ring-2 focus:ring-royal-gold focus:border-transparent text-sm">
                                    <option value="featured" {{ $sort === 'featured' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'مميز' : 'Featured' }}</option>
                                    <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'الأحدث' : 'Newest' }}</option>
                                    <option value="price_low" {{ $sort === 'price_low' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'السعر: من الأقل' : 'Price: Low to High' }}</option>
                                    <option value="price_high" {{ $sort === 'price_high' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'السعر: من الأعلى' : 'Price: High to Low' }}</option>
                                    <option value="popular" {{ $sort === 'popular' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'الأكثر مشاهدة' : 'Most Viewed' }}</option>
                                </select>
                            </div>
                            
                            <!-- Apply Button -->
                            <button type="submit" class="w-full bg-gradient-gold text-midnight py-3 rounded-xl font-semibold hover:scale-[1.02] transition-all flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                </svg>
                                {{ app()->getLocale() === 'ar' ? 'تطبيق الفلاتر' : 'Apply Filters' }}
                            </button>
                            
                            <!-- Clear Filters -->
                            @if($search || $selectedStore || $minPrice || $maxPrice || $inStock || $sort !== 'featured')
                            <a href="{{ route('categories.show', $globalCategory->slug) }}" class="block w-full text-center text-slate hover:text-royal-gold transition-colors text-sm">
                                {{ app()->getLocale() === 'ar' ? 'مسح الفلاتر' : 'Clear Filters' }}
                            </a>
                            @endif
                        </form>
                    </div>
                </div>

                <!-- Products Section -->
                <div class="flex-1">
                    <!-- Active Filters Tags -->
                    @if($search || $selectedStore || $minPrice || $maxPrice || $inStock)
                    <div class="mb-6 flex flex-wrap items-center gap-2">
                        <span class="text-sm text-slate dark:text-gray-400">{{ app()->getLocale() === 'ar' ? 'الفلاتر النشطة:' : 'Active filters:' }}</span>
                        
                        @if($search)
                        <a href="{{ route('categories.show', array_merge(['slug' => $globalCategory->slug], request()->except('q'))) }}" class="inline-flex items-center gap-1 px-3 py-1 bg-royal-gold/10 text-royal-gold rounded-full text-sm hover:bg-royal-gold/20 transition-colors">
                            {{ app()->getLocale() === 'ar' ? 'بحث:' : 'Search:' }} {{ $search }}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </a>
                        @endif
                        
                        @if($selectedStore)
                        @php $storeName = $categoryStores->firstWhere('id', $selectedStore); @endphp
                        <a href="{{ route('categories.show', array_merge(['slug' => $globalCategory->slug], request()->except('store'))) }}" class="inline-flex items-center gap-1 px-3 py-1 bg-royal-gold/10 text-royal-gold rounded-full text-sm hover:bg-royal-gold/20 transition-colors">
                            {{ app()->getLocale() === 'ar' ? 'متجر:' : 'Store:' }} {{ $storeName ? (app()->getLocale() === 'ar' && $storeName->store_name_ar ? $storeName->store_name_ar : $storeName->store_name) : '' }}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </a>
                        @endif
                        
                        @if($minPrice || $maxPrice)
                        <a href="{{ route('categories.show', array_merge(['slug' => $globalCategory->slug], request()->except(['min_price', 'max_price']))) }}" class="inline-flex items-center gap-1 px-3 py-1 bg-royal-gold/10 text-royal-gold rounded-full text-sm hover:bg-royal-gold/20 transition-colors">
                            {{ app()->getLocale() === 'ar' ? 'السعر:' : 'Price:' }} {{ $minPrice ?: '0' }} - {{ $maxPrice ?: '∞' }}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </a>
                        @endif
                        
                        @if($inStock)
                        <a href="{{ route('categories.show', array_merge(['slug' => $globalCategory->slug], request()->except('in_stock'))) }}" class="inline-flex items-center gap-1 px-3 py-1 bg-royal-gold/10 text-royal-gold rounded-full text-sm hover:bg-royal-gold/20 transition-colors">
                            {{ app()->getLocale() === 'ar' ? 'متوفر فقط' : 'In Stock' }}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </a>
                        @endif
                    </div>
                    @endif

                    @if($products->count() > 0)
                    <!-- Products Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($products as $product)
                        <x-product-card :product="$product" :showStore="true" />
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($products->hasPages())
                    <div class="mt-10">
                        {{ $products->links() }}
                    </div>
                    @endif
                    @else
                    <!-- No Products Found -->
                    <div class="text-center py-16">
                        <div class="w-32 h-32 mx-auto mb-6 bg-cream dark:bg-gray-800 rounded-full flex items-center justify-center">
                            <svg class="w-16 h-16 text-slate/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-playfair font-bold text-charcoal dark:text-white mb-2">
                            {{ app()->getLocale() === 'ar' ? 'لا توجد منتجات' : 'No Products Found' }}
                        </h3>
                        @if($search || $selectedStore || $minPrice || $maxPrice || $inStock)
                        <p class="text-slate dark:text-gray-400 mb-6">
                            {{ app()->getLocale() === 'ar' ? 'لا توجد منتجات تطابق الفلاتر المحددة' : 'No products match the selected filters' }}
                        </p>
                        <a href="{{ route('categories.show', $globalCategory->slug) }}" class="inline-flex items-center gap-2 px-6 py-3 bg-royal-gold text-midnight rounded-xl font-semibold hover:scale-105 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            {{ app()->getLocale() === 'ar' ? 'مسح الفلاتر' : 'Clear Filters' }}
                        </a>
                        @else
                        <p class="text-slate dark:text-gray-400 mb-6">
                            {{ app()->getLocale() === 'ar' ? 'لا توجد منتجات في هذه الفئة حالياً' : 'No products in this category yet' }}
                        </p>
                        <a href="{{ route('categories.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-royal-gold text-midnight rounded-xl font-semibold hover:scale-105 transition-all">
                            <svg class="w-5 h-5 {{ app()->getLocale() === 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            {{ app()->getLocale() === 'ar' ? 'تصفح الفئات' : 'Browse Categories' }}
                        </a>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</x-guest-luxury>
