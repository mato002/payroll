@props([
    'for' => null,
    'required' => false,
    'error' => false,
])

@php
    $baseClasses = 'block text-sm font-medium';
    $textClasses = $error 
        ? 'text-rose-600 dark:text-rose-400' 
        : 'text-gray-700 dark:text-gray-300';
    $classes = "{$baseClasses} {$textClasses}";
@endphp

<label 
    @if($for) for="{{ $for }}" @endif
    {{ $attributes->merge(['class' => $classes]) }}
>
    {{ $slot }}
    @if($required)
        <span class="text-rose-500">*</span>
    @endif
</label>
