<x-guest-luxury :title="__('navigation.stores') . ' - ' . config('app.name', 'SHOOFO')">

    <!-- Page Header - DRAMATIC LUXURY -->
    <section class="bg-gradient-to-br from-midnight via-charcoal to-midnight text-white py-10 md:py-14 transition-smooth relative overflow-hidden">
        <!-- Background Glow Effect -->
        <div class="absolute inset-0 flex items-center justify-center opacity-20">
            <div class="w-96 h-96 bg-royal-gold/30 rounded-full blur-3xl"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-6 text-center relative z-10">
            <!-- Dramatic Title -->
            <h1 class="font-playfair text-4xl md:text-5xl lg:text-6xl font-black text-transparent bg-clip-text bg-gradient-to-r from-white via-royal-gold to-white mb-6 tracking-tight">
                {{ __('navigation.stores') }}
            </h1>
            
            <!-- Decorative Elements -->
            <div class="flex items-center justify-center gap-6 mb-8">
                <div class="w-24 h-1 bg-gradient-to-r from-transparent via-royal-gold to-royal-gold rounded-full"></div>
                <div class="w-4 h-4 bg-royal-gold rounded-full shadow-lg shadow-royal-gold/50 animate-pulse"></div>
                <div class="w-24 h-1 bg-gradient-to-l from-transparent via-royal-gold to-royal-gold rounded-full"></div>
            </div>
            
            <p class="text-lg md:text-xl text-white/90 max-w-3xl mx-auto leading-relaxed font-light">
                {{ __('home.stores_subtitle') }}
            </p>
        </div>
    </section>

    <!-- Stores Gallery - PREMIUM BOUTIQUES -->
    <section class="py-8 md:py-12 bg-gradient-to-b from-white via-gray-50 to-white dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 transition-smooth">
        <div class="max-w-7xl mx-auto px-6">
            @if($stores->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-10">
                @foreach($stores as $index => $store)
                @php
                    // Premium cover images for stores
                    $coverImages = [
                        'zara' => 'https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?w=1200&h=800&fit=crop&q=90',
                        'nike' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=1200&h=800&fit=crop&q=90',
                        'apple' => 'https://images.unsplash.com/photo-1468495244123-6c6c332eeece?w=1200&h=800&fit=crop&q=90',
                        'h&m' => 'https://images.unsplash.com/photo-1489987707025-afc232f7ea0f?w=1200&h=800&fit=crop&q=90',
                        'adidas' => 'https://images.unsplash.com/photo-1556906781-9a412961c28c?w=1200&h=800&fit=crop&q=90',
                    ];
                    
                    $coverImage = 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=1200&h=800&fit=crop&q=90'; // default luxury mall
                    $storeName = app()->getLocale() === 'ar' && $store->store_name_ar ? $store->store_name_ar : $store->store_name;
                    
                    foreach($coverImages as $key => $url) {
                        if(str_contains(strtolower($store->slug), $key)) {
                            $coverImage = $url;
                            break;
                        }
                    }
                @endphp
                
                <a 
                    href="{{ route('stores.show', $store->slug) }}"
                    class="group relative overflow-hidden rounded-3xl aspect-[16/9] shadow-2xl hover:shadow-[0_0_80px_rgba(212,175,55,0.5)] transition-all duration-700 hover:-translate-y-4 hover:scale-[1.02]"
                    data-aos="fade-up"
                    data-aos-delay="{{ $index * 100 }}"
                >
                    <!-- Cover Image with Parallax Effect -->
                    <div class="absolute inset-0 transition-transform duration-700 group-hover:scale-110">
                        <img 
                            src="{{ $coverImage }}" 
                            alt="{{ $storeName }}"
                            class="w-full h-full object-cover"
                        >
                    </div>
                    
                    <!-- Multi-layered Dramatic Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-midnight via-midnight/70 to-midnight/30 opacity-90 group-hover:opacity-95 transition-opacity duration-700"></div>
                    <div class="absolute inset-0 bg-gradient-to-br from-royal-gold/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                    
                    <!-- Animated Border Glow -->
                    <div class="absolute inset-0 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-700" style="box-shadow: inset 0 0 0 2px rgba(212,175,55,0.6);"></div>
                    
                    <!-- Content -->
                    <div class="absolute inset-x-0 bottom-0 p-8">
                        <!-- Logo Badge -->
                        <div class="mb-6 transform transition-transform duration-700 group-hover:scale-110">
                            @if($store->logo)
                            <div class="w-24 h-24 rounded-2xl overflow-hidden border-4 border-white/20 shadow-2xl backdrop-blur-sm bg-white/10 flex items-center justify-center">
                                <img 
                                    src="{{ $store->logo }}" 
                                    alt="{{ $storeName }}"
                                    class="w-20 h-20 object-contain"
                                >
                            </div>
                            @else
                            <div class="w-24 h-24 rounded-2xl bg-gradient-gold flex items-center justify-center shadow-2xl border-4 border-white/20">
                                <span class="text-4xl font-playfair font-bold text-midnight">
                                    {{ substr($storeName, 0, 1) }}
                                </span>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Store Name - LARGE -->
                        <h3 class="font-playfair text-3xl md:text-4xl font-bold text-white mb-3 leading-tight transition-all duration-700 group-hover:text-royal-gold" style="text-shadow: 0 2px 8px rgba(0,0,0,0.8);">
                            {{ $storeName }}
                        </h3>
                        
                        <!-- Description -->
                        @if($store->description)
                        <p class="text-white text-base md:text-lg leading-relaxed mb-4 opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-700 delay-100 line-clamp-2" style="text-shadow: 0 1px 4px rgba(0,0,0,0.8);">
                            {{ app()->getLocale() === 'ar' && $store->description_ar ? $store->description_ar : $store->description }}
                        </p>
                        @endif
                        
                        <!-- Explore Button -->
                        <div class="flex items-center gap-2 text-royal-gold font-bold text-lg opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-700 delay-150" style="text-shadow: 0 1px 4px rgba(0,0,0,0.6);">
                            <span>{{ app()->getLocale() === 'ar' ? 'استكشف المتجر' : 'Explore Store' }}</span>
                            <svg class="w-5 h-5 {{ app()->getLocale() === 'ar' ? 'rotate-180' : '' }} transform group-hover:translate-x-2 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </div>
                    </div>
                    
                    <!-- Hover Particle Effect -->
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-30 transition-opacity duration-700 pointer-events-none" style="background-image: radial-gradient(2px 2px at 20% 50%, white, transparent), radial-gradient(2px 2px at 60% 60%, rgba(212,175,55,0.8), transparent), radial-gradient(1px 1px at 80% 30%, white, transparent);background-size: 300px 300px, 200px 200px, 250px 250px;"></div>
                </a>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $stores->links() }}
            </div>
            @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <svg class="w-24 h-24 mx-auto text-slate/30 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <h3 class="font-playfair text-2xl font-semibold text-charcoal mb-2">{{ __('home.no_stores') }}</h3>
                <p class="text-slate mb-6">{{ __('home.no_stores_message') }}</p>
            </div>
            @endif
        </div>
    </section>

</x-guest-luxury>

