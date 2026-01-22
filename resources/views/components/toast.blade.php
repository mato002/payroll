@props([
    'type' => 'success', // success, error, warning, info
    'message',
    'duration' => 3000,
])

@php
    $typeConfig = match($type) {
        'success' => [
            'bg' => 'bg-emerald-50 dark:bg-emerald-900/20',
            'border' => 'border-emerald-200 dark:border-emerald-800',
            'text' => 'text-emerald-800 dark:text-emerald-200',
            'icon' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
        ],
        'error' => [
            'bg' => 'bg-rose-50 dark:bg-rose-900/20',
            'border' => 'border-rose-200 dark:border-rose-800',
            'text' => 'text-rose-800 dark:text-rose-200',
            'icon' => 'M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z',
        ],
        'warning' => [
            'bg' => 'bg-amber-50 dark:bg-amber-900/20',
            'border' => 'border-amber-200 dark:border-amber-800',
            'text' => 'text-amber-800 dark:text-amber-200',
            'icon' => 'M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z',
        ],
        'info' => [
            'bg' => 'bg-sky-50 dark:bg-sky-900/20',
            'border' => 'border-sky-200 dark:border-sky-800',
            'text' => 'text-sky-800 dark:text-sky-200',
            'icon' => 'M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z',
        ],
        default => [
            'bg' => 'bg-emerald-50 dark:bg-emerald-900/20',
            'border' => 'border-emerald-200 dark:border-emerald-800',
            'text' => 'text-emerald-800 dark:text-emerald-200',
            'icon' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
        ],
    };
@endphp

<div
    x-data="{ show: true }"
    x-init="setTimeout(() => show = false, {{ $duration }})"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-2"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-2"
    class="pointer-events-auto w-full max-w-sm overflow-hidden rounded-lg border {{ $typeConfig['border'] }} {{ $typeConfig['bg'] }} shadow-lg ring-1 ring-black ring-opacity-5"
    role="alert"
    {{ $attributes }}
>
    <div class="p-4">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg 
                    class="h-5 w-5 {{ $typeConfig['text'] }}" 
                    xmlns="http://www.w3.org/2000/svg" 
                    fill="none" 
                    viewBox="0 0 24 24" 
                    stroke-width="1.5" 
                    stroke="currentColor"
                >
                    <path 
                        stroke-linecap="round" 
                        stroke-linejoin="round" 
                        d="{{ $typeConfig['icon'] }}" 
                    />
                </svg>
            </div>
            <div class="ml-3 w-0 flex-1 pt-0.5">
                <p class="text-sm font-medium {{ $typeConfig['text'] }}">
                    {{ $message }}
                </p>
            </div>
            <div class="ml-4 flex flex-shrink-0">
                <button
                    @click="show = false"
                    class="inline-flex rounded-md {{ $typeConfig['text'] }} hover:opacity-75 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-gray-800"
                >
                    <span class="sr-only">Close</span>
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
