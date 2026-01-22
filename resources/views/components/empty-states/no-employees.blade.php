@props([
    'action' => null,
    'actionLabel' => 'Add Your First Employee',
    'secondaryAction' => null,
    'secondaryActionLabel' => 'Import Employees',
])

<x-empty-state
    :action="$action ?? (Route::has('employees.create') ? route('employees.create', ['company' => request()->route('company')]) : null)"
    :action-label="$actionLabel"
    :secondary-action="$secondaryAction ?? (Route::has('employees.import.create') ? route('employees.import.create', ['company' => request()->route('company')]) : null)"
    :secondary-action-label="$secondaryActionLabel"
    title="No employees yet"
    description="Get started by adding your first employee to the system. You can add employees individually or import them in bulk from a spreadsheet."
>
    <x-slot name="icon">
        <svg class="h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 19.5a7.5 7.5 0 0115 0" />
        </svg>
    </x-slot>
</x-empty-state>
