@props([
    'variant' => 'default', // default, product, store
    'padding' => 'md', // sm, md, lg
])

@php
$baseClasses = 'bg-white dark:bg-gray-800 rounded-xl shadow-lg transition-all duration-300';

$variantClasses = [
    'default' => 'hover:shadow-xl',
    'product' => 'hover:shadow-xl hover:scale-[1.02] cursor-pointer',
    'store' => 'hover:shadow-2xl hover:-translate-y-2 cursor-pointer',
];

$paddingClasses = [
    'sm' => 'p-4',
    'md' => 'p-6',
    'lg' => 'p-8',
];

$classes = $baseClasses . ' ' . $variantClasses[$variant] . ' ' . $paddingClasses[$padding];
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
