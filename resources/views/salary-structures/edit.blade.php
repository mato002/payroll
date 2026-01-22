@extends('layouts.layout')

@section('title', 'Edit Salary Structure')

@section('content')
    <div class="mx-auto max-w-5xl px-4 py-6 sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Edit Salary Structure</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Update the salary components including base salary, allowances, and deductions.
            </p>
        </div>

        <form method="POST" action="{{ route('companies.salary-structures.update', ['company' => currentCompany()?->slug, 'salaryStructure' => $structure]) }}" class="space-y-6">
            @csrf
            @method('PUT')

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
                            value="{{ old('name', $structure->name) }}"
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
                            <option value="monthly" {{ old('pay_frequency', $structure->pay_frequency) === 'monthly' ? 'selected' : '' }}>Monthly</option>
                            <option value="biweekly" {{ old('pay_frequency', $structure->pay_frequency) === 'biweekly' ? 'selected' : '' }}>Bi-weekly</option>
                            <option value="weekly" {{ old('pay_frequency', $structure->pay_frequency) === 'weekly' ? 'selected' : '' }}>Weekly</option>
                            <option value="daily" {{ old('pay_frequency', $structure->pay_frequency) === 'daily' ? 'selected' : '' }}>Daily</option>
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
                    >{{ old('description', $structure->description) }}</textarea>
                </div>
            </div>

            {{-- Salary Structure Form Component --}}
            <x-salary-structure-form :structure="$structure" :currency="$currency" />

            {{-- Form Actions --}}
            <div class="flex items-center justify-end gap-3">
                <a
                    href="{{ route('companies.salary-structures.index', ['company' => currentCompany()?->slug]) }}"
                    class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
                >
                    Cancel
                </a>
                <button
                    type="submit"
                    class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    Update Salary Structure
                </button>
            </div>
        </form>
    </div>
@endsection
