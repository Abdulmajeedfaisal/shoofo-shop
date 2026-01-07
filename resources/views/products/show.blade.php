<x-guest-luxury :title="$product->name . ' - ' . $merchant->store_name . ' - ' . config('app.name', 'SHOOFO')">

    @php
        // Check if user came from category page (not from store page)
        $showCinematicEntrance = false;
        $referer = request()->headers->get('referer');
        if ($referer) {
            $refererPath = parse_url($referer, PHP_URL_PATH);
            // Show cinematic entrance if coming from categories or home, but not from store
            if ($refererPath && (str_contains($refererPath, '/categories') || $refererPath === '/' || $refererPath === '')) {
                $showCinematicEntrance = true;
            }
        }
        // Also check query parameter for direct control
        if (request()->has('entrance')) {
            $showCinematicEntrance = request()->get('entrance') === '1';
        }
    @endphp

    @if($showCinematicEntrance)
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
        
        /* Sparkle Float */
        @keyframes sparkleFloat {
            0% { transform: translateY(0) scale(0) rotate(0deg); opacity: 0; }
            20% { opacity: 0.8; transform: translateY(-20px) scale(1) rotate(45deg); }
            80% { opacity: 0.8; transform: translateY(-80px) scale(1) rotate(135deg); }
            100% { transform: translateY(-100px) scale(0) rotate(180deg); opacity: 0; }
        }
        
        .entrance-curtain-left { animation: curtainOpen 800ms cubic-bezier(0.4, 0.0, 0.2, 1) forwards; }
        .entrance-curtain-right { animation: curtainOpenRight 800ms cubic-bezier(0.4, 0.0, 0.2, 1) forwards; }
        .entrance-particle { animation: particleSwirl 1.5s cubic-bezier(0.4, 0.0, 0.2, 1) forwards; will-change: transform, opacity; }
        .entrance-logo { animation: logoCarystallize 1.4s cubic-bezier(0.34, 1.56, 0.64, 1) 600ms forwards; will-change: transform, opacity, filter; }
        .entrance-brand { animation: brandReveal 800ms cubic-bezier(0.4, 0.0, 0.2, 1) 1200ms forwards; }
        .entrance-shimmer { background: linear-gradient(90deg, transparent, rgba(255,255,255,0.8), transparent); background-size: 200% 100%; animation: goldenShimmer 2s linear infinite; }
        .entrance-shine { animation: diamondShine 3s ease-in-out infinite; }
        .entrance-ornament { animation: ornamentFade 600ms cubic-bezier(0.34, 1.56, 0.64, 1) forwards; }
        .animate-sparkle-product { animation: sparkleFloat linear infinite; }
    </style>

    <div x-data="{ 
        entering: {{ $showCinematicEntrance ? 'true' : 'false' }},
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
                <div class="entrance-curtain-left absolute inset-y-0 left-0 w-1/2"
                     style="background: linear-gradient(120deg, #B8860B 0%, #FFD700 30%, #DAA520 60%, #B8860B 100%); box-shadow: inset -20px 0 40px rgba(0,0,0,0.3), 0 0 100px rgba(255,215,0,0.3);">
                    <div class="absolute inset-0 opacity-30" style="background: repeating-linear-gradient(90deg, transparent, transparent 2px, rgba(0,0,0,0.1) 2px, rgba(0,0,0,0.1) 4px);"></div>
                </div>
                <div class="entrance-curtain-right absolute inset-y-0 right-0 w-1/2"
                     style="background: linear-gradient(240deg, #B8860B 0%, #FFD700 30%, #DAA520 60%, #B8860B 100%); box-shadow: inset 20px 0 40px rgba(0,0,0,0.3), 0 0 100px rgba(255,215,0,0.3);">
                    <div class="absolute inset-0 opacity-30" style="background: repeating-linear-gradient(90deg, transparent, transparent 2px, rgba(0,0,0,0.1) 2px, rgba(0,0,0,0.1) 4px);"></div>
                </div>
            </div>
            
            <!-- ✨ Luxury Sparkle System -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none z-0">
                <template x-for="i in 50" :key="'sparkle-'+i">
                    <div class="absolute animate-sparkle-product text-royal-gold"
                         :style="`left: ${Math.random() * 100}%; top: ${Math.random() * 100}%; font-size: ${Math.random() * (24 - 8) + 8}px; animation-duration: ${Math.random() * (4 - 2) + 2}s; animation-delay: ${Math.random() * 0.5}s; opacity: 0; filter: blur(${Math.random() > 0.8 ? '1px' : '0px'});`">✦</div>
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
                         :style="`width: ${particle.size}px; height: ${particle.size}px; background: radial-gradient(circle, #FFD700, #DAA520); box-shadow: 0 0 ${particle.size * 2}px rgba(255, 215, 0, 0.8); --x-start: ${particle.xStart}px; --y-start: ${particle.yStart}px; --x-target: ${particle.xTarget}px; --y-target: ${particle.yTarget}px; animation-delay: ${particle.delay}ms;`"></div>
                </template>
            </div>
            
            <!-- Logo Crystallization Container -->
            <div class="absolute inset-0 flex items-center justify-center z-20" style="perspective: 1200px;">
                <div class="text-center">
                    <!-- Logo with Multi-Layer Effects -->
                    <div class="relative inline-block entrance-logo opacity-0">
                        <div class="absolute inset-0 -inset-6">
                            <div class="w-full h-full rounded-full" style="background: radial-gradient(circle, rgba(255,215,0,0.35) 0%, rgba(255,215,0,0.15) 50%, transparent 75%); filter: blur(20px); animation: pulse 2s ease-in-out infinite;"></div>
                        </div>
                        <div class="absolute -inset-4 overflow-hidden rounded-full opacity-50">
                            <div class="entrance-shine absolute w-24 h-[200%] bg-gradient-to-r from-transparent via-white to-transparent" style="transform: translateX(-150%) rotate(45deg);"></div>
                        </div>
                        <div class="relative w-32 h-32 md:w-40 md:h-40 lg:w-48 lg:h-48 rounded-full overflow-hidden" style="box-shadow: 0 0 15px rgba(255, 215, 0, 0.2);">
                            @if($merchant->logo)
                                <div class="absolute inset-0 flex items-center justify-center p-1.5 bg-white rounded-full">
                                    <img src="{{ $merchant->logo_url }}" alt="{{ $merchant->store_name }}" class="w-full h-full object-contain rounded-full relative z-10" style="filter: drop-shadow(0 0 8px rgba(255,215,0,0.4));">
                                </div>
                                <div class="absolute inset-0 rounded-full border border-royal-gold/40 pointer-events-none"></div>
                            @else
                                <div class="absolute inset-0 rounded-full bg-gradient-to-br from-royal-gold via-royal-gold-light to-royal-gold flex items-center justify-center shadow-2xl border-4 border-white/30" style="filter: drop-shadow(0 0 30px rgba(255,215,0,0.6));">
                                    <span class="text-5xl md:text-6xl lg:text-7xl font-playfair font-bold text-midnight">{{ substr($merchant->store_name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="absolute -bottom-8 left-1/2 -translate-x-1/2 w-3/4 h-8 opacity-30" style="background: radial-gradient(ellipse, rgba(255,215,0,0.4) 0%, transparent 70%); filter: blur(8px);"></div>
                    </div>
                    
                    <!-- Brand Name Reveal -->
                    <div class="entrance-brand mt-12 opacity-0">
                        <h2 class="text-3xl md:text-4xl lg:text-5xl font-playfair font-black text-white tracking-wide relative inline-block">
                            <span class="relative z-10">{{ app()->getLocale() === 'ar' && $merchant->store_name_ar ? $merchant->store_name_ar : $merchant->store_name }}</span>
                            <div class="entrance-shimmer absolute inset-0 opacity-50"></div>
                        </h2>
                        <div class="mt-3 h-1 w-32 mx-auto rounded-full bg-gradient-to-r from-transparent via-royal-gold to-transparent shadow-lg shadow-royal-gold/50"></div>
                    </div>
                    
                    <!-- Welcome Ceremony -->
                    <div class="entrance-brand mt-8 opacity-0">
                        <div class="flex items-center justify-center gap-4">
                            <span class="entrance-ornament text-royal-gold text-2xl opacity-0" style="animation-delay: 1400ms;">✦</span>
                            <p class="text-royal-gold text-lg md:text-xl font-medium tracking-widest">{{ app()->getLocale() === 'ar' ? 'مرحباً بك في متجرنا الفاخر' : 'Welcome to our Boutique' }}</p>
                            <span class="entrance-ornament text-royal-gold text-2xl opacity-0" style="animation-delay: 1500ms;">✦</span>
                        </div>
                    </div>
                    
                    <p class="absolute bottom-12 left-1/2 -translate-x-1/2 text-white/40 text-sm font-light animate-pulse">{{ app()->getLocale() === 'ar' ? 'انقر في أي مكان للدخول' : 'Click anywhere to enter' }}</p>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div x-show="!entering" 
             x-transition:enter="transition duration-700 ease-out"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100">
    @endif

    <div class="bg-white dark:bg-gray-900 transition-smooth">
        <!-- Breadcrumb -->
        <div class="bg-cream dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <nav class="flex items-center gap-2 text-sm flex-wrap">
                    <a href="{{ route('home') }}" class="text-slate dark:text-gray-400 hover:text-royal-gold transition-colors">
                        {{ app()->getLocale() === 'ar' ? 'الرئيسية' : 'Home' }}
                    </a>
                    <svg class="w-4 h-4 text-slate {{ app()->getLocale() === 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    
                    @if($showCinematicEntrance && $product->globalCategory)
                        {{-- User came from categories page --}}
                        <a href="{{ route('categories.show', $product->globalCategory->slug) }}" class="text-slate dark:text-gray-400 hover:text-royal-gold transition-colors">
                            {{ app()->getLocale() === 'ar' && $product->globalCategory->name_ar ? $product->globalCategory->name_ar : $product->globalCategory->name }}
                        </a>
                    @else
                        {{-- User came from store page --}}
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
                 mainImage: '{{ $product->images->first() ? $product->images->first()->image : '' }}',
                 currentIndex: 0,
                 quantity: 1,
                 maxQuantity: {{ $product->quantity }},
                 lightboxOpen: false,
                 images: {{ json_encode($product->images->pluck('image')) }}
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
                                <button @click="mainImage = '{{ $image->image }}'; currentIndex = {{ $index }}"
                                        :class="currentIndex === {{ $index }} ? 'ring-2 ring-royal-gold' : 'ring-1 ring-gray-200'"
                                        class="aspect-square bg-cream rounded-lg overflow-hidden hover:ring-2 hover:ring-royal-gold transition-all">
                                    <img src="{{ $image->image }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
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

                    @if($product->description)
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                            <h3 class="text-lg font-playfair font-semibold text-charcoal dark:text-white mb-2">{{ app()->getLocale() === 'ar' ? 'الوصف' : 'Description' }}</h3>
                            <p class="text-slate dark:text-gray-300 leading-relaxed text-sm whitespace-pre-line">
                                {{ app()->getLocale() === 'ar' && $product->description_ar ? $product->description_ar : $product->description }}
                            </p>
                        </div>
                    @endif
                </div>
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

    <!-- Lightbox -->
    <div x-show="lightboxOpen" x-transition @keydown.escape.window="lightboxOpen = false" class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 p-4" style="display: none;">
        <button @click="lightboxOpen = false" class="absolute top-4 {{ app()->getLocale() === 'ar' ? 'left-4' : 'right-4' }} text-white hover:text-royal-gold">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        <img :src="mainImage" alt="{{ $product->name }}" class="max-w-full max-h-[85vh] object-contain rounded-lg">
    </div>

    @if($showCinematicEntrance)
        </div>
    </div>
    @endif

</x-guest-luxury>
