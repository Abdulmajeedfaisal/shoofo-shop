<x-filament-panels::page>
    <form wire:submit="save">
        {{ $this->form }}

        <div class="mt-6">
            <x-filament::button type="submit" size="lg">
                <x-slot name="icon">
                    <x-heroicon-o-check class="w-5 h-5" />
                </x-slot>
                حفظ الإعدادات
            </x-filament::button>
        </div>
    </form>

    {{-- معاينة --}}
    <x-filament::section class="mt-8" icon="heroicon-o-eye" heading="معاينة">
        <div class="prose dark:prose-invert max-w-none">
            <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
                <h4 class="text-lg font-semibold mb-2">كيف سيظهر للعميل:</h4>
                @php
                    $type = $this->data['shipping_type'] ?? 'free';
                    $cost = $this->data['fixed_shipping_cost'] ?? 0;
                    $threshold = $this->data['free_shipping_threshold'] ?? 0;
                @endphp
                
                @if($type === 'free')
                    <div class="flex items-center gap-2 text-green-600 dark:text-green-400">
                        <x-heroicon-o-gift class="w-5 h-5" />
                        <span>🎁 شحن مجاني لجميع الطلبات</span>
                    </div>
                @elseif($type === 'fixed')
                    <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                        <x-heroicon-o-truck class="w-5 h-5" />
                        <span>💰 تكلفة الشحن: {{ number_format($cost, 2) }} ريال</span>
                    </div>
                @elseif($type === 'threshold')
                    <div class="space-y-2">
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <x-heroicon-o-truck class="w-5 h-5" />
                            <span>💰 تكلفة الشحن: {{ number_format($cost, 2) }} ريال</span>
                        </div>
                        <div class="flex items-center gap-2 text-green-600 dark:text-green-400">
                            <x-heroicon-o-gift class="w-5 h-5" />
                            <span>🎁 شحن مجاني للطلبات فوق {{ number_format($threshold, 2) }} ريال</span>
                        </div>
                    </div>
                @elseif($type === 'per_merchant')
                    <div class="flex items-center gap-2 text-purple-600 dark:text-purple-400">
                        <x-heroicon-o-building-storefront class="w-5 h-5" />
                        <span>🏪 تكلفة الشحن تختلف حسب المتجر</span>
                    </div>
                @endif
            </div>
        </div>
    </x-filament::section>
</x-filament-panels::page>
