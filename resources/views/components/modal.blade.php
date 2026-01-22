@props([
    'name' => 'modal',
    'title' => null,
    'size' => 'md', // sm, md, lg, xl, full
    'closeOnBackdrop' => true,
])

@php
    $sizeClasses = match($size) {
        'sm' => 'max-w-md',
        'md' => 'max-w-lg',
        'lg' => 'max-w-2xl',
        'xl' => 'max-w-4xl',
        'full' => 'max-w-7xl',
        default => 'max-w-lg',
    };
@endphp

<div 
    x-data="{ 
        show: false,
        open() { this.show = true; document.body.style.overflow = 'hidden'; },
        close() { this.show = false; document.body.style.overflow = 'auto'; }
    }"
    x-on:open-modal.window="$event.detail === '{{ $name }}' && open()"
    x-on:close-modal.window="$event.detail === '{{ $name }}' && close()"
    x-show="show"
    x-cloak
    class="fixed inset-0 z-50 overflow-y-auto"
    role="dialog"
    aria-modal="true"
    @keydown.escape.window="close()"
>
    {{-- Backdrop --}}
    <div 
        x-show="show"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm"
        @if($closeOnBackdrop) @click="close()" @endif
    ></div>

    {{-- Modal Container --}}
    <div class="flex min-h-full items-center justify-center p-4">
        <div 
            x-show="show"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative w-full {{ $sizeClasses }} transform overflow-hidden rounded-xl border border-gray-200 bg-white shadow-xl dark:border-gray-800 dark:bg-gray-950"
            @click.stop
        >
            {{-- Header --}}
            @if($title || isset($header))
                <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                    <div class="flex-1">
                        @isset($header)
                            {{ $header }}
                        @elseif($title)
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                {{ $title }}
                            </h3>
                        @endisset
                    </div>
                    <button 
                        type="button"
                        @click="close()"
                        class="ml-4 rounded-md p-1 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:hover:bg-gray-800 dark:hover:text-gray-300"
                    >
                        <span class="sr-only">Close</span>
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            @endif

            {{-- Content --}}
            <div class="px-6 py-4">
                {{ $slot }}
            </div>

            {{-- Footer --}}
            @isset($footer)
                <div class="border-t border-gray-200 px-6 py-4 dark:border-gray-800">
                    {{ $footer }}
                </div>
            @endisset
        </div>
    </div>
</div>
