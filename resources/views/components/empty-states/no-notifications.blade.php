@props([
    'action' => null,
    'actionLabel' => 'View Dashboard',
    'description' => null,
])

@php
    $defaultDescription = 'You have no new notifications. We will notify you when there are important updates about your payroll, employees, or account.';
    $finalDescription = $description ?? $defaultDescription;
@endphp

<x-empty-state
    :action="$action"
    :action-label="$actionLabel"
    title="All caught up!"
    :description="$finalDescription"
>
    <x-slot name="icon">
        <svg class="h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
    </x-slot>
</x-empty-state>
