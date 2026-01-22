@props([
    'action' => null,
    'actionLabel' => 'Create Payroll Run',
    'secondaryAction' => null,
    'secondaryActionLabel' => 'View Documentation',
])

<x-empty-state
    :action="$action ?? (Route::has('payroll.runs.wizard.create') ? route('payroll.runs.wizard.create', ['company' => request()->route('company')]) : null)"
    :action-label="$actionLabel"
    :secondary-action="$secondaryAction"
    :secondary-action-label="$secondaryActionLabel"
    title="No payroll runs yet"
    description="Create your first payroll run to process employee payments. The payroll wizard will guide you through selecting the pay period, reviewing employees, and calculating payments."
>
    <x-slot name="icon">
        <svg class="h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8.25v7.5m-3-4.5h6m5.25-3.75A2.25 2.25 0 0018 5.25H6A2.25 2.25 0 003.75 7.5v9A2.25 2.25 0 006 18.75h12a2.25 2.25 0 002.25-2.25v-9z" />
        </svg>
    </x-slot>
</x-empty-state>
