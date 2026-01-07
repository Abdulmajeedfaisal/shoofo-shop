<div x-data="{ open: false }" class="relative">
    <button 
        @click="open = !open" 
        class="flex items-center gap-2 px-3 py-2 text-charcoal hover:text-royal-gold transition-elegant"
    >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
        </svg>
        <span class="font-inter font-medium">
            {{ app()->getLocale() === 'ar' ? 'العربية' : 'English' }}
        </span>
        <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>
    
    <div 
        x-show="open" 
        @click.away="open = false"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute mt-2 w-48 bg-white rounded-lg shadow-elegant-lg overflow-hidden z-50 {{ app()->getLocale() === 'ar' ? 'left-0' : 'right-0' }}"
        style="display: none;"
    >
        <a 
            href="{{ route('locale.switch', 'en') }}" 
            class="block px-4 py-3 text-charcoal hover:bg-cream hover:text-royal-gold transition-elegant font-inter"
        >
            <div class="flex items-center space-x-2">
                <span>🇬🇧</span>
                <span>English</span>
            </div>
        </a>
        <a 
            href="{{ route('locale.switch', 'ar') }}" 
            class="block px-4 py-3 text-charcoal hover:bg-cream hover:text-royal-gold transition-elegant font-inter"
        >
            <div class="flex items-center space-x-2">
                <span>🇸🇦</span>
                <span>العربية</span>
            </div>
        </a>
    </div>
</div>
