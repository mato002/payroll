@props([
    'variant' => 'info', // info, success, warning, danger
    'dismissible' => false,
    'title' => null,
])

@php
    $baseClasses = 'rounded-xl border p-4';
    
    $variantClasses = match($variant) {
        'info' => 'border-sky-200 bg-sky-50 dark:border-sky-800 dark:bg-sky-900/20',
        'success' => 'border-emerald-200 bg-emerald-50 dark:border-emerald-800 dark:bg-emerald-900/20',
        'warning' => 'border-amber-200 bg-amber-50 dark:border-amber-800 dark:bg-amber-900/20',
        'danger' => 'border-rose-200 bg-rose-50 dark:border-rose-800 dark:bg-rose-900/20',
        default => 'border-sky-200 bg-sky-50 dark:border-sky-800 dark:bg-sky-900/20',
    };
    
    $textClasses = match($variant) {
        'info' => 'text-sky-800 dark:text-sky-200',
        'success' => 'text-emerald-800 dark:text-emerald-200',
        'warning' => 'text-amber-800 dark:text-amber-200',
        'danger' => 'text-rose-800 dark:text-rose-200',
        default => 'text-sky-800 dark:text-sky-200',
    };
    
    $iconClasses = match($variant) {
        'info' => 'text-sky-400',
        'success' => 'text-emerald-400',
        'warning' => 'text-amber-400',
        'danger' => 'text-rose-400',
        default => 'text-sky-400',
    };
    
    $icon = match($variant) {
        'info' => '<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
        'success' => '<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
        'warning' => '<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>',
        'danger' => '<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
        default => '<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
    };
    
    $classes = "{$baseClasses} {$variantClasses}";
@endphp

<div 
    {{ $attributes->merge(['class' => $classes]) }}
    x-data="{ show: true }"
    x-show="show"
    x-transition
    role="alert"
>
    <div class="flex items-start">
        <div class="flex-shrink-0 {{ $iconClasses }}">
            {!! $icon !!}
        </div>
        <div class="ml-3 flex-1">
            @if($title)
                <h3 class="text-sm font-semibold {{ $textClasses }}">
                    {{ $title }}
                </h3>
            @endif
            <div class="{{ $title ? 'mt-1' : '' }} text-sm {{ $textClasses }}">
                {{ $slot }}
            </div>
        </div>
        @if($dismissible)
            <div class="ml-auto pl-3">
                <button 
                    type="button"
                    @click="show = false"
                    class="inline-flex rounded-md p-1.5 {{ $textClasses }} hover:opacity-75 focus:outline-none focus:ring-2 focus:ring-offset-2"
                >
                    <span class="sr-only">Dismiss</span>
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        @endif
    </div>
</div>
