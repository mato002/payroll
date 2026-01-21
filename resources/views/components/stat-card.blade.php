@props([
    'title',
    'value',
    'hint' => null,
])

<div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-800 dark:bg-gray-950">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ $title }}</p>
            <p class="mt-1 text-2xl font-semibold text-gray-900 dark:text-gray-100">
                {{ $value }}
            </p>
        </div>
        {{ $icon ?? '' }}
    </div>
    @if($hint)
        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
            {{ $hint }}
        </p>
    @endif
</div>

