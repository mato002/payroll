@extends('layouts.layout')

@section('title', 'Create Salary Structure')

@section('content')
    <div class="mx-auto max-w-5xl px-4 py-6 sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Create Salary Structure</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Define the salary components including base salary, allowances, and deductions.
            </p>
        </div>

        <form method="POST" action="{{ route('salary-structures.store') }}" class="space-y-6">
            @csrf

            {{-- Basic Information --}}
            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-950">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Basic Information</h2>
                
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Structure Name <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            required
                            class="w-full rounded-md border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
                            placeholder="e.g., Standard Employee Structure"
                        >
                    </div>

                    <div>
                        <label for="pay_frequency" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Pay Frequency <span class="text-red-500">*</span>
                        </label>
                        <select
                            id="pay_frequency"
                            name="pay_frequency"
                            required
                            class="w-full rounded-md border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
                        >
                            <option value="monthly">Monthly</option>
                            <option value="biweekly">Bi-weekly</option>
                            <option value="weekly">Weekly</option>
                            <option value="daily">Daily</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Description
                    </label>
                    <textarea
                        id="description"
                        name="description"
                        rows="3"
                        class="w-full rounded-md border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
                        placeholder="Optional description of this salary structure"
                    ></textarea>
                </div>
            </div>

            {{-- Salary Structure Form Component --}}
            <x-salary-structure-form :currency="auth()->user()->companies()->first()?->currency ?? 'USD'" />

            {{-- Form Actions --}}
            <div class="flex items-center justify-end gap-3">
                <a
                    href="{{ route('salary-structures.index') }}"
                    class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
                >
                    Cancel
                </a>
                <button
                    type="submit"
                    class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    Create Salary Structure
                </button>
            </div>
        </form>
    </div>
@endsection
