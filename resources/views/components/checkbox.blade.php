@props([
    'label' => null,
    'name' => null,
    'id' => null,
    'value' => null,
    'checked' => false,
    'error' => null,
    'hint' => null,
    'required' => false,
    'disabled' => false,
])

@php
    $inputId = $id ?? $name ?? uniqid('checkbox_');
    $baseClasses = 'h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700';
    
    if ($error) {
        $baseClasses .= ' border-rose-300 focus:ring-rose-500 dark:border-rose-600';
    }
    
    if ($disabled) {
        $baseClasses .= ' opacity-50 cursor-not-allowed';
    }
@endphp

<div class="space-y-1">
    <div class="flex items-start">
        <input
            type="checkbox"
            @if($name) name="{{ $name }}" @endif
            id="{{ $inputId }}"
            @if($value !== null) value="{{ $value }}" @endif
            @if($checked) checked @endif
            @if($required) required @endif
            @if($disabled) disabled @endif
            {{ $attributes->merge(['class' => $baseClasses]) }}
        />
        
        @if($label)
            <label 
                for="{{ $inputId }}"
                class="ml-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
            >
                {{ $label }}
                @if($required)
                    <span class="text-rose-500">*</span>
                @endif
            </label>
        @endif
    </div>
    
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
