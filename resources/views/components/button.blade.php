@props([
    'variant' => 'primary', // primary, secondary, success, danger, warning, outline, ghost
    'size' => 'md', // sm, md, lg
    'type' => 'button',
    'icon' => null, // left icon
    'iconRight' => null, // right icon
    'disabled' => false,
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';
    
    $variantClasses = match($variant) {
        'primary' => 'bg-indigo-600 text-white hover:bg-indigo-700 focus:ring-indigo-500 shadow-sm',
        'secondary' => 'bg-gray-600 text-white hover:bg-gray-700 focus:ring-gray-500 shadow-sm',
        'success' => 'bg-emerald-600 text-white hover:bg-emerald-700 focus:ring-emerald-500 shadow-sm',
        'danger' => 'bg-rose-600 text-white hover:bg-rose-700 focus:ring-rose-500 shadow-sm',
        'warning' => 'bg-amber-600 text-white hover:bg-amber-700 focus:ring-amber-500 shadow-sm',
        'outline' => 'border-2 border-gray-300 bg-white text-gray-700 hover:bg-gray-50 focus:ring-gray-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:hover:bg-gray-800',
        'ghost' => 'bg-transparent text-gray-700 hover:bg-gray-100 focus:ring-gray-500 dark:text-gray-300 dark:hover:bg-gray-800',
        default => 'bg-indigo-600 text-white hover:bg-indigo-700 focus:ring-indigo-500 shadow-sm',
    };
    
    $sizeClasses = match($size) {
        'sm' => 'px-3 py-1.5 text-xs rounded-md',
        'md' => 'px-4 py-2 text-sm rounded-lg',
        'lg' => 'px-6 py-3 text-base rounded-lg',
        default => 'px-4 py-2 text-sm rounded-lg',
    };
    
    $classes = "{$baseClasses} {$variantClasses} {$sizeClasses}";
@endphp

<button 
    type="{{ $type }}"
    {{ $attributes->merge(['class' => $classes]) }}
    @if($disabled) disabled @endif
>
    @if($icon)
        <span class="mr-2">
            {!! $icon !!}
        </span>
    @endif
    
    {{ $slot }}
    
    @if($iconRight)
        <span class="ml-2">
            {!! $iconRight !!}
        </span>
    @endif
</button>
