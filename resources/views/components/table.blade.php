@props([
    'striped' => false,
    'hover' => true,
])

@php
    $tableClasses = 'min-w-full divide-y divide-gray-200 text-sm dark:divide-gray-800';
    $theadClasses = 'bg-gray-50 dark:bg-gray-900/40';
    $tbodyClasses = 'divide-y divide-gray-100 bg-white dark:divide-gray-800 dark:bg-gray-950';
    
    if ($striped) {
        $tbodyClasses .= ' [&>tr:nth-child(even)]:bg-gray-50 [&>tr:nth-child(even)]:dark:bg-gray-900/20';
    }
    
    if ($hover) {
        $tbodyClasses .= ' [&>tr:hover]:bg-gray-50 [&>tr:hover]:dark:bg-gray-800';
    }
@endphp

<div class="overflow-x-auto rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-950">
    <table {{ $attributes->merge(['class' => $tableClasses]) }}>
        @if(isset($thead))
            <thead class="{{ $theadClasses }}">
                {{ $thead }}
            </thead>
        @endif
        
        @if(isset($tbody))
            <tbody class="{{ $tbodyClasses }}">
                {{ $tbody }}
            </tbody>
        @else
            <tbody class="{{ $tbodyClasses }}">
                {{ $slot }}
            </tbody>
        @endif
        
        @if(isset($tfoot))
            <tfoot class="{{ $theadClasses }}">
                {{ $tfoot }}
            </tfoot>
        @endif
    </table>
</div>
