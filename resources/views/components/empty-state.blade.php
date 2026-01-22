@props([
    'title',
    'description' => null,
    'action' => null,
    'actionLabel' => null,
    'secondaryAction' => null,
    'secondaryActionLabel' => null,
    'size' => 'md', // sm, md, lg
])

@php
    $titleSize = match($size) {
        'sm' => 'text-base',
        'md' => 'text-lg',
        'lg' => 'text-xl',
        default => 'text-lg',
    };
@endphp

<div class="flex flex-col items-center justify-center py-12 px-4 text-center">
    @isset($icon)
        <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">
            {{ $icon }}
        </div>
    @endisset

    <h3 class="{{ $titleSize }} font-semibold text-gray-900 dark:text-gray-100 mb-2">
        {{ $title }}
    </h3>

    @if($description)
        <p class="mx-auto max-w-sm text-sm text-gray-500 dark:text-gray-400 mb-6">
            {{ $description }}
        </p>
    @endif

    @if($action || $secondaryAction)
        <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
            @if($action && $actionLabel)
                <a
                    href="{{ $action }}"
                    class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    {{ $actionLabel }}
                </a>
            @endif

            @if($secondaryAction && $secondaryActionLabel)
                <a
                    href="{{ $secondaryAction }}"
                    class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
                >
                    {{ $secondaryActionLabel }}
                </a>
            @endif
        </div>
    @endif

    @if(!isset($icon))
        {{ $slot }}
    @endif
</div>
