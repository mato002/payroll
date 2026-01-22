@props([
    'label' => null,
    'name' => null,
    'id' => null,
    'error' => null,
    'hint' => null,
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'placeholder' => null,
])

@php
    $inputId = $id ?? $name;
    $baseClasses = 'block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm';
    
    if ($error) {
        $baseClasses .= ' border-rose-300 focus:border-rose-500 focus:ring-rose-500 dark:border-rose-600';
    }
    
    if ($disabled) {
        $baseClasses .= ' bg-gray-100 cursor-not-allowed dark:bg-gray-800';
    }
    
    if ($readonly) {
        $baseClasses .= ' bg-gray-50 dark:bg-gray-800';
    }
@endphp

<div class="space-y-1">
    @if($label)
        <label 
            for="{{ $inputId }}"
            class="block text-sm font-medium text-gray-700 dark:text-gray-300"
        >
            {{ $label }}
            @if($required)
                <span class="text-rose-500">*</span>
            @endif
        </label>
    @endif
    
    <select
        @if($name) name="{{ $name }}" @endif
        @if($inputId) id="{{ $inputId }}" @endif
        @if($required) required @endif
        @if($disabled) disabled @endif
        @if($readonly) readonly @endif
        {{ $attributes->merge(['class' => $baseClasses]) }}
    >
        @if($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif
        {{ $slot }}
    </select>
    
    @if($error)
        <p class="text-sm text-rose-600 dark:text-rose-400">
            {{ $error }}
        </p>
    @endif
    
    @if($hint && !$error)
        <p class="text-sm text-gray-500 dark:text-gray-400">
            {{ $hint }}
        </p>
    @endif
</div>
