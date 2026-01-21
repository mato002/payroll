@props([
    'status',
])

@php
    $label = strtoupper($status);
    $classes = match ($status) {
        'draft'      => 'bg-gray-50 text-gray-700 dark:bg-gray-900/40 dark:text-gray-300',
        'processing' => 'bg-sky-50 text-sky-700 dark:bg-sky-900/30 dark:text-sky-300',
        'completed'  => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300',
        'closed'     => 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300',
        'canceled'   => 'bg-rose-50 text-rose-700 dark:bg-rose-900/30 dark:text-rose-300',
        'locked'     => 'bg-amber-50 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300',
        default      => 'bg-gray-50 text-gray-700 dark:bg-gray-900/40 dark:text-gray-300',
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {$classes}"]) }}>
    {{ $label }}
</span>

