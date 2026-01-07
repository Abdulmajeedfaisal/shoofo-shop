@props([
    'variant' => 'primary', // primary, secondary, ghost
    'size' => 'md', // sm, md, lg
    'type' => 'button',
    'href' => null,
])

@php
$baseClasses = 'inline-flex items-center justify-center font-inter font-medium transition-elegant focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';

$variantClasses = [
    'primary' => 'bg-royal-gold text-midnight hover:bg-royal-gold-600 focus:ring-royal-gold shadow-elegant hover:shadow-elegant-lg hover:scale-105',
    'secondary' => 'bg-transparent border-2 border-midnight text-midnight hover:bg-midnight hover:text-white focus:ring-midnight',
    'ghost' => 'bg-transparent text-charcoal hover:bg-gray-100 focus:ring-gray-300',
];

$sizeClasses = [
    'sm' => 'px-4 py-2 text-sm rounded-md',
    'md' => 'px-8 py-3 text-base rounded-lg',
    'lg' => 'px-10 py-4 text-lg rounded-xl',
];

$classes = $baseClasses . ' ' . $variantClasses[$variant] . ' ' . $sizeClasses[$size];
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
