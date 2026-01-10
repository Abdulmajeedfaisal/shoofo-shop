<x-guest-luxury :title="__('navigation.categories') . ' - ' . config('app.name', 'SHOOFO')">

    <!-- Page Header - COMPACT LUXURY -->
    <section class="bg-gradient-to-br from-midnight via-charcoal to-midnight text-white py-6 md:py-8 transition-smooth relative overflow-hidden">
        <!-- Background Glow Effect -->
        <div class="absolute inset-0 flex items-center justify-center opacity-20">
            <div class="w-96 h-96 bg-royal-gold/30 rounded-full blur-3xl"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-6 text-center relative z-10">
            <!-- Title - COMPACT -->
            <h1 class="font-playfair text-3xl md:text-4xl lg:text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-white via-royal-gold to-white mb-4 tracking-tight">
                {{ __('home.discover_categories') }}
            </h1>
            
            <!-- Decorative Elements -->
            <div class="flex items-center justify-center gap-4 mb-4">
                <div class="w-24 h-1 bg-gradient-to-r from-transparent via-royal-gold to-royal-gold rounded-full"></div>
                <div class="w-4 h-4 bg-royal-gold rounded-full shadow-lg shadow-royal-gold/50 animate-pulse"></div>
                <div class="w-24 h-1 bg-gradient-to-l from-transparent via-royal-gold to-royal-gold rounded-full"></div>
            </div>
            
            <p class="text-base md:text-lg text-white/90 max-w-3xl mx-auto leading-relaxed font-light">
                {{ __('home.explore') }}
            </p>
        </div>
    </section>

    <!-- Categories Grid - ARTISTIC MAGAZINE GALLERY -->
    <section class="py-8 md:py-10 bg-gradient-to-b from-white via-gray-50 to-white dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 transition-smooth">
        <div class="max-w-7xl mx-auto px-6">
            @if($globalCategories->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-10">
                @foreach($globalCategories as $index => $category)
                @php
                    // Use category image if available, otherwise fallback to default
                    $bgImage = $category->image_url ?? 'https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?w=800&h=1000&fit=crop&q=90';
                @endphp
                
                <a 
                    href="{{ route('categories.show', $category->slug) }}"
                    class="group relative overflow-hidden rounded-3xl aspect-[4/5] shadow-2xl hover:shadow-[0_0_60px_rgba(212,175,55,0.4)] transition-all duration-700 hover:-translate-y-4 hover:scale-105"
                    data-aos="fade-up"
                    data-aos-delay="{{ $index * 100 }}"
                >
                    <!-- Background Image with Parallax Effect -->
                    <div class="absolute inset-0 transition-transform duration-700 group-hover:scale-110">
                        <img 
                            src="{{ $bgImage }}" 
                            alt="{{ app()->getLocale() === 'ar' ? $category->name_ar : $category->name }}"
                            class="w-full h-full object-cover"
                        >
                    </div>
                    
                    <!-- Multi-layered Dramatic Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-midnight via-midnight/70 to-midnight/30 opacity-90 group-hover:opacity-95 transition-opacity duration-700"></div>
                    <div class="absolute inset-0 bg-gradient-to-br from-royal-gold/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                    
                    <!-- Animated Border Glow -->
                    <div class="absolute inset-0 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-700" style="box-shadow: inset 0 0 0 2px rgba(212,175,55,0.5);"></div>
                    
                    <!-- Content - Bottom Positioned -->
                    <div class="absolute inset-x-0 bottom-0 p-8 transform transition-transform duration-700 group-hover:translate-y-0">
                        <!-- Gold Accent Line -->
                        <div class="w-16 h-1 bg-gradient-to-r from-royal-gold to-royal-gold-light rounded-full mb-4 transform origin-left transition-transform duration-700 group-hover:scale-x-150"></div>
                        
                        <!-- Category Name - LARGE -->
                        <h3 class="font-playfair text-3xl md:text-4xl font-bold text-white mb-3 leading-tight transform transition-all duration-700 group-hover:text-royal-gold" style="text-shadow: 0 2px 8px rgba(0,0,0,0.8);">
                            {{ app()->getLocale() === 'ar' ? $category->name_ar : $category->name }}
                        </h3>
                        
                        <!-- Description -->
                        @if($category->description)
                        <p class="text-white text-base md:text-lg leading-relaxed mb-4 opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-700 delay-100" style="text-shadow: 0 1px 4px rgba(0,0,0,0.8);">
                            {{ app()->getLocale() === 'ar' ? $category->description_ar : $category->description }}
                        </p>
                        @endif
                        
                        <!-- Store Count Badge -->
                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-black/40 backdrop-blur-sm rounded-full mb-4 opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-700 delay-150">
                            <svg class="w-4 h-4 text-royal-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <span class="text-white font-medium text-sm">{{ $category->merchant_categories_count }} {{ __('navigation.stores') }}</span>
                        </div>
                        
                        <!-- Explore Button -->
                        <div class="flex items-center gap-2 text-royal-gold font-bold text-lg opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-700 delay-200" style="text-shadow: 0 1px 4px rgba(0,0,0,0.6);">
                            <span>{{ app()->getLocale() === 'ar' ? 'استكشف' : 'Explore' }}</span>
                            <svg class="w-5 h-5 {{ app()->getLocale() === 'ar' ? 'rotate-180' : '' }} transform group-hover:translate-x-2 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Hover Particle Effect -->
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-30 transition-opacity duration-700 pointer-events-none" style="background-image: radial-gradient(2px 2px at 20% 50%, white, transparent), radial-gradient(2px 2px at 60% 60%, rgba(212,175,55,0.8), transparent), radial-gradient(1px 1px at 80% 30%, white, transparent);background-size: 300px 300px, 200px 200px, 250px 250px;"></div>
                </a>
                @endforeach
            </div>
            @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <svg class="w-24 h-24 mx-auto text-slate/30 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
                <h3 class="font-playfair text-2xl font-semibold text-charcoal mb-2">No Categories Yet</h3>
                <p class="text-slate mb-6">Check back soon for luxury categories</p>
                <x-button variant="primary" href="{{ route('home') }}">
                    {{ __('navigation.home') }}
                </x-button>
            </div>
            @endif
        </div>
    </section>

</x-guest-luxury>

