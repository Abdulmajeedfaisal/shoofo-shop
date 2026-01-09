@php
    $statuses = ['pending', 'confirmed', 'processing', 'shipped', 'delivered'];
    $currentStatus = $getRecord()->status ?? 'pending';
    $currentIndex = array_search($currentStatus, $statuses);
    $isCancelled = $currentStatus === 'cancelled';
    
    $statusLabels = [
        'pending' => 'قيد الانتظار',
        'confirmed' => 'مؤكد',
        'processing' => 'قيد التجهيز',
        'shipped' => 'تم الشحن',
        'delivered' => 'تم التسليم',
    ];
    
    $statusIcons = [
        'pending' => '⏳',
        'confirmed' => '✅',
        'processing' => '🔄',
        'shipped' => '🚚',
        'delivered' => '📦',
    ];
@endphp

<div class="py-4">
    @if($isCancelled)
        <div class="flex items-center justify-center p-4 bg-danger-50 dark:bg-danger-900/20 rounded-xl border border-danger-200 dark:border-danger-800">
            <span class="text-2xl ml-3">❌</span>
            <span class="text-lg font-bold text-danger-600 dark:text-danger-400">تم إلغاء هذا الطلب</span>
        </div>
    @else
        <div class="relative">
            {{-- Progress Line --}}
            <div class="absolute top-6 right-6 left-6 h-1 bg-gray-200 dark:bg-gray-700 rounded-full">
                <div 
                    class="h-full bg-gradient-to-l from-primary-500 to-success-500 rounded-full transition-all duration-500"
                    style="width: {{ $currentIndex !== false ? ($currentIndex / (count($statuses) - 1)) * 100 : 0 }}%"
                ></div>
            </div>
            
            {{-- Status Steps --}}
            <div class="relative flex justify-between">
                @foreach($statuses as $index => $status)
                    @php
                        $isCompleted = $currentIndex !== false && $index < $currentIndex;
                        $isCurrent = $index === $currentIndex;
                        $isPending = $currentIndex !== false && $index > $currentIndex;
                    @endphp
                    
                    <div class="flex flex-col items-center">
                        {{-- Circle --}}
                        <div class="relative z-10 flex items-center justify-center w-12 h-12 rounded-full border-2 transition-all duration-300
                            @if($isCompleted)
                                bg-success-500 border-success-500 text-white
                            @elseif($isCurrent)
                                bg-primary-500 border-primary-500 text-white ring-4 ring-primary-100 dark:ring-primary-900
                            @else
                                bg-gray-100 dark:bg-gray-800 border-gray-300 dark:border-gray-600 text-gray-400
                            @endif
                        ">
                            @if($isCompleted)
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            @else
                                <span class="text-lg">{{ $statusIcons[$status] }}</span>
                            @endif
                        </div>
                        
                        {{-- Label --}}
                        <span class="mt-2 text-xs font-medium text-center
                            @if($isCompleted || $isCurrent)
                                text-gray-900 dark:text-white
                            @else
                                text-gray-400 dark:text-gray-500
                            @endif
                        ">
                            {{ $statusLabels[$status] }}
                        </span>
                        
                        {{-- Current indicator --}}
                        @if($isCurrent)
                            <span class="mt-1 px-2 py-0.5 text-xs font-bold bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300 rounded-full">
                                الحالة الحالية
                            </span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
