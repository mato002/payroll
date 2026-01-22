@props([
    'action' => null,
    'actionLabel' => 'View Subscription',
    'secondaryAction' => null,
    'secondaryActionLabel' => 'Contact Support',
])

<x-empty-state
    :action="$action"
    :action-label="$actionLabel"
    :secondary-action="$secondaryAction"
    :secondary-action-label="$secondaryActionLabel"
    title="No invoices found"
    description="Invoices will appear here once your subscription billing cycle begins. You can view your current subscription details or contact support if you have questions about billing."
>
    <x-slot name="icon">
        <svg class="h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 14.25v-6.75A2.25 2.25 0 0017.25 5.25H6.75A2.25 2.25 0 004.5 7.5v9A2.25 2.25 0 006.75 18.75h6.75" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.5 17.25 18.75 19.5 21 16.5" />
        </svg>
    </x-slot>
</x-empty-state>
