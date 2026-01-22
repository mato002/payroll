@props([
    'action' => null,
    'actionLabel' => 'Add Your First Employee',
    'secondaryAction' => null,
    'secondaryActionLabel' => 'Import Employees',
])

@php
    $company = currentCompany();
    $companySlug = $company?->slug;
    $defaultAction = $companySlug && Route::has('companies.employees.create') 
        ? route('companies.employees.create', ['company' => $companySlug]) 
        : null;
    $defaultSecondaryAction = $companySlug && Route::has('companies.employees.import.create') 
        ? route('companies.employees.import.create', ['company' => $companySlug]) 
        : null;
@endphp

<x-empty-state
    :action="$action ?? $defaultAction"
    :action-label="$actionLabel"
    :secondary-action="$secondaryAction ?? $defaultSecondaryAction"
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
