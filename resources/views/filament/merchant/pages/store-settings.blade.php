<x-filament-panels::page>
    <form wire:submit="save">
        {{ $this->form }}
        
        <div class="mt-6">
            <x-filament::button type="submit" size="lg">
                {{ __('حفظ الإعدادات') }}
            </x-filament::button>
        </div>
    </form>
    
    <!-- Store Preview -->
    <div class="mt-8">
        <x-filament::section>
            <x-slot name="heading">
                {{ __('معاينة المتجر') }}
            </x-slot>
            <x-slot name="description">
                {{ __('هكذا سيظهر متجرك للعملاء') }}
            </x-slot>
            
            <div class="flex items-center gap-4 p-4 bg-gray-50 dark:bg-gray-800 rounded-xl">
                @php
                    $merchant = auth()->user()->merchant;
                @endphp
                
                @if($merchant->logo)
                    <img src="{{ $merchant->logo_url }}" 
                         alt="{{ $merchant->store_name }}" 
                         class="w-20 h-20 rounded-full object-cover border-2 border-primary-500">
                @else
                    <div class="w-20 h-20 rounded-full bg-primary-500 flex items-center justify-center text-white text-2xl font-bold">
                        {{ substr($merchant->store_name, 0, 1) }}
                    </div>
                @endif
                
                <div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                        {{ app()->getLocale() === 'ar' && $merchant->store_name_ar ? $merchant->store_name_ar : $merchant->store_name }}
                    </h3>
                    @if($merchant->description || $merchant->description_ar)
                        <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">
                            {{ app()->getLocale() === 'ar' && $merchant->description_ar ? Str::limit($merchant->description_ar, 100) : Str::limit($merchant->description, 100) }}
                        </p>
                    @endif
                </div>
            </div>
            
            <div class="mt-4">
                <a href="{{ route('stores.show', $merchant->slug) }}" 
                   target="_blank"
                   class="inline-flex items-center gap-2 text-primary-600 hover:text-primary-700 font-medium">
                    <x-heroicon-o-eye class="w-5 h-5" />
                    {{ __('عرض المتجر') }}
                </a>
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>
