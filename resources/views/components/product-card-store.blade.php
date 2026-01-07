@props(['product'])

<a href="{{ route('products.show', [$product->merchant->slug, $product->slug]) }}" 
   class="block bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 hover:scale-102 overflow-hidden group">
    
    <!-- Product Image Container -->
    <div class="relative aspect-[4/3] overflow-hidden bg-cream">
        @if($product->primaryImage)
            <img src="{{ $product->primaryImage->image }}" 
                 alt="{{ $product->name }}"
                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
        @else
            <div class="w-full h-full flex items-center justify-center">
                <svg class="w-20 h-20 text-slate" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        @endif
        
        <!-- Featured Badge -->
        @if($product->is_featured)
            <div class="absolute top-3 left-3 bg-royal-gold text-midnight px-3 py-1 rounded-full text-xs font-inter font-semibold shadow-lg">
                {{ __('products.featured') }}
            </div>
        @endif
        
        <!-- Sale Badge -->
        @if($product->sale_price)
            <div class="absolute top-3 right-3 bg-red-500 text-white px-3 py-1 rounded-full text-xs font-inter font-semibold shadow-lg">
                {{ __('products.sale') }}
            </div>
        @endif
    </div>
    
    <!-- Product Details -->
    <div class="p-6">
        <!-- Product Name -->
        <h3 class="text-lg font-inter font-semibold text-charcoal mb-2 line-clamp-2 group-hover:text-royal-gold transition-colors">
            {{ app()->getLocale() === 'ar' && $product->name_ar ? $product->name_ar : $product->name }}
        </h3>
        
        <!-- Category Name -->
        <p class="text-sm text-slate mb-3">
            {{ app()->getLocale() === 'ar' && $product->merchantCategory->name_ar ? $product->merchantCategory->name_ar : $product->merchantCategory->name }}
        </p>
        
        <!-- Price -->
        <div class="flex items-center gap-2">
            @if($product->sale_price)
                <span class="text-xl font-inter font-bold text-royal-gold">
                    {{ number_format($product->sale_price, 2) }} {{ __('products.currency') }}
                </span>
                <span class="text-sm text-slate line-through">
                    {{ number_format($product->price, 2) }} {{ __('products.currency') }}
                </span>
            @else
                <span class="text-xl font-inter font-bold text-royal-gold">
                    {{ number_format($product->price, 2) }} {{ __('products.currency') }}
                </span>
            @endif
        </div>
        
        <!-- Stock Status -->
        <div class="mt-3">
            @if($product->quantity > 0)
                <span class="inline-flex items-center text-xs text-green-600">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    {{ __('products.in_stock') }}
                </span>
            @else
                <span class="inline-flex items-center text-xs text-red-600">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    {{ __('products.out_of_stock') }}
                </span>
            @endif
        </div>
    </div>
</a>
