<x-guest-luxury :title="$store->store_name . ' - ' . config('app.name', 'SHOOFO')">

    @php
        // Don't show cinematic entrance if coming back from product page
        $showStoreEntrance = true;
        $referer = request()->headers->get('referer');
        if ($referer) {
            $refererPath = parse_url($referer, PHP_URL_PATH);
            // If coming from a product page of this store, don't show entrance
            if ($refererPath && str_contains($refererPath, '/stores/' . $store->slug . '/products/')) {
                $showStoreEntrance = false;
            }
        }
    @endphp

    <!-- ✨ CINEMATIC LUXURY BOUTIQUE ENTRANCE ✨ -->
    <style>
        /* Curtain Open Animation */
        @keyframes curtainOpen {
            0% { clip-path: inset(0 0 0 0); }
            100% { clip-path: inset(0 100% 0 0); }
        }
        @keyframes curtainOpenRight {
            0% { clip-path: inset(0 0 0 0); }
            100% { clip-path: inset(0 0 0 100%); }
        }
        
        /* Particle Swirl */
        @keyframes particleSwirl {
            0% { 
                transform: translate(var(--x-start), var(--y-start)) scale(0) rotate(0deg); 
                opacity: 0; 
            }
            20% { opacity: 1; }
            80% { opacity: 1; }
            100% { 
                transform: translate(var(--x-target), var(--y-target)) scale(1) rotate(720deg);
                opacity: 0;
            }
        }
        
        /* Logo Crystallization */
        @keyframes logoCarystallize {
            0% { 
                opacity: 0; 
                transform: scale(0.3) rotateY(180deg) translateZ(0);
                filter: blur(20px) brightness(3);
            }
            60% {
                transform: scale(1.15) rotateY(10deg) translateZ(0);
            }
            100% { 
                opacity: 1; 
                transform: scale(1) rotateY(0deg) translateZ(0);
                filter: blur(0) brightness(1);
            }
        }
        
        /* Brand Reveal */
        @keyframes brandReveal {
            0% { 
                opacity: 0; 
                transform: translateY(20px) scale(0.9);
                filter: blur(10px);
            }
            100% { 
                opacity: 1; 
                transform: translateY(0) scale(1);
                filter: blur(0);
            }
        }
        
        /* Golden Shimmer */
        @keyframes goldenShimmer {
            0%, 100% { background-position: -200% center; }
            50% { background-position: 200% center; }
        }
        
        /* Diamond Shine */
        @keyframes diamondShine {
            0%, 100% { transform: translateX(-150%) rotate(45deg); }
            50% { transform: translateX(250%) rotate(45deg); }
        }
        
        /* Ornament Fade */
        @keyframes ornamentFade {
            0% { 
                opacity: 0; 
                transform: rotate(-180deg) scale(0);
            }
            100% { 
                opacity: 1; 
                transform: rotate(0deg) scale(1);
            }
        }
        
        .entrance-curtain-left {
            animation: curtainOpen 800ms cubic-bezier(0.4, 0.0, 0.2, 1) forwards;
        }
        .entrance-curtain-right {
            animation: curtainOpenRight 800ms cubic-bezier(0.4, 0.0, 0.2, 1) forwards;
        }
        .entrance-particle {
            animation: particleSwirl 1.5s cubic-bezier(0.4, 0.0, 0.2, 1) forwards;
            will-change: transform, opacity;
        }
        .entrance-logo {
            animation: logoCarystallize 1.4s cubic-bezier(0.34, 1.56, 0.64, 1) 600ms forwards;
            will-change: transform, opacity, filter;
        }
        .entrance-brand {
            animation: brandReveal 800ms cubic-bezier(0.4, 0.0, 0.2, 1) 1200ms forwards;
        }
        .entrance-shimmer {
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.8), transparent);
            background-size: 200% 100%;
            animation: goldenShimmer 2s linear infinite;
        }
        .entrance-shine {
            animation: diamondShine 3s ease-in-out infinite;
        }
        .entrance-ornament {
            animation: ornamentFade 600ms cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }
        
        /* ✨ Luxury Sparkle Floating Animation */
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
    </style>
    
    <div x-data="{ 
        entering: {{ $showStoreEntrance ? 'true' : 'false' }}, 
        storeLogo: '{{ $store->logo_url ?? '' }}',
        activeCategory: 'all',
        particles: Array.from({length: 40}, (_, i) => ({
            id: i,
            xStart: (Math.random() - 0.5) * 800,
            yStart: (Math.random() - 0.5) * 600,
            xTarget: (Math.random() - 0.5) * 100,
            yTarget: (Math.random() - 0.5) * 100,
            delay: Math.random() * 1000,
            size: 3 + Math.random() * 8
        }))
    }" 
         x-init="if(entering) setTimeout(() => entering = false, 3000)"
         @click="if(entering) entering = false">
        
        <!-- 🎭 LUXURY ENTRANCE OVERLAY -->
        <div x-show="entering" 
             x-transition:leave="transition-all duration-1000 ease-out"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="fixed inset-0 z-50 overflow-hidden cursor-pointer"
             style="background: linear-gradient(135deg, #0A1628 0%, #1a1f35 50%, #0A1628 100%);">
            
            <!-- Golden Curtains -->
            <div class="absolute inset-0 z-10 pointer-events-none">
                <!-- Left Curtain -->
                <div class="entrance-curtain-left absolute inset-y-0 left-0 w-1/2"
                     style="background: linear-gradient(120deg, #B8860B 0%, #FFD700 30%, #DAA520 60%, #B8860B 100%);
                            box-shadow: inset -20px 0 40px rgba(0,0,0,0.3), 0 0 100px rgba(255,215,0,0.3);">
                    <div class="absolute inset-0 opacity-30" style="background: repeating-linear-gradient(90deg, transparent, transparent 2px, rgba(0,0,0,0.1) 2px, rgba(0,0,0,0.1) 4px);"></div>
                </div>
                <!-- Right Curtain -->
                <div class="entrance-curtain-right absolute inset-y-0 right-0 w-1/2"
                     style="background: linear-gradient(240deg, #B8860B 0%, #FFD700 30%, #DAA520 60%, #B8860B 100%);
                            box-shadow: inset 20px 0 40px rgba(0,0,0,0.3), 0 0 100px rgba(255,215,0,0.3);">
                    <div class="absolute inset-0 opacity-30" style="background: repeating-linear-gradient(90deg, transparent, transparent 2px, rgba(0,0,0,0.1) 2px, rgba(0,0,0,0.1) 4px);"></div>
                </div>
            </div>
            
            <!-- ✨ Luxury Sparkle System -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none z-0">
                <template x-for="i in 50" :key="'sparkle-'+i">
                    <div class="absolute animate-sparkle text-royal-gold"
                         :style="`
                            left: ${Math.random() * 100}%;
                            top: ${Math.random() * 100}%;
                            font-size: ${Math.random() * (24 - 8) + 8}px;
                            animation-duration: ${Math.random() * (4 - 2) + 2}s;
                            animation-delay: ${Math.random() * 0.5}s;
                            opacity: 0;
                            filter: blur(${Math.random() > 0.8 ? '1px' : '0px'});
                         `">✦</div>
                </template>
            </div>
            
            <!-- Radial Glow Background -->
            <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                <div class="w-[600px] h-[600px] rounded-full opacity-20 blur-3xl animate-pulse"
                     style="background: radial-gradient(circle, #FFD700 0%, #DAA520 40%, transparent 70%);"></div>
            </div>
            
            <!-- Particle System -->
            <div class="absolute inset-0 flex items-center justify-center pointer-events-none z-30" style="perspective: 1000px;">
                <template x-for="particle in particles" :key="particle.id">
                    <div class="entrance-particle absolute rounded-full"
                         :style="`
                            width: ${particle.size}px; 
                            height: ${particle.size}px;
                            background: radial-gradient(circle, #FFD700, #DAA520);
                            box-shadow: 0 0 ${particle.size * 2}px rgba(255, 215, 0, 0.8);
                            --x-start: ${particle.xStart}px;
                            --y-start: ${particle.yStart}px;
                            --x-target: ${particle.xTarget}px;
                            --y-target: ${particle.yTarget}px;
                            animation-delay: ${particle.delay}ms;
                         `">
                    </div>
                </template>
            </div>
            
            <!-- Logo Crystallization Container -->
            <div class="absolute inset-0 flex items-center justify-center z-20" style="perspective: 1200px;">
                <div class="text-center">
                    <!-- Logo with Multi-Layer Effects -->
                    <div class="relative inline-block entrance-logo opacity-0">
                        <!-- Radial Glow -->
                        <div class="absolute inset-0 -inset-6">
                            <div class="w-full h-full rounded-full"
                                 style="background: radial-gradient(circle, rgba(255,215,0,0.35) 0%, rgba(255,215,0,0.15) 50%, transparent 75%);
                                        filter: blur(20px);
                                        animation: pulse 2s ease-in-out infinite;"></div>
                        </div>
                        
                        <!-- Diamond Shine Overlay -->
                        <div class="absolute -inset-4 overflow-hidden rounded-full opacity-50">
                            <div class="entrance-shine absolute w-24 h-[200%] bg-gradient-to-r from-transparent via-white to-transparent"
                                 style="transform: translateX(-150%) rotate(45deg);"></div>
                        </div>
                        
                        <!-- Actual Logo with Enhanced Visibility -->
                        <div class="relative w-32 h-32 md:w-40 md:h-40 lg:w-48 lg:h-48 rounded-full overflow-hidden"
                             style="background: transparent;
                                    box-shadow: 0 0 15px rgba(255, 215, 0, 0.2);">
                            @if($store->logo)
                                <div class="absolute inset-0 flex items-center justify-center p-1.5 bg-white rounded-full">
                                    <img src="{{ $store->logo_url }}" 
                                         alt="{{ $store->store_name }}"
                                         class="w-full h-full object-contain rounded-full relative z-10"
                                         style="filter: drop-shadow(0 0 8px rgba(255,215,0,0.4));">
                                </div>
                                <!-- Golden Ring Border -->
                                <div class="absolute inset-0 rounded-full border border-royal-gold/40 pointer-events-none"></div>
                            @else
                                <div class="absolute inset-0 rounded-full bg-gradient-to-br from-royal-gold via-royal-gold-light to-royal-gold flex items-center justify-center shadow-2xl border-4 border-white/30"
                                     style="filter: drop-shadow(0 0 30px rgba(255,215,0,0.6));">
                                    <span class="text-5xl md:text-6xl lg:text-7xl font-playfair font-bold text-midnight">
                                        {{ substr($store->store_name, 0, 1) }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Reflection Effect -->
                        <div class="absolute -bottom-8 left-1/2 -translate-x-1/2 w-3/4 h-8 opacity-30"
                             style="background: radial-gradient(ellipse, rgba(255,215,0,0.4) 0%, transparent 70%); 
                                    filter: blur(8px);"></div>
                    </div>
                    
                    <!-- Brand Name Reveal -->
                    <div class="entrance-brand mt-12 opacity-0">
                        <h2 class="text-3xl md:text-4xl lg:text-5xl font-playfair font-black text-white tracking-wide relative inline-block">
                            <span class="relative z-10">
                                {{ app()->getLocale() === 'ar' && $store->store_name_ar ? $store->store_name_ar : $store->store_name }}
                            </span>
                            <!-- Shimmer Overlay -->
                            <div class="entrance-shimmer absolute inset-0 opacity-50"></div>
                        </h2>
                        
                        <!-- Golden Underline -->
                        <div class="mt-3 h-1 w-32 mx-auto rounded-full bg-gradient-to-r from-transparent via-royal-gold to-transparent shadow-lg shadow-royal-gold/50"></div>
                    </div>
                    
                    <!-- Welcome Ceremony -->
                    <div class="entrance-brand mt-8 opacity-0">
                        <div class="flex items-center justify-center gap-4">
                            <span class="entrance-ornament text-royal-gold text-2xl opacity-0" style="animation-delay: 1400ms;">✦</span>
                            <p class="text-royal-gold text-lg md:text-xl font-medium tracking-widest">
                                {{ app()->getLocale() === 'ar' ? 'مرحباً بك في متجرنا الفاخر' : 'Welcome to our Boutique' }}
                            </p>
                            <span class="entrance-ornament text-royal-gold text-2xl opacity-0" style="animation-delay: 1500ms;">✦</span>
                        </div>
                    </div>
                    
                    <!-- Skip Hint -->
                    <p class="absolute bottom-12 left-1/2 -translate-x-1/2 text-white/40 text-sm font-light animate-pulse">
                        {{ app()->getLocale() === 'ar' ? 'انقر في أي مكان للدخول' : 'Click anywhere to enter' }}
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Store Page Content -->
        <div x-show="!entering" 
             x-transition:enter="transition duration-700 ease-out"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100">
            
            <!-- Breadcrumb -->
            <div class="bg-gradient-to-r from-cream to-gray-50 dark:from-gray-900 dark:to-gray-800 border-b-2 border-royal-gold/10 transition-smooth">
                <div class="max-w-7xl mx-auto px-6 py-4">
                    <nav class="flex items-center gap-3 text-sm">
                        <a href="{{ route('home') }}" class="text-slate hover:text-royal-gold transition-elegant flex items-center gap-1 font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            {{ app()->getLocale() === 'ar' ? 'الرئيسية' : 'Home' }}
                        </a>
                        <svg class="w-4 h-4 text-royal-gold {{ app()->getLocale() === 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <a href="{{ route('stores.index') }}" class="text-slate hover:text-royal-gold transition-elegant font-medium">
                            {{ app()->getLocale() === 'ar' ? 'المتاجر' : 'Stores' }}
                        </a>
                        <svg class="w-4 h-4 text-royal-gold {{ app()->getLocale() === 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <span class="text-charcoal dark:text-royal-gold-light font-semibold">
                            {{ app()->getLocale() === 'ar' && $store->store_name_ar ? $store->store_name_ar : $store->store_name }}
                        </span>
                    </nav>
                </div>
            </div>

            <!-- COMPACT HERO SECTION -->
            <section class="relative h-[35vh] min-h-[350px] max-h-[450px] overflow-hidden">
                @php
                    // Premium cover images for stores
                    $storeCoverImages = [
                        'zara' => 'https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?w=1920&h=1080&fit=crop&q=90',
                        'nike' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=1920&h=1080&fit=crop&q=90',
                        'apple' => 'https://images.unsplash.com/photo-1468495244123-6c6c332eeece?w=1920&h=1080&fit=crop&q=90',
                        'h&m' => 'https://images.unsplash.com/photo-1489987707025-afc232f7ea0f?w=1920&h=1080&fit=crop&q=90',
                        'adidas' => 'https://images.unsplash.com/photo-1556906781-9a412961c28c?w=1920&h=1080&fit=crop&q=90',
                    ];
                    $storeHeroCover = 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=1920&h=1080&fit=crop&q=90'; // default luxury
                    foreach($storeCoverImages as $key => $url) {
                        if(str_contains(strtolower($store->slug), $key)) {
                            $storeHeroCover = $url;
                            break;
                        }
                    }
                @endphp
                
                <!-- Cover Image/Video -->
                <div class="absolute inset-0">
                    <img 
                        src="{{ $storeHeroCover }}" 
                        alt="{{ $store->store_name }}"
                        class="w-full h-full object-cover"
                    >
                </div>
                
                <!-- Gradient Overlay -->
                <div class="absolute inset-0 bg-gradient-to-b from-transparent via-midnight/40 to-midnight/95"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-midnight/60 to-transparent"></div>
                
                <!-- ✨ Luxury Sparkle System for Banner -->
                <div x-data="{}" class="absolute inset-0 overflow-hidden pointer-events-none" style="z-index: 15;">
                    <!-- نجوم صغيرة -->
                    <template x-for="i in 15" :key="'banner-sparkle-sm-'+i">
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
                    <template x-for="i in 8" :key="'banner-sparkle-md-'+i">
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
                    <template x-for="i in 4" :key="'banner-sparkle-lg-'+i">
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
                
                <!-- Store Branding - Full Width Layout -->
                <div class="absolute bottom-0 left-0 right-0 p-6 md:p-10 lg:p-12">
                    <div class="max-w-7xl mx-auto">
                        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
                            
                            <!-- Left Side: Logo + Store Info -->
                            <div class="flex flex-col md:flex-row items-start md:items-end gap-4 md:gap-6">
                                <!-- Logo Badge -->
                                <div class="flex-shrink-0">
                                    @if($store->logo)
                                    <div class="w-16 h-16 md:w-20 md:h-20 lg:w-24 lg:h-24 rounded-2xl overflow-hidden shadow-2xl border-2 border-white/20 backdrop-blur-sm bg-white/10">
                                        <img 
                                            src="{{ $store->logo_url }}" 
                                            alt="{{ $store->store_name }}"
                                            class="w-full h-full object-contain p-2"
                                        >
                                    </div>
                                    @else
                                    <div class="w-16 h-16 md:w-20 md:h-20 lg:w-24 lg:h-24 rounded-2xl bg-gradient-gold flex items-center justify-center shadow-2xl border-2 border-white/20">
                                        <span class="text-2xl md:text-3xl font-playfair font-bold text-midnight">
                                            {{ substr($store->store_name, 0, 1) }}
                                        </span>
                                    </div>
                                    @endif
                                </div>
                                
                                <!-- Store Info -->
                                <div class="text-white">
                                    <h1 class="text-xl md:text-2xl lg:text-3xl xl:text-4xl font-playfair font-black mb-1 md:mb-2 leading-tight">
                                        {{ app()->getLocale() === 'ar' && $store->store_name_ar ? $store->store_name_ar : $store->store_name }}
                                    </h1>
                                    
                                    @if($store->description || $store->description_ar)
                                    <p class="text-xs md:text-sm opacity-90 max-w-xl mb-2 md:mb-3 font-light leading-relaxed line-clamp-2">
                                        {{ app()->getLocale() === 'ar' && $store->description_ar ? $store->description_ar : $store->description }}
                                    </p>
                                    @endif
                                    
                                    <!-- Stats + Phone in one row -->
                                    <div class="flex flex-wrap items-center gap-4 md:gap-6">
                                        <div class="flex items-center gap-1">
                                            <span class="text-2xl md:text-3xl font-bold text-royal-gold-light">{{ $products->count() }}</span>
                                            <span class="text-sm opacity-90">{{ app()->getLocale() === 'ar' ? 'منتج' : 'Products' }}</span>
                                        </div>
                                        <div class="w-px h-8 bg-white/30"></div>
                                        <div class="flex items-center gap-1">
                                            <span class="text-2xl md:text-3xl font-bold text-royal-gold-light">{{ $categories->count() }}</span>
                                            <span class="text-sm opacity-90">{{ app()->getLocale() === 'ar' ? 'فئة' : 'Categories' }}</span>
                                        </div>
                                        
                                        @if($store->phone)
                                        <div class="w-px h-8 bg-white/30"></div>
                                        <a href="tel:{{ $store->phone }}" class="flex items-center gap-2 text-white/90 hover:text-royal-gold-light transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                            </svg>
                                            <span class="text-sm font-medium" dir="ltr">{{ $store->phone }}</span>
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Right Side: Contact Card (Desktop) -->
                            @if($store->phone || $store->address)
                            <div class="hidden lg:block">
                                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/20 shadow-xl min-w-[280px]">
                                    <div class="space-y-3">
                                        @if($store->phone)
                                        <a href="tel:{{ $store->phone }}" class="flex items-center gap-3 text-white hover:text-royal-gold-light transition-colors group">
                                            <div class="w-10 h-10 rounded-xl bg-royal-gold/20 flex items-center justify-center group-hover:bg-royal-gold/30 transition-colors">
                                                <svg class="w-5 h-5 text-royal-gold-light" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-xs text-white/60">{{ app()->getLocale() === 'ar' ? 'اتصل بنا' : 'Call Us' }}</p>
                                                <p class="font-semibold text-sm" dir="ltr">{{ $store->phone }}</p>
                                            </div>
                                        </a>
                                        @endif
                                        
                                        @if($store->address)
                                        <div class="flex items-center gap-3 text-white">
                                            <div class="w-10 h-10 rounded-xl bg-royal-gold/20 flex items-center justify-center">
                                                <svg class="w-5 h-5 text-royal-gold-light" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-xs text-white/60">{{ app()->getLocale() === 'ar' ? 'العنوان' : 'Address' }}</p>
                                                <p class="font-semibold text-sm">{{ Str::limit($store->address, 30) }}</p>
                                            </div>
                                        </div>
                                        @endif
                                        
                                        @if($store->phone)
                                        @php
                                            $whatsappNumber = preg_replace('/[^0-9]/', '', $store->phone);
                                            if(str_starts_with($whatsappNumber, '0')) {
                                                $whatsappNumber = '966' . substr($whatsappNumber, 1);
                                            }
                                        @endphp
                                        <a href="https://wa.me/{{ $whatsappNumber }}" target="_blank" 
                                           class="flex items-center justify-center gap-2 w-full bg-green-500 hover:bg-green-600 text-white px-4 py-2.5 rounded-xl transition-all shadow-lg hover:shadow-xl hover:scale-[1.02]">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                            </svg>
                                            <span class="font-semibold">{{ app()->getLocale() === 'ar' ? 'واتساب' : 'WhatsApp' }}</span>
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Store Contact Bar (Mobile Only) -->
            @if($store->phone || $store->address)
            <div class="lg:hidden bg-gradient-to-r from-cream to-gray-50 dark:from-gray-900 dark:to-gray-800 border-b border-royal-gold/10">
                <div class="max-w-7xl mx-auto px-4 py-3">
                    <div class="flex flex-wrap items-center justify-center gap-4">
                        @if($store->phone)
                        <a href="tel:{{ $store->phone }}" class="flex items-center gap-2 text-charcoal dark:text-white hover:text-royal-gold transition-colors">
                            <div class="w-8 h-8 rounded-full bg-royal-gold/10 flex items-center justify-center">
                                <svg class="w-4 h-4 text-royal-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <span class="text-sm font-medium" dir="ltr">{{ $store->phone }}</span>
                        </a>
                        @endif
                        
                        @if($store->address)
                        <div class="flex items-center gap-2 text-charcoal dark:text-white">
                            <div class="w-8 h-8 rounded-full bg-royal-gold/10 flex items-center justify-center">
                                <svg class="w-4 h-4 text-royal-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <span class="text-sm font-medium">{{ Str::limit($store->address, 25) }}</span>
                        </div>
                        @endif
                        
                        @if($store->phone)
                        @php
                            $whatsappNumber = preg_replace('/[^0-9]/', '', $store->phone);
                            if(str_starts_with($whatsappNumber, '0')) {
                                $whatsappNumber = '966' . substr($whatsappNumber, 1);
                            }
                        @endphp
                        <a href="https://wa.me/{{ $whatsappNumber }}" target="_blank" 
                           class="flex items-center gap-1.5 bg-green-500 hover:bg-green-600 text-white px-3 py-1.5 rounded-full text-sm transition-colors shadow">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            <span class="font-medium">{{ app()->getLocale() === 'ar' ? 'واتساب' : 'WhatsApp' }}</span>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endif
            
            <!-- PREMIUM CATEGORY TABS (Sticky) -->
            @if($categories->count() > 0)
                <div class="sticky top-20 z-40 bg-white/98 dark:bg-gray-900/98 backdrop-blur-lg border-b-2 border-royal-gold/20 shadow-elegant transition-smooth">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="relative">
                            <!-- Tabs Container -->
                            <div class="flex overflow-x-auto gap-3 md:gap-4 py-5 scrollbar-hide">
                                <!-- All Products Tab -->
                                <button @click="activeCategory = 'all'"
                                        :class="activeCategory === 'all' 
                                            ? 'bg-gradient-gold text-midnight shadow-elegant-lg scale-105 border-royal-gold' 
                                            : 'bg-white dark:bg-gray-800 text-charcoal dark:text-gray-300 hover:bg-royal-gold/10 hover:border-royal-gold/50 hover:scale-105'"
                                        class="group whitespace-nowrap px-6 py-3 rounded-2xl font-inter font-semibold text-sm transition-all duration-300 border-2 border-transparent flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                    </svg>
                                    <span>{{ app()->getLocale() === 'ar' ? 'الكل' : 'All' }}</span>
                                    <span class="opacity-75 text-xs font-normal">({{ $products->count() }})</span>
                                </button>
                                
                                <!-- Category Tabs with Icons -->
                                @foreach($categories as $category)
                                    @php
                                        $categoryProductCount = $products->where('merchant_category_id', $category->id)->count();
                                        // Category icon mapping
                                        $categoryIcons = [
                                            'iphones' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>',
                                            'macbooks' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>',
                                            'phone' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>',
                                            'laptop' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>',
                                            'electronics' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>',
                                        ];
                                        $iconPath = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>'; // default
                                        foreach($categoryIcons as $key => $path) {
                                            if(str_contains(strtolower($category->name), $key)) {
                                                $iconPath = $path;
                                                break;
                                            }
                                        }
                                    @endphp
                                    <button @click="activeCategory = '{{ $category->id }}'"
                                            :class="activeCategory === '{{ $category->id }}' 
                                                ? 'bg-gradient-gold text-midnight shadow-elegant-lg scale-105 border-royal-gold' 
                                                : 'bg-white dark:bg-gray-800 text-charcoal dark:text-gray-300 hover:bg-royal-gold/10 hover:border-royal-gold/50 hover:scale-105'"
                                            class="group whitespace-nowrap px-6 py-3 rounded-2xl font-inter font-semibold text-sm transition-all duration-300 border-2 border-transparent flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            {!! $iconPath !!}
                                        </svg>
                                        <span>{{ app()->getLocale() === 'ar' && $category->name_ar ? $category->name_ar : $category->name }}</span>
                                        <span class="opacity-75 text-xs font-normal">({{ $categoryProductCount }})</span>
                                    </button>
                                @endforeach
                            </div>
                            
                            <!-- Active Tab Indicator (Optional visual enhancement) -->
                            <div class="absolute bottom-0 h-1 bg-gradient-to-r from-royal-gold via-royal-gold-light to-royal-gold transition-all duration-300"></div>
                        </div>
                    </div>
                </div>
            @endif
            
            <!-- Products Grid -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">                @if($products->count() > 0)
                    <!-- Featured Products Section -->
                    @php
                        $featuredProducts = $products->where('is_featured', true)->sortBy('featured_order');
                        $regularProducts = $products->where('is_featured', false);
                    @endphp

                    <!-- Featured Products (Premium Grid) -->
                    @if($featuredProducts->count() > 0)
                        <div class="mb-12"
                             x-show="activeCategory === 'all' || {{ json_encode($featuredProducts->pluck('merchant_category_id')->unique()->values()) }}.includes(parseInt(activeCategory))">
                            
                            <!-- Section Header -->
                            <div class="flex items-center justify-between mb-8">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-gold flex items-center justify-center shadow-lg">
                                        <svg class="w-5 h-5 text-midnight" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-playfair font-bold text-charcoal dark:text-white">
                                            {{ app()->getLocale() === 'ar' ? 'المنتجات المميزة' : 'Featured Products' }}
                                        </h3>
                                        <p class="text-sm text-slate dark:text-gray-400">
                                            {{ app()->getLocale() === 'ar' ? 'اختيارات مميزة لك' : 'Handpicked for you' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="h-px flex-1 bg-gradient-to-l from-royal-gold/50 to-transparent mx-4 hidden sm:block"></div>
                            </div>
                            
                            <!-- Featured Products Grid - Same size cards -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                                @foreach($featuredProducts as $product)
                                    <div x-show="activeCategory === 'all' || activeCategory === '{{ $product->merchant_category_id }}'"
                                         x-transition:enter="transition ease-out duration-300"
                                         x-transition:enter-start="opacity-0 scale-95"
                                         x-transition:enter-end="opacity-100 scale-100">
                                        
                                        <a href="{{ route('products.show', [$store->slug, $product->slug]) }}" 
                                           class="group block bg-white dark:bg-gray-800 rounded-2xl shadow-elegant hover:shadow-elegant-2xl transition-all duration-500 overflow-hidden border-2 border-royal-gold/20 hover:border-royal-gold/50">
                                            
                                            <!-- Image Container -->
                                            <div class="relative aspect-square overflow-hidden bg-cream dark:bg-gray-700">
                                                @if($product->primaryImage)
                                                    <img src="{{ $product->primaryImage->image_url }}" 
                                                         alt="{{ $product->name }}"
                                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center">
                                                        <svg class="w-16 h-16 text-slate/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                        </svg>
                                                    </div>
                                                @endif
                                                
                                                <!-- Featured Badge -->
                                                <div class="absolute top-3 {{ app()->getLocale() === 'ar' ? 'right-3' : 'left-3' }} bg-gradient-gold text-midnight px-3 py-1.5 rounded-full text-xs font-bold shadow-lg flex items-center gap-1">
                                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                    </svg>
                                                    {{ app()->getLocale() === 'ar' ? 'مميز' : 'Featured' }}
                                                </div>
                                                
                                                <!-- Sale Badge -->
                                                @if($product->sale_price)
                                                    <div class="absolute top-3 {{ app()->getLocale() === 'ar' ? 'left-3' : 'right-3' }} bg-red-500 text-white px-2.5 py-1 rounded-full text-xs font-bold shadow-lg">
                                                        -{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                                                    </div>
                                                @endif
                                                
                                                <!-- Hover Overlay -->
                                                <div class="absolute inset-0 bg-gradient-to-t from-midnight/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                            </div>
                                            
                                            <!-- Content -->
                                            <div class="p-4">
                                                <!-- Category -->
                                                <p class="text-xs text-royal-gold font-medium mb-1">
                                                    {{ app()->getLocale() === 'ar' && $product->merchantCategory->name_ar ? $product->merchantCategory->name_ar : $product->merchantCategory->name }}
                                                </p>
                                                
                                                <!-- Product Name -->
                                                <h4 class="font-semibold text-charcoal dark:text-white mb-2 line-clamp-2 group-hover:text-royal-gold transition-colors">
                                                    {{ app()->getLocale() === 'ar' && $product->name_ar ? $product->name_ar : $product->name }}
                                                </h4>
                                                
                                                <!-- Price -->
                                                <div class="flex items-center gap-2">
                                                    @if($product->sale_price)
                                                        <span class="text-lg font-bold text-royal-gold">{{ number_format($product->sale_price, 2) }} SAR</span>
                                                        <span class="text-sm text-slate line-through">{{ number_format($product->price, 2) }}</span>
                                                    @else
                                                        <span class="text-lg font-bold text-royal-gold">{{ number_format($product->price, 2) }} SAR</span>
                                                    @endif
                                                </div>
                                                
                                                <!-- Stock Status -->
                                                <div class="mt-2">
                                                    @if($product->quantity > 0)
                                                        <span class="inline-flex items-center text-xs text-green-600 font-medium">
                                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1.5"></span>
                                                            {{ app()->getLocale() === 'ar' ? 'متوفر' : 'In Stock' }}
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center text-xs text-red-500 font-medium">
                                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5"></span>
                                                            {{ app()->getLocale() === 'ar' ? 'غير متوفر' : 'Out of Stock' }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Divider between Featured and Regular -->
                        @if($regularProducts->count() > 0)
                        <div class="flex items-center gap-4 mb-10">
                            <div class="h-px flex-1 bg-gradient-to-r from-transparent via-gray-200 dark:via-gray-700 to-transparent"></div>
                            <span class="text-sm text-slate dark:text-gray-400 font-medium px-4">
                                {{ app()->getLocale() === 'ar' ? 'جميع المنتجات' : 'All Products' }}
                            </span>
                            <div class="h-px flex-1 bg-gradient-to-r from-transparent via-gray-200 dark:via-gray-700 to-transparent"></div>
                        </div>
                        @endif
                    @endif

                    <!-- Regular Products Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-8">
                        @foreach($regularProducts as $product)
                            <div x-show="activeCategory === 'all' || activeCategory === '{{ $product->merchant_category_id }}'"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100">
                                <x-product-card-store :product="$product" />
                            </div>
                        @endforeach
                    </div>

                    <!-- No Products in Category Message -->
                    <div x-show="activeCategory !== 'all'" 
                         x-cloak
                         class="text-center py-12"
                         :class="{ 'hidden': document.querySelectorAll('[x-show*=activeCategory]:not([style*=\'display: none\'])').length > 0 }">
                        {{-- This will be shown via JS if no products match --}}
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="text-center py-16">
                        <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-cream dark:bg-gray-700 mb-6">
                            <svg class="w-12 h-12 text-slate" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-playfair font-semibold text-charcoal dark:text-white mb-2">
                            {{ app()->getLocale() === 'ar' ? 'لا توجد منتجات بعد' : 'No Products Yet' }}
                        </h3>
                        <p class="text-slate dark:text-gray-400">
                            {{ app()->getLocale() === 'ar' ? 'سيتم إضافة المنتجات قريباً' : 'Products will be added soon' }}
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>

</x-guest-luxury>
