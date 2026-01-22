@props([
    'title' => 'Something went wrong',
    'message' => 'An error occurred while processing your request. Please try again.',
    'action' => null,
])

<div class="flex flex-col items-center justify-center px-4 py-12 text-center">
    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-rose-100 dark:bg-rose-900/20">
        <svg 
            class="h-6 w-6 text-rose-600 dark:text-rose-400" 
            xmlns="http://www.w3.org/2000/svg" 
            fill="none" 
            viewBox="0 0 24 24" 
            stroke-width="1.5" 
            stroke="currentColor"
        >
            <path 
                stroke-linecap="round" 
                stroke-linejoin="round" 
                d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" 
            />
        </svg>
    </div>
    
    <p class="mt-4 text-sm font-semibold text-gray-900 dark:text-gray-100">
        {{ $title }}
    </p>
    
    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400 max-w-sm">
        {{ $message }}
    </p>
    
    @if($action)
        <div class="mt-4">
            {{ $action }}
        </div>
    @else
        <button
            @click="location.reload()"
            class="mt-4 inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-xs font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
        >
            Try again
        </button>
    @endif
</div>
