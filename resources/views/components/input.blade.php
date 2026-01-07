@props([
    'type' => 'text',
    'name',
    'label' => null,
    'error' => null,
    'required' => false,
])

<div class="mb-4">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-charcoal mb-2">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    @if($type === 'textarea')
        <textarea
            id="{{ $name }}"
            name="{{ $name }}"
            {{ $required ? 'required' : '' }}
            {{ $attributes->merge(['class' => 'w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-royal-gold focus:border-royal-gold transition-elegant font-inter ' . ($error ? 'border-red-500' : '')]) }}
        >{{ $slot }}</textarea>
    @elseif($type === 'select')
        <select
            id="{{ $name }}"
            name="{{ $name }}"
            {{ $required ? 'required' : '' }}
            {{ $attributes->merge(['class' => 'w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-royal-gold focus:border-royal-gold transition-elegant font-inter ' . ($error ? 'border-red-500' : '')]) }}
        >
            {{ $slot }}
        </select>
    @else
        <input
            type="{{ $type }}"
            id="{{ $name }}"
            name="{{ $name }}"
            {{ $required ? 'required' : '' }}
            {{ $attributes->merge(['class' => 'w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-royal-gold focus:border-royal-gold transition-elegant font-inter ' . ($error ? 'border-red-500' : '')]) }}
        />
    @endif

    @if($error)
        <p class="mt-1 text-sm text-red-500">{{ $error }}</p>
    @endif
</div>
