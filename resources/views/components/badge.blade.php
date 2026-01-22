@props([
    'variant' => 'default', // default, primary, success, danger, warning, info
    'size' => 'md', // sm, md, lg
    'rounded' => 'full', // full, md, lg
])

@php
    $baseClasses = 'inline-flex items-center font-medium';
    
    $variantClasses = match($variant) {
        'default' => 'bg-gray-50 text-gray-700 dark:bg-gray-900/40 dark:text-gray-300',
        'primary' => 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300',
        'success' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300',
        'danger' => 'bg-rose-50 text-rose-700 dark:bg-rose-900/30 dark:text-rose-300',
        'warning' => 'bg-amber-50 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300',
        'info' => 'bg-sky-50 text-sky-700 dark:bg-sky-900/30 dark:text-sky-300',
        default => 'bg-gray-50 text-gray-700 dark:bg-gray-900/40 dark:text-gray-300',
    };
    
    $sizeClasses = match($size) {
        'sm' => 'px-2 py-0.5 text-xs',
        'md' => 'px-2.5 py-0.5 text-xs',
        'lg' => 'px-3 py-1 text-sm',
        default => 'px-2.5 py-0.5 text-xs',
    };
    
    $roundedClasses = match($rounded) {
        'full' => 'rounded-full',
        'md' => 'rounded-md',
        'lg' => 'rounded-lg',
        default => 'rounded-full',
    };
    
    $classes = "{$baseClasses} {$variantClasses} {$sizeClasses} {$roundedClasses}";
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>
