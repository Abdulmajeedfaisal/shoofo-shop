<x-guest-luxury :title="config('app.name', 'SHOOFO') . ' - ' . __('home.tagline')">

@push('styles')
<style>
    /* ✨ Luxury Sparkle Floating Animation - Same as Store Page */
    @keyframes sparkle-float {
        0% {
            transform: translateY(0) scale(0) rotate(0deg);
            opacity: 0;
        }
        20% {
            opacity: 0.8;
            transform: translateY(-20px) scale(1) rotate(45deg);
        }
        80% {
            opacity: 0.8;
            transform: translateY(-80px) scale(1) rotate(135deg);
        }
        100% {
            transform: translateY(-100px) scale(0) rotate(180deg);
            opacity: 0;
        }
    }
    
    .animate-sparkle {
        animation: sparkle-float linear infinite;
    }
    
    /* Enhanced Ken Burns */
    @keyframes ken-burns {
        0% { transform: scale(1) translate(0, 0); }
        50% { transform: scale(1.08) translate(-1%, -1%); }
        100% { transform: scale(1) translate(0, 0); }
    }
    
    .animate-ken-burns {
        animation: ken-burns 25s ease-in-out infinite;
    }
    
    /* ✨ SMOOTH BANNER TRANSITIONS - Simple & Professional */
    .banner-slide {
        transition: opacity 0.8s ease-in-out, transform 0.8s ease-in-out;
    }
    
    .banner-entering {
        animation: bannerFadeIn 0.8s ease-out forwards;
    }
    
    .banner-leaving {
        animation: bannerFadeOut 0.6s ease-in forwards;
    }
    
    @keyframes bannerFadeIn {
        0% { 
            opacity: 0;
            transform: scale(1.05);
        }
        100% { 
            opacity: 1;
            transform: scale(1);
        }
    }
    
    @keyframes bannerFadeOut {
        0% { 
            opacity: 1;
            transform: scale(1);
        }
        100% { 
            opacity: 0;
            transform: scale(0.98);
        }
    }
    
    @keyframes contentReveal {
        0% { 
            opacity: 0;
            transform: translateY(30px);
        }
        100% { 
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .content-reveal {
        animation: contentReveal 0.6s ease-out 0.3s forwards;
        opacity: 0;
    }
    
    @keyframes pulseGlow {
        0%, 100% { box-shadow: 0 0 30px rgba(212,175,55,0.4); }
        50% { box-shadow: 0 0 60px rgba(212,175,55,0.8), 0 0 100px rgba(212,175,55,0.4); }
    }
    
    @keyframes progressBar {
        from { width: 0%; }
        to { width: 100%; }
    }
    
    .pulse-glow {
        animation: pulseGlow 2.5s ease-in-out infinite;
    }
    
    .progress-bar {
        animation: progressBar 7s linear forwards;
    }
</style>
@endpush

@push('scripts')
<script>
function bannerSlider(totalSlides) {
    return {
        currentSlide: 0,
        previousSlide: null,
        totalSlides: totalSlides,
        isTransitioning: false,
        progressKey: 0,
        init() {
            this.autoPlay();
        },
        autoPlay() {
            setInterval(() => {
                this.nextSlide();
            }, 7000);
        },
        nextSlide() {
            if (this.isTransitioning) return;
            this.isTransitioning = true;
            this.previousSlide = this.currentSlide;
            this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
            this.progressKey++;
            setTimeout(() => {
                this.isTransitioning = false;
                this.previousSlide = null;
            }, 1000);
        },
        goToSlide(index) {
            if (this.isTransitioning || index === this.currentSlide) return;
            this.isTransitioning = true;
            this.previousSlide = this.currentSlide;
            this.currentSlide = index;
            this.progressKey++;
            setTimeout(() => {
                this.isTransitioning = false;
                this.previousSlide = null;
            }, 1000);
        }
    }
}
</script>
@endpush

    <!-- Hero Section - CINEMATIC LUXURY EXPERIENCE -->
    @if($banners->count() > 0)
    <section class="relative h-[80vh] min-h-[650px] max-h-[850px] bg-midnight overflow-hidden">
        <!-- ✨ Luxury Sparkle System - Using Alpine.js like Store Page -->
        <div x-data="{}" class="absolute inset-0 overflow-hidden pointer-events-none" style="z-index: 45;">
            <!-- نجوم صغيرة -->
            <template x-for="i in 20" :key="'sparkle-sm-'+i">
                <div class="absolute animate-sparkle text-royal-gold"
                     :style="`
                        left: ${Math.random() * 100}%;
                        top: ${Math.random() * 100}%;
                        font-size: ${Math.random() * (14 - 8) + 8}px;
                        animation-duration: ${Math.random() * (4 - 2) + 2}s;
                        animation-delay: ${Math.random() * 2}s;
                        opacity: 0;
                     `">✦</div>
            </template>
            <!-- نجوم متوسطة -->
            <template x-for="i in 12" :key="'sparkle-md-'+i">
                <div class="absolute animate-sparkle text-royal-gold"
                     :style="`
                        left: ${Math.random() * 100}%;
                        top: ${Math.random() * 100}%;
                        font-size: ${Math.random() * (24 - 16) + 16}px;
                        animation-duration: ${Math.random() * (5 - 3) + 3}s;
                        animation-delay: ${Math.random() * 2}s;
                        opacity: 0;
                     `">✦</div>
            </template>
            <!-- نجوم كبيرة -->
            <template x-for="i in 6" :key="'sparkle-lg-'+i">
                <div class="absolute animate-sparkle text-royal-gold"
                     :style="`
                        left: ${Math.random() * 100}%;
                        top: ${Math.random() * 100}%;
                        font-size: ${Math.random() * (36 - 26) + 26}px;
                        animation-duration: ${Math.random() * (5 - 3) + 3}s;
                        animation-delay: ${Math.random() * 2}s;
                        opacity: 0;
                     `">✦</div>
            </template>
        </div>
        
        <div x-data="bannerSlider({{ $banners->count() }})" x-init="init()" class="relative h-full">
            @foreach($banners as $index => $banner)
            <div 
                x-show="currentSlide === {{ $index }} || previousSlide === {{ $index }}"
                x-cloak
                :class="{
                    'banner-entering': currentSlide === {{ $index }} && previousSlide !== null,
                    'banner-leaving': previousSlide === {{ $index }},
                    'z-20': currentSlide === {{ $index }},
                    'z-10': previousSlide === {{ $index }}
                }"
                class="absolute inset-0 banner-slide"
            >
                <!-- Banner Image with Ken Burns Effect -->
                <div class="absolute inset-0 animate-ken-burns">
                    <img 
                        src="{{ $banner->image }}" 
                        alt="{{ app()->getLocale() === 'ar' ? $banner->title_ar : $banner->title }}"
                        class="w-full h-full object-cover"
                    >
                </div>
                
                <!-- Multi-layered Gradient Overlay - Theme Responsive -->
                <div class="absolute inset-0 bg-gradient-to-br from-midnight/60 via-midnight/30 to-transparent dark:from-midnight/90 dark:via-midnight/60 dark:to-midnight/20 transition-all duration-700"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-midnight/85 via-midnight/20 to-transparent dark:from-midnight dark:via-midnight/50 transition-all duration-700"></div>
                <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,transparent_0%,rgba(10,22,40,0.3)_100%)] dark:bg-[radial-gradient(ellipse_at_center,transparent_0%,rgba(10,22,40,0.7)_100%)]"></div>
                
                <!-- Content Overlay -->
                <div class="absolute inset-0 flex items-center justify-center z-20">
                    <div 
                        class="max-w-7xl mx-auto text-center px-6"
                        :class="{ 'content-reveal': currentSlide === {{ $index }} }"
                    >
                        <!-- Massive Hero Title -->
                        <h1 class="font-playfair text-5xl sm:text-6xl md:text-7xl lg:text-8xl xl:text-9xl font-black text-transparent bg-clip-text bg-gradient-to-r from-white via-royal-gold-light to-white mb-8 leading-[1.05] tracking-tight"
                            style="text-shadow: 0 0 100px rgba(212,175,55,0.6);">
                            {{ app()->getLocale() === 'ar' ? $banner->title_ar : $banner->title }}
                        </h1>
                        
                        @if($banner->subtitle)
                        <p class="text-xl sm:text-2xl md:text-3xl lg:text-4xl text-white/95 mb-10 font-light tracking-wide max-w-4xl mx-auto leading-relaxed" 
                           style="text-shadow: 0 0 50px rgba(212,175,55,0.5), 0 4px 30px rgba(0,0,0,0.6);">
                            {{ app()->getLocale() === 'ar' ? $banner->subtitle_ar : $banner->subtitle }}
                        </p>
                        @endif
                        
                        @if($banner->link)
                        <div>
                            <a href="{{ $banner->link }}" class="group inline-flex items-center gap-4 bg-gradient-to-r from-royal-gold via-royal-gold-light to-royal-gold text-midnight font-bold text-xl md:text-2xl px-14 md:px-20 py-5 md:py-7 rounded-2xl shadow-2xl pulse-glow hover:scale-110 transition-all duration-500 relative overflow-hidden">
                                <span class="absolute inset-0 bg-gradient-to-r from-white/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></span>
                                <span class="relative z-10">{{ __('home.shop_now') }}</span>
                                <svg class="relative z-10 w-6 h-6 md:w-7 md:h-7 {{ app()->getLocale() === 'ar' ? 'rotate-180' : '' }} group-hover:translate-x-3 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach

            <!-- Premium Navigation Dots -->
            <div class="absolute bottom-14 left-1/2 transform -translate-x-1/2 flex gap-5 z-30">
                @foreach($banners as $index => $banner)
                <button 
                    @click="goToSlide({{ $index }})"
                    class="group relative transition-all duration-500 hover:scale-125"
                >
                    <span 
                        class="block rounded-full transition-all duration-500"
                        :class="currentSlide === {{ $index }} ? 'w-16 h-3 bg-gradient-to-r from-royal-gold to-royal-gold-light shadow-xl shadow-royal-gold/70' : 'w-10 h-3 bg-white/30 group-hover:bg-white/60'"
                    ></span>
                    <span 
                        x-show="currentSlide === {{ $index }}"
                        class="absolute -inset-2 rounded-full border-2 border-royal-gold/40"
                        style="animation: ping 1.5s cubic-bezier(0, 0, 0.2, 1) infinite;"
                    ></span>
                </button>
                @endforeach
            </div>
            
            <!-- Cinematic Progress Bar -->
            <div class="absolute bottom-0 left-0 right-0 h-1.5 bg-white/10 z-30 overflow-hidden">
                <div 
                    :key="progressKey"
                    class="h-full bg-gradient-to-r from-royal-gold via-royal-gold-light to-royal-gold progress-bar"
                ></div>
            </div>
        </div>
    </section>

    <!-- Scroll Indicator - SEPARATOR -->
    <div class="relative -mt-12 mb-8 flex justify-center z-30">
        <div class="text-slate/60 dark:text-gray-400 animate-bounce">
            <div class="flex flex-col items-center gap-2">
                <span class="text-sm uppercase tracking-widest font-semibold">{{ app()->getLocale() === 'ar' ? 'استكشف' : 'Explore' }}</span>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
            </div>
        </div>
    </div>
    @endif

    <!-- Global Categories Section - ARTISTIC GALLERY -->
    <section class="py-10 md:py-14 bg-gradient-to-b from-cream via-white to-cream dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 transition-colors duration-500">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <!-- Section Header - DRAMATIC -->
            <div class="text-center mb-10 md:mb-12" data-aos="fade-up">
                <h2 class="font-playfair text-4xl md:text-5xl lg:text-6xl font-black text-transparent bg-clip-text bg-gradient-to-r from-midnight via-royal-gold to-midnight dark:from-white dark:via-royal-gold dark:to-white mb-4 md:mb-6 tracking-tight">
                    {{ __('home.discover_categories') }}
                </h2>
                <div class="flex items-center justify-center gap-6 mb-8">
                    <div class="w-24 h-1 bg-gradient-to-r from-transparent via-royal-gold to-royal-gold rounded-full"></div>
                    <div class="w-4 h-4 bg-royal-gold rounded-full shadow-lg shadow-royal-gold/50 animate-pulse"></div>
                    <div class="w-24 h-1 bg-gradient-to-l from-transparent via-royal-gold to-royal-gold rounded-full"></div>
                </div>
                <p class="text-slate dark:text-gray-300 text-lg md:text-xl max-w-3xl mx-auto leading-relaxed font-light">
                    {{ __('home.categories_subtitle') }}
                </p>
            </div>

            <!-- Categories Grid - MAGAZINE STYLE -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-10">
                @foreach($globalCategories as $index => $category)
                <a 
                    href="{{ route('categories.show', $category->slug) }}"
                    class="group relative overflow-hidden rounded-3xl aspect-[4/5] shadow-2xl hover:shadow-[0_0_60px_rgba(212,175,55,0.4)] transition-all duration-700 hover:-translate-y-4 hover:scale-105"
                    data-aos="fade-up"
                    data-aos-delay="{{ $index * 100 }}"
                >
                    <!-- Background Image with Parallax Effect -->
                    <div class="absolute inset-0 transition-transform duration-700 group-hover:scale-110">
                        @php
                            // Dynamic background images based on category - high-quality Unsplash
                            $bgImages = [
                                'fashion' => 'https://images.unsplash.com/photo-1483985988355-763728e1935b?w=800&h=1000&fit=crop&q=90',
                                'electronic' => 'https://images.unsplash.com/photo-1468495244123-6c6c332eeece?w=800&h=1000&fit=crop&q=90',
                                'sport' => 'https://images.unsplash.com/photo-1461896836934-ffe607ba8211?w=800&h=1000&fit=crop&q=90',
                                'fitness' => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=800&h=1000&fit=crop&q=90',
                                'accessor' => 'https://images.unsplash.com/photo-1492707892479-7bc8d5a4ee93?w=800&h=1000&fit=crop&q=90',
                            ];
                            
                            $bgImage = 'https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?w=800&h=1000&fit=crop&q=90'; // default
                            foreach($bgImages as $key => $url) {
                                if(str_contains($category->slug, $key)) {
                                    $bgImage = $url;
                                    break;
                                }
                            }
                        @endphp
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
        </div>
    </section>


    <!-- Featured Stores Section - PREMIUM BOUTIQUES -->
    @if($featuredStores->count() > 0)
    <section class="py-10 md:py-14 bg-gradient-to-b from-white via-cream to-gray-100 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 transition-colors duration-500">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <!-- Section Header - DRAMATIC -->
            <div class="text-center mb-10 md:mb-12" data-aos="fade-up">
                <h2 class="font-playfair text-4xl md:text-5xl lg:text-6xl font-black text-transparent bg-clip-text bg-gradient-to-r from-midnight via-royal-gold to-midnight dark:from-white dark:via-royal-gold dark:to-white mb-4 md:mb-6 tracking-tight">
                    {{ __('home.featured_stores') }}
                </h2>
                <div class="flex items-center justify-center gap-6 mb-8">
                    <div class="w-24 h-1 bg-gradient-to-r from-transparent via-royal-gold to-royal-gold rounded-full"></div>
                    <div class="w-4 h-4 bg-royal-gold rounded-full shadow-lg shadow-royal-gold/50 animate-pulse"></div>
                    <div class="w-24 h-1 bg-gradient-to-l from-transparent via-royal-gold to-royal-gold rounded-full"></div>
                </div>
                <p class="text-slate dark:text-gray-300 text-lg md:text-xl max-w-3xl mx-auto leading-relaxed font-light">
                    {{ __('home.explore') }}
                </p>
            </div>

            <!-- Stores Grid - BOUTIQUE STYLE -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 lg:gap-12">
                @foreach($featuredStores as $index => $store)
                <a 
                    href="{{ route('stores.show', $store->slug) }}"
                    class="group relative"
                    data-aos="fade-up"
                    data-aos-delay="{{ $index * 100 }}"
                >
                    <div class="bg-white dark:bg-gray-800 rounded-3xl overflow-hidden shadow-2xl hover:shadow-[0_0_60px_rgba(212,175,55,0.3)] transition-all duration-700 hover:-translate-y-6 hover:scale-105 border border-gray-100 dark:border-gray-700 hover:border-royal-gold/50">
                        
                        <!-- Cover Image/Header - COMPACT -->
                        <div class="relative h-40 overflow-hidden">
                            @php
                                // Premium cover images based on store category or random luxury images
                                $coverImages = [
                                    'https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?w=800&h=600&fit=crop&q=90',
                                    'https://images.unsplash.com/photo-1469334031218-e382a71b716b?w=800&h=600&fit=crop&q=90',
                                    'https://images.unsplash.com/photo-1511556820780-d912e42b4980?w=800&h=600&fit=crop&q=90',
                                    'https://images.unsplash.com/photo-1445205170230-053b83016050?w=800&h=600&fit=crop&q=90',
                                ];
                                $coverImage = $coverImages[$loop->index % count($coverImages)];
                            @endphp
                            
                            <!-- Background Cover -->
                            <div class="absolute inset-0 group-hover:scale-110 transition-transform duration-700">
                                <img 
                                    src="{{ $coverImage }}" 
                                    alt="{{ app()->getLocale() === 'ar' ? $store->store_name_ar : $store->store_name }} cover"
                                    class="w-full h-full object-cover"
                                >
                            </div>
                            
                            <!-- Dramatic Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-midnight via-midnight/40 to-transparent opacity-80 group-hover:opacity-70 transition-opacity duration-700"></div>
                            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(212,175,55,0.2),transparent)]"></div>
                            
                            <!-- Premium Badge -->
                            <div class="absolute top-6 right-6 px-4 py-2 bg-royal-gold/90 backdrop-blur-sm rounded-full">
                                <span class="text-midnight font-bold text-sm uppercase tracking-wider">{{ __('home.featured') }}</span>
                            </div>
                        </div>
                        
                        <!-- Store Logo - COMPACT & CENTERED -->
                        <div class="relative -mt-14 mb-4 flex justify-center px-6">
                            @if($store->logo)
                            <div class="w-28 h-28 rounded-2xl border-4 border-white dark:border-gray-800 shadow-2xl overflow-hidden bg-white group-hover:scale-110 group-hover:border-royal-gold group-hover:shadow-royal-gold/50 transition-all duration-700 group-hover:rotate-2">
                                <img 
                                    src="{{ $store->logo }}" 
                                    alt="{{ app()->getLocale() === 'ar' ? $store->store_name_ar : $store->store_name }}"
                                    class="w-full h-full object-cover"
                                    onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-full h-full bg-gradient-to-br from-royal-gold to-royal-gold-light flex items-center justify-center\'><span class=\'text-4xl font-playfair font-bold text-midnight\'>{{ substr($store->store_name, 0, 1) }}</span></div>';"
                                >
                            </div>
                            @else
                            <div class="w-28 h-28 rounded-2xl border-4 border-white dark:border-gray-800 shadow-2xl bg-gradient-to-br from-royal-gold to-royal-gold-light flex items-center justify-center group-hover:scale-110 group-hover:rotate-2 transition-all duration-700">
                                <span class="text-4xl font-playfair font-bold text-midnight">
                                    {{ substr($store->store_name, 0, 1) }}
                                </span>
                            </div>
                            @endif
                        </div>

                        <!-- Store Info - COMPACT CONTENT -->
                        <div class="px-6 pb-6 text-center">
                            <!-- Store Name - MEDIUM -->
                            <h3 class="font-playfair text-2xl md:text-3xl font-bold text-charcoal dark:text-white mb-3 group-hover:text-royal-gold transition-colors duration-500 leading-tight">
                                {{ app()->getLocale() === 'ar' ? $store->store_name_ar : $store->store_name }}
                            </h3>

                            <!-- Store Description -->
                            @if($store->description)
                            <p class="text-slate dark:text-gray-400 text-sm md:text-base line-clamp-2 mb-6 leading-relaxed">
                                {{ app()->getLocale() === 'ar' ? $store->description_ar : $store->description }}
                            </p>
                            @else
                            <p class="text-slate dark:text-gray-400 text-sm md:text-base mb-6 leading-relaxed opacity-60">
                                {{ app()->getLocale() === 'ar' ? 'اكتشف مجموعتنا الحصرية' : 'Discover our exclusive collection' }}
                            </p>
                            @endif

                            <!-- CTA Button - PREMIUM -->
                            <div class="relative inline-block">
                                <span class="inline-flex items-center gap-3 bg-gradient-to-r from-royal-gold via-royal-gold-light to-royal-gold text-midnight font-bold px-8 py-3 rounded-xl shadow-xl group-hover:shadow-2xl group-hover:shadow-royal-gold/50 group-hover:scale-110 transition-all duration-500 text-base relative overflow-hidden">
                                    <span class="absolute inset-0 bg-gradient-to-r from-royal-gold-light to-royal-gold opacity-0 group-hover:opacity-100 transition-opacity duration-500"></span>
                                    <span class="relative">{{ __('home.view_store') }}</span>
                                    <svg class="relative w-5 h-5 {{ app()->getLocale() === 'ar' ? 'rotate-180' : '' }} group-hover:translate-x-2 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            <!-- Browse All Stores Link - PREMIUM -->
            <div class="text-center mt-16" data-aos="fade-up">
                <a href="{{ route('stores.index') }}" class="group inline-flex items-center gap-4 px-12 py-5 border-2 border-royal-gold/50 text-charcoal dark:text-white font-bold text-lg rounded-2xl hover:bg-royal-gold hover:text-midnight hover:border-royal-gold hover:shadow-xl hover:shadow-royal-gold/30 transition-all duration-500 hover:scale-105">
                    <span>{{ __('home.browse_all_stores') }}</span>
                    <svg class="w-6 h-6 {{ app()->getLocale() === 'ar' ? 'rotate-180' : '' }} group-hover:translate-x-2 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>
    @endif

</x-guest-luxury>

