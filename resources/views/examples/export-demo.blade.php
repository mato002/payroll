@extends('layouts.layout')

@section('title', 'Export UX Demo')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Export UX Components Demo</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Examples of export dropdowns, progress indicators, and feedback components.
            </p>
        </div>

        {{-- Export Dropdown Examples --}}
        <div class="space-y-6">
            {{-- Example 1: Full Export Dropdown --}}
            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-950">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Export Dropdown (Full Featured)</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                    Dropdown with multiple format options, progress indicator, and success/error feedback.
                </p>
                <x-export-dropdown 
                    exportUrl="/api/export/employees"
                    :formats="['xlsx' => 'Excel (.xlsx)', 'csv' => 'CSV (.csv)', 'pdf' => 'PDF (.pdf)']"
                    defaultFormat="xlsx"
                    label="Export Employees"
                />
            </div>

            {{-- Example 2: Simple Export Button --}}
            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-950">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Simple Export Button</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                    Single-format export button with loading state and feedback.
                </p>
                <div class="flex items-center gap-3">
                    <x-export-button 
                        exportUrl="/api/export/employees"
                        format="xlsx"
                        label="Export to Excel"
                    />
                    <x-export-button 
                        exportUrl="/api/export/employees"
                        format="csv"
                        label="Export to CSV"
                        size="sm"
                    />
                    <x-export-button 
                        exportUrl="/api/export/employees"
                        format="pdf"
                        label="Export to PDF"
                        size="lg"
                    />
                </div>
            </div>

            {{-- Example 3: In Table Context --}}
            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-950">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Export in Table Context</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                    Export button integrated into a data table header.
                </p>
                <div class="overflow-hidden border border-gray-200 rounded-lg dark:border-gray-700">
                    <div class="bg-gray-50 px-4 py-3 border-b border-gray-200 dark:bg-gray-900 dark:border-gray-700 flex items-center justify-between">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100">Employee List</h3>
                        <x-export-dropdown 
                            exportUrl="/api/export/employees"
                            :formats="['xlsx' => 'Excel', 'csv' => 'CSV']"
                            defaultFormat="xlsx"
                            label="Export"
                        />
                    </div>
                    <div class="p-4">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Table content would go here...</p>
                    </div>
                </div>
            </div>

            {{-- Features Documentation --}}
            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-950">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Features</h2>
                <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                    <li class="flex items-start gap-2">
                        <svg class="h-5 w-5 text-green-500 flex-shrink-0 mt-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                        </svg>
                        <span><strong>Progress Indicators:</strong> Real-time progress bar with status messages during export</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="h-5 w-5 text-green-500 flex-shrink-0 mt-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                        </svg>
                        <span><strong>Success Feedback:</strong> Toast notifications with file size information</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="h-5 w-5 text-green-500 flex-shrink-0 mt-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                        </svg>
                        <span><strong>Error Handling:</strong> Clear error messages for failed exports or large files</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="h-5 w-5 text-green-500 flex-shrink-0 mt-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                        </svg>
                        <span><strong>Large File Support:</strong> Automatic detection and async processing for files > 50MB</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="h-5 w-5 text-green-500 flex-shrink-0 mt-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                        </svg>
                        <span><strong>Cancellation:</strong> Users can cancel exports in progress</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
