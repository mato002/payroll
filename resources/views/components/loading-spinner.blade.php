@props([
    'size' => 'md', // sm, md, lg
    'color' => 'indigo', // indigo, gray, white
])

@php
    $sizeClasses = match($size) {
        'sm' => 'h-4 w-4',
        'md' => 'h-5 w-5',
        'lg' => 'h-8 w-8',
        default => 'h-5 w-5',
    };
    
    $colorClasses = match($color) {
        'indigo' => 'text-indigo-600 dark:text-indigo-400',
        'gray' => 'text-gray-600 dark:text-gray-400',
        'white' => 'text-white',
        default => 'text-indigo-600 dark:text-indigo-400',
    };
@endphp

<svg 
    class="animate-spin {{ $sizeClasses }} {{ $colorClasses }}" 
    xmlns="http://www.w3.org/2000/svg" 
    fill="none" 
    viewBox="0 0 24 24"
    {{ $attributes }}
>
    <circle 
        class="opacity-25" 
        cx="12" 
        cy="12" 
        r="10" 
        stroke="currentColor" 
        stroke-width="4"
    ></circle>
    <path 
        class="opacity-75" 
        fill="currentColor" 
        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
    ></path>
</svg>
