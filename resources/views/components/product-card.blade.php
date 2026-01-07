@props([
    'product',
    'showStore' => true, // Show store branding in global view
])

<a href="{{ route('products.show', [$product->merchant->slug, $product->slug]) }}" class="group block">
    <x-card variant="product" padding="md" class="h-full flex flex-col hover:shadow-xl transition-all duration-300">
        <!-- Product Image -->
        <div class="relative mb-4 aspect-[4/3] bg-cream rounded-lg overflow-hidden">
            @if($product->primaryImage)
            <img 
                src="{{ $product->primaryImage->image }}" 
                alt="{{ app()->getLocale() === 'ar' ? $product->name_ar : $product->name }}"
                class="w-full h-full object-cover group-hover:scale-105 transition-elegant duration-500"
                loading="lazy"
            >
            @else
            <div class="w-full h-full flex items-center justify-center bg-cream">
                <svg class="w-16 h-16 text-slate/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            @endif

            <!-- Store Badge (Only in global view) -->
            @if($showStore && $product->merchant)
            <div class="absolute top-3 {{ app()->getLocale() === 'ar' ? 'left-3' : 'right-3' }}">
                @if($product->merchant->logo)
                <img 
                    src="{{ $product->merchant->logo_url }}" 
                    alt="{{ app()->getLocale() === 'ar' ? $product->merchant->store_name_ar : $product->merchant->store_name }}"
                    class="w-12 h-12 rounded-full object-cover bg-white border-2 border-white shadow-elegant"
                >
                @else
                <div class="w-12 h-12 rounded-full bg-white border-2 border-white shadow-elegant flex items-center justify-center">
                    <span class="text-sm font-playfair font-bold text-royal-gold">
                        {{ substr($product->merchant->store_name, 0, 1) }}
                    </span>
                </div>
                @endif
            </div>
            @endif

            <!-- Featured Badge -->
            @if($product->is_featured)
            <div class="absolute top-3 {{ app()->getLocale() === 'ar' ? 'right-3' : 'left-3' }}">
                <span class="bg-royal-gold text-midnight text-xs font-bold px-3 py-1 rounded-full">
                    {{ __('products.featured') }}
                </span>
            </div>
            @endif

            <!-- Sale Badge -->
            @if($product->sale_price)
            <div class="absolute bottom-3 {{ app()->getLocale() === 'ar' ? 'right-3' : 'left-3' }}">
                <span class="bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full">
                    {{ __('products.sale') }}
                </span>
            </div>
            @endif
        </div>

        <!-- Product Info -->
        <div class="flex-1 flex flex-col">
            <!-- Store Name (Only in global view) -->
            @if($showStore && $product->merchant)
            <p class="text-slate text-sm mb-1">
                {{ app()->getLocale() === 'ar' ? $product->merchant->store_name_ar : $product->merchant->store_name }}
            </p>
            @endif

            <!-- Product Name -->
            <h3 class="font-playfair text-lg font-semibold text-charcoal mb-2 line-clamp-2 group-hover:text-royal-gold transition-elegant">
                {{ app()->getLocale() === 'ar' ? $product->name_ar : $product->name }}
            </h3>

            <!-- Category -->
            @if($product->merchantCategory)
            <p class="text-slate text-xs mb-3">
                {{ app()->getLocale() === 'ar' ? $product->merchantCategory->name_ar : $product->merchantCategory->name }}
            </p>
            @endif

            <!-- Price -->
            <div class="mt-auto">
                @if($product->sale_price)
                <div class="flex items-center gap-2">
                    <span class="text-royal-gold font-bold text-xl">
                        {{ number_format($product->sale_price, 2) }} {{ __('products.price') }}
                    </span>
                    <span class="text-slate text-sm line-through">
                        {{ number_format($product->price, 2) }}
                    </span>
                </div>
                @else
                <span class="text-royal-gold font-bold text-xl">
                    {{ number_format($product->price, 2) }} SAR
                </span>
                @endif
            </div>

            <!-- Stock Status -->
            <div class="mt-2">
                @if($product->isInStock())
                <span class="text-green-600 text-xs font-medium">
                    ● {{ __('products.in_stock') }}
                </span>
                @else
                <span class="text-red-500 text-xs font-medium">
                    ● {{ __('products.out_of_stock') }}
                </span>
                @endif
            </div>
        </div>
    </x-card>
</a>
