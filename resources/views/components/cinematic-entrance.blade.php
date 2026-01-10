{{-- 
    Cinematic Entrance Component
    Luxury store entrance animation with curtains, particles, and logo crystallization
    
    Props:
    - $show: boolean - Whether to show the entrance animation
    - $storeName: string - The store name (English)
    - $storeNameAr: string|null - The store name (Arabic)
    - $logoUrl: string|null - URL to the store logo
--}}

@props([
    'show' => true,
    'storeName' => '',
    'storeNameAr' => null,
    'logoUrl' => null,
])

@if($show)
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
    @keyframes sparkleFloatCinematic {
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
    .animate-sparkle-cinematic { animation: sparkleFloatCinematic linear infinite; }
</style>

<div x-data="{ 
    entering: true,
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
     x-init="setTimeout(() => entering = false, 3000)"
     @click="entering = false">
    
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
                <div class="absolute animate-sparkle-cinematic text-royal-gold"
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
                    
                    <!-- Actual Logo -->
                    <div class="relative w-32 h-32 md:w-40 md:h-40 lg:w-48 lg:h-48 rounded-full overflow-hidden"
                         style="background: transparent; box-shadow: 0 0 15px rgba(255, 215, 0, 0.2);">
                        @if($logoUrl)
                            <div class="absolute inset-0 flex items-center justify-center p-1.5 bg-white rounded-full">
                                <img src="{{ $logoUrl }}" 
                                     alt="{{ $storeName }}"
                                     class="w-full h-full object-contain rounded-full relative z-10"
                                     style="filter: drop-shadow(0 0 8px rgba(255,215,0,0.4));">
                            </div>
                            <!-- Golden Ring Border -->
                            <div class="absolute inset-0 rounded-full border border-royal-gold/40 pointer-events-none"></div>
                        @else
                            <div class="absolute inset-0 rounded-full bg-gradient-to-br from-royal-gold via-royal-gold-light to-royal-gold flex items-center justify-center shadow-2xl border-4 border-white/30"
                                 style="filter: drop-shadow(0 0 30px rgba(255,215,0,0.6));">
                                <span class="text-5xl md:text-6xl lg:text-7xl font-playfair font-bold text-midnight">
                                    {{ substr($storeName, 0, 1) }}
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
                            {{ app()->getLocale() === 'ar' && $storeNameAr ? $storeNameAr : $storeName }}
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
                            {{ __('general.welcome_boutique') }}
                        </p>
                        <span class="entrance-ornament text-royal-gold text-2xl opacity-0" style="animation-delay: 1500ms;">✦</span>
                    </div>
                </div>
                
                <!-- Skip Hint -->
                <p class="absolute bottom-12 left-1/2 -translate-x-1/2 text-white/40 text-sm font-light animate-pulse">
                    {{ __('general.click_to_enter') }}
                </p>
            </div>
        </div>
    </div>
    
    <!-- Main Content (passed via slot) -->
    <div x-show="!entering" 
         x-transition:enter="transition duration-700 ease-out"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100">
        {{ $slot }}
    </div>
</div>
@else
    {{ $slot }}
@endif
