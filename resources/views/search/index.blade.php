<x-guest-luxury :title="($query ? $query . ' - ' : '') . __('search.search') . ' - ' . config('app.name', 'SHOOFO')">

    <div class="bg-white dark:bg-gray-900 min-h-screen transition-smooth">
        <!-- Search Header -->
        <div class="bg-gradient-to-br from-midnight via-charcoal to-midnight text-white py-8 md:py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-6">
                    <h1 class="text-3xl md:text-4xl font-playfair font-bold mb-4">
                        {{ app()->getLocale() === 'ar' ? 'البحث' : 'Search' }}
                    </h1>
                </div>
                
                <!-- Search Form -->
                <form action="{{ route('search') }}" method="GET" class="max-w-3xl mx-auto">
                    <div class="relative">
                        <input type="text" 
                               name="q" 
                               value="{{ $query }}"
                               placeholder="{{ app()->getLocale() === 'ar' ? 'ابحث عن منتجات، متاجر...' : 'Search for products, stores...' }}"
                               class="w-full px-6 py-4 {{ app()->getLocale() === 'ar' ? 'pr-14' : 'pl-14' }} rounded-2xl bg-white/10 backdrop-blur-md border-2 border-white/20 text-white placeholder-white/60 focus:border-royal-gold focus:ring-2 focus:ring-royal-gold/50 transition-all text-lg"
                               autocomplete="off">
                        <button type="submit" class="absolute {{ app()->getLocale() === 'ar' ? 'right-4' : 'left-4' }} top-1/2 -translate-y-1/2 text-white/60 hover:text-royal-gold transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                        @if($query)
                        <a href="{{ route('search') }}" class="absolute {{ app()->getLocale() === 'ar' ? 'left-4' : 'right-4' }} top-1/2 -translate-y-1/2 text-white/60 hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </a>
                        @endif
                    </div>
                    
                    <!-- Hidden filters to preserve on search -->
                    @if($type !== 'all')<input type="hidden" name="type" value="{{ $type }}">@endif
                    @if($selectedCategory)<input type="hidden" name="category" value="{{ $selectedCategory }}">@endif
                    @if($selectedStore)<input type="hidden" name="store" value="{{ $selectedStore }}">@endif
                    @if($minPrice)<input type="hidden" name="min_price" value="{{ $minPrice }}">@endif
                    @if($maxPrice)<input type="hidden" name="max_price" value="{{ $maxPrice }}">@endif
                    @if($sort !== 'relevance')<input type="hidden" name="sort" value="{{ $sort }}">@endif
                    @if($inStock)<input type="hidden" name="in_stock" value="1">@endif
                </form>
                
                <!-- Results Summary -->
                <div class="text-center mt-6 text-white/80">
                    @if($type === 'all')
                        {{ app()->getLocale() === 'ar' ? 'تم العثور على' : 'Found' }} 
                        <span class="font-bold text-royal-gold">{{ $productsCount }}</span> 
                        {{ app()->getLocale() === 'ar' ? 'منتج' : 'products' }}
                        {{ app()->getLocale() === 'ar' ? 'و' : 'and' }}
                        <span class="font-bold text-royal-gold">{{ $storesCount }}</span>
                        {{ app()->getLocale() === 'ar' ? 'متجر' : 'stores' }}
                        @if($query)
                            {{ app()->getLocale() === 'ar' ? 'لـ' : 'for' }} "<span class="font-semibold">{{ $query }}</span>"
                        @endif
                    @elseif($type === 'products')
                        {{ app()->getLocale() === 'ar' ? 'تم العثور على' : 'Found' }}
                        <span class="font-bold text-royal-gold">{{ $productsCount }}</span>
                        {{ app()->getLocale() === 'ar' ? 'منتج' : 'products' }}
                    @else
                        {{ app()->getLocale() === 'ar' ? 'تم العثور على' : 'Found' }}
                        <span class="font-bold text-royal-gold">{{ $storesCount }}</span>
                        {{ app()->getLocale() === 'ar' ? 'متجر' : 'stores' }}
                    @endif
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Filters Sidebar -->
                <div class="lg:w-72 flex-shrink-0">
                    <div x-data="{ filtersOpen: window.innerWidth >= 1024 }" class="sticky top-28">
                        <!-- Mobile Filter Toggle -->
                        <button @click="filtersOpen = !filtersOpen" class="lg:hidden w-full flex items-center justify-between p-4 bg-cream dark:bg-gray-800 rounded-xl mb-4">
                            <span class="font-semibold text-charcoal dark:text-white flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                </svg>
                                {{ app()->getLocale() === 'ar' ? 'الفلاتر' : 'Filters' }}
                            </span>
                            <svg class="w-5 h-5 transition-transform" :class="{ 'rotate-180': filtersOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <form action="{{ route('search') }}" method="GET" x-show="filtersOpen" x-transition class="bg-cream dark:bg-gray-800 rounded-2xl p-6 space-y-6">
                            <input type="hidden" name="q" value="{{ $query }}">
                            
                            <!-- Type Filter -->
                            <div>
                                <h3 class="font-semibold text-charcoal dark:text-white mb-3">
                                    {{ app()->getLocale() === 'ar' ? 'نوع البحث' : 'Search Type' }}
                                </h3>
                                <div class="space-y-2">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="type" value="all" {{ $type === 'all' ? 'checked' : '' }} class="text-royal-gold focus:ring-royal-gold">
                                        <span class="text-charcoal dark:text-gray-300">{{ app()->getLocale() === 'ar' ? 'الكل' : 'All' }}</span>
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="type" value="products" {{ $type === 'products' ? 'checked' : '' }} class="text-royal-gold focus:ring-royal-gold">
                                        <span class="text-charcoal dark:text-gray-300">{{ app()->getLocale() === 'ar' ? 'المنتجات' : 'Products' }}</span>
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="type" value="stores" {{ $type === 'stores' ? 'checked' : '' }} class="text-royal-gold focus:ring-royal-gold">
                                        <span class="text-charcoal dark:text-gray-300">{{ app()->getLocale() === 'ar' ? 'المتاجر' : 'Stores' }}</span>
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Category Filter -->
                            <div>
                                <h3 class="font-semibold text-charcoal dark:text-white mb-3">
                                    {{ app()->getLocale() === 'ar' ? 'الفئة' : 'Category' }}
                                </h3>
                                <select name="category" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-charcoal dark:text-white focus:ring-2 focus:ring-royal-gold focus:border-transparent">
                                    <option value="">{{ app()->getLocale() === 'ar' ? 'جميع الفئات' : 'All Categories' }}</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ $selectedCategory == $cat->id ? 'selected' : '' }}>
                                            {{ app()->getLocale() === 'ar' && $cat->name_ar ? $cat->name_ar : $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Store Filter -->
                            <div>
                                <h3 class="font-semibold text-charcoal dark:text-white mb-3">
                                    {{ app()->getLocale() === 'ar' ? 'المتجر' : 'Store' }}
                                </h3>
                                <select name="store" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-charcoal dark:text-white focus:ring-2 focus:ring-royal-gold focus:border-transparent">
                                    <option value="">{{ app()->getLocale() === 'ar' ? 'جميع المتاجر' : 'All Stores' }}</option>
                                    @foreach($allStores as $st)
                                        <option value="{{ $st->id }}" {{ $selectedStore == $st->id ? 'selected' : '' }}>
                                            {{ app()->getLocale() === 'ar' && $st->store_name_ar ? $st->store_name_ar : $st->store_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Price Range -->
                            <div>
                                <h3 class="font-semibold text-charcoal dark:text-white mb-3">
                                    {{ app()->getLocale() === 'ar' ? 'نطاق السعر' : 'Price Range' }}
                                </h3>
                                <div class="flex items-center gap-2">
                                    <input type="number" name="min_price" value="{{ $minPrice }}" placeholder="{{ app()->getLocale() === 'ar' ? 'من' : 'Min' }}" min="0" class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-charcoal dark:text-white focus:ring-2 focus:ring-royal-gold focus:border-transparent text-sm">
                                    <span class="text-slate">-</span>
                                    <input type="number" name="max_price" value="{{ $maxPrice }}" placeholder="{{ app()->getLocale() === 'ar' ? 'إلى' : 'Max' }}" min="0" class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-charcoal dark:text-white focus:ring-2 focus:ring-royal-gold focus:border-transparent text-sm">
                                </div>
                            </div>
                            
                            <!-- In Stock -->
                            <div>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="in_stock" value="1" {{ $inStock ? 'checked' : '' }} class="rounded text-royal-gold focus:ring-royal-gold">
                                    <span class="text-charcoal dark:text-gray-300">{{ app()->getLocale() === 'ar' ? 'متوفر فقط' : 'In Stock Only' }}</span>
                                </label>
                            </div>
                            
                            <!-- Sort -->
                            <div>
                                <h3 class="font-semibold text-charcoal dark:text-white mb-3">
                                    {{ app()->getLocale() === 'ar' ? 'الترتيب' : 'Sort By' }}
                                </h3>
                                <select name="sort" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-charcoal dark:text-white focus:ring-2 focus:ring-royal-gold focus:border-transparent">
                                    <option value="relevance" {{ $sort === 'relevance' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'الأكثر صلة' : 'Relevance' }}</option>
                                    <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'الأحدث' : 'Newest' }}</option>
                                    <option value="price_low" {{ $sort === 'price_low' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'السعر: من الأقل' : 'Price: Low to High' }}</option>
                                    <option value="price_high" {{ $sort === 'price_high' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'السعر: من الأعلى' : 'Price: High to Low' }}</option>
                                    <option value="popular" {{ $sort === 'popular' ? 'selected' : '' }}>{{ app()->getLocale() === 'ar' ? 'الأكثر مشاهدة' : 'Most Viewed' }}</option>
                                </select>
                            </div>
                            
                            <!-- Apply Button -->
                            <button type="submit" class="w-full bg-gradient-gold text-midnight py-3 rounded-xl font-semibold hover:scale-[1.02] transition-all">
                                {{ app()->getLocale() === 'ar' ? 'تطبيق الفلاتر' : 'Apply Filters' }}
                            </button>
                            
                            <!-- Clear Filters -->
                            @if($selectedCategory || $selectedStore || $minPrice || $maxPrice || $inStock || $sort !== 'relevance')
                            <a href="{{ route('search', ['q' => $query]) }}" class="block w-full text-center text-slate hover:text-royal-gold transition-colors text-sm">
                                {{ app()->getLocale() === 'ar' ? 'مسح الفلاتر' : 'Clear Filters' }}
                            </a>
                            @endif
                        </form>
                    </div>
                </div>

                <!-- Results Section -->
                <div class="flex-1">
                    <!-- Active Filters Tags -->
                    @if($selectedCategory || $selectedStore || $minPrice || $maxPrice || $inStock || $type !== 'all')
                    <div class="mb-6 flex flex-wrap items-center gap-2">
                        <span class="text-sm text-slate dark:text-gray-400">{{ app()->getLocale() === 'ar' ? 'الفلاتر النشطة:' : 'Active filters:' }}</span>
                        
                        @if($type !== 'all')
                        <a href="{{ route('search', array_merge(request()->except('type'), ['type' => 'all'])) }}" class="inline-flex items-center gap-1 px-3 py-1 bg-royal-gold/10 text-royal-gold rounded-full text-sm hover:bg-royal-gold/20 transition-colors">
                            {{ $type === 'products' ? (app()->getLocale() === 'ar' ? 'منتجات فقط' : 'Products only') : (app()->getLocale() === 'ar' ? 'متاجر فقط' : 'Stores only') }}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </a>
                        @endif
                        
                        @if($selectedCategory)
                        @php $catName = $categories->firstWhere('id', $selectedCategory); @endphp
                        <a href="{{ route('search', request()->except('category')) }}" class="inline-flex items-center gap-1 px-3 py-1 bg-royal-gold/10 text-royal-gold rounded-full text-sm hover:bg-royal-gold/20 transition-colors">
                            {{ app()->getLocale() === 'ar' ? 'فئة:' : 'Category:' }} {{ $catName ? (app()->getLocale() === 'ar' && $catName->name_ar ? $catName->name_ar : $catName->name) : '' }}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </a>
                        @endif
                        
                        @if($selectedStore)
                        @php $storeName = $allStores->firstWhere('id', $selectedStore); @endphp
                        <a href="{{ route('search', request()->except('store')) }}" class="inline-flex items-center gap-1 px-3 py-1 bg-royal-gold/10 text-royal-gold rounded-full text-sm hover:bg-royal-gold/20 transition-colors">
                            {{ app()->getLocale() === 'ar' ? 'متجر:' : 'Store:' }} {{ $storeName ? (app()->getLocale() === 'ar' && $storeName->store_name_ar ? $storeName->store_name_ar : $storeName->store_name) : '' }}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </a>
                        @endif
                        
                        @if($minPrice || $maxPrice)
                        <a href="{{ route('search', request()->except(['min_price', 'max_price'])) }}" class="inline-flex items-center gap-1 px-3 py-1 bg-royal-gold/10 text-royal-gold rounded-full text-sm hover:bg-royal-gold/20 transition-colors">
                            {{ app()->getLocale() === 'ar' ? 'السعر:' : 'Price:' }} {{ $minPrice ?: '0' }} - {{ $maxPrice ?: '∞' }}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </a>
                        @endif
                        
                        @if($inStock)
                        <a href="{{ route('search', request()->except('in_stock')) }}" class="inline-flex items-center gap-1 px-3 py-1 bg-royal-gold/10 text-royal-gold rounded-full text-sm hover:bg-royal-gold/20 transition-colors">
                            {{ app()->getLocale() === 'ar' ? 'متوفر فقط' : 'In Stock' }}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </a>
                        @endif
                    </div>
                    @endif

                    <!-- Stores Section (if type is all or stores) -->
                    @if(($type === 'all' || $type === 'stores') && $stores->count() > 0)
                        <div class="mb-10">
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="text-xl font-playfair font-bold text-charcoal dark:text-white flex items-center gap-2">
                                    <svg class="w-6 h-6 text-royal-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    {{ app()->getLocale() === 'ar' ? 'المتاجر' : 'Stores' }}
                                    <span class="text-sm font-normal text-slate">({{ $storesCount }})</span>
                                </h2>
                                @if($type === 'all' && $storesCount > 6)
                                <a href="{{ route('search', array_merge(request()->query(), ['type' => 'stores'])) }}" class="text-royal-gold hover:underline text-sm font-medium">
                                    {{ app()->getLocale() === 'ar' ? 'عرض الكل' : 'View All' }}
                                </a>
                                @endif
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($stores as $store)
                                <a href="{{ route('stores.show', $store->slug) }}" class="group flex items-center gap-4 p-4 bg-cream dark:bg-gray-800 rounded-xl hover:shadow-elegant transition-all">
                                    @if($store->logo)
                                    <img src="{{ $store->logo_url }}" alt="{{ $store->store_name }}" class="w-16 h-16 rounded-xl object-cover bg-white">
                                    @else
                                    <div class="w-16 h-16 rounded-xl bg-gradient-gold flex items-center justify-center">
                                        <span class="text-2xl font-playfair font-bold text-midnight">{{ substr($store->store_name, 0, 1) }}</span>
                                    </div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-semibold text-charcoal dark:text-white group-hover:text-royal-gold transition-colors truncate">
                                            {{ app()->getLocale() === 'ar' && $store->store_name_ar ? $store->store_name_ar : $store->store_name }}
                                        </h3>
                                        <p class="text-sm text-slate dark:text-gray-400">
                                            {{ $store->products_count }} {{ app()->getLocale() === 'ar' ? 'منتج' : 'products' }}
                                        </p>
                                    </div>
                                    <svg class="w-5 h-5 text-slate group-hover:text-royal-gold transition-colors {{ app()->getLocale() === 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        
                        <!-- Products Section -->
                        @if($type === 'all' || $type === 'products')
                        <div>
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="text-xl font-playfair font-bold text-charcoal dark:text-white flex items-center gap-2">
                                    <svg class="w-6 h-6 text-royal-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    {{ app()->getLocale() === 'ar' ? 'المنتجات' : 'Products' }}
                                    <span class="text-sm font-normal text-slate">({{ $productsCount }})</span>
                                </h2>
                            </div>
                            
                            @if($products->count() > 0)
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
                            @elseif($productsCount === 0)
                            <!-- No Products Found -->
                            <div class="text-center py-16">
                                <div class="w-24 h-24 mx-auto mb-6 bg-cream dark:bg-gray-800 rounded-full flex items-center justify-center">
                                    <svg class="w-12 h-12 text-slate/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-charcoal dark:text-white mb-2">
                                    {{ app()->getLocale() === 'ar' ? 'لا توجد منتجات' : 'No Products Found' }}
                                </h3>
                                <p class="text-slate dark:text-gray-400">
                                    {{ app()->getLocale() === 'ar' ? 'جرب تغيير كلمات البحث أو الفلاتر' : 'Try different keywords or filters' }}
                                </p>
                            </div>
                            @endif
                        </div>
                        @endif
                        
                        <!-- No Results at All -->
                        @if($productsCount === 0 && $storesCount === 0)
                        <div class="text-center py-16">
                            <div class="w-32 h-32 mx-auto mb-6 bg-cream dark:bg-gray-800 rounded-full flex items-center justify-center">
                                <svg class="w-16 h-16 text-slate/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-playfair font-bold text-charcoal dark:text-white mb-2">
                                {{ app()->getLocale() === 'ar' ? 'لا توجد نتائج' : 'No Results Found' }}
                            </h3>
                            @if($query)
                            <p class="text-slate dark:text-gray-400 mb-6">
                                {{ app()->getLocale() === 'ar' ? 'لم نجد نتائج لـ' : 'We couldn\'t find results for' }} "<span class="font-semibold">{{ $query }}</span>"
                            </p>
                            @else
                            <p class="text-slate dark:text-gray-400 mb-6">
                                {{ app()->getLocale() === 'ar' ? 'لا توجد منتجات تطابق الفلاتر المحددة' : 'No products match the selected filters' }}
                            </p>
                            @endif
                            <div class="text-sm text-slate dark:text-gray-400 max-w-md mx-auto">
                                <p class="mb-2">{{ app()->getLocale() === 'ar' ? 'اقتراحات:' : 'Suggestions:' }}</p>
                                <ul class="list-disc list-inside text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}">
                                    @if($query)
                                    <li>{{ app()->getLocale() === 'ar' ? 'تأكد من صحة الإملاء' : 'Check your spelling' }}</li>
                                    <li>{{ app()->getLocale() === 'ar' ? 'جرب كلمات مختلفة' : 'Try different keywords' }}</li>
                                    @endif
                                    <li>{{ app()->getLocale() === 'ar' ? 'جرب تغيير الفلاتر' : 'Try changing the filters' }}</li>
                                    <li>{{ app()->getLocale() === 'ar' ? 'امسح الفلاتر لعرض جميع المنتجات' : 'Clear filters to show all products' }}</li>
                                </ul>
                            </div>
                            
                            <!-- Clear Filters Button -->
                            @if($selectedCategory || $selectedStore || $minPrice || $maxPrice || $inStock)
                            <a href="{{ route('search', $query ? ['q' => $query] : []) }}" class="inline-flex items-center gap-2 mt-6 px-6 py-3 bg-royal-gold text-midnight rounded-xl font-semibold hover:scale-105 transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                {{ app()->getLocale() === 'ar' ? 'مسح الفلاتر' : 'Clear Filters' }}
                            </a>
                            @endif
                        </div>
                        @endif
                </div>
            </div>
        </div>
    </div>

</x-guest-luxury>
