@extends('layouts.layout')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Pension / NSSF Contribution Report</h1>

        <form action="{{ route('companies.reports.pension.generate', ['company' => currentCompany()?->slug]) }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
            @csrf

            <div class="mb-4">
                <label for="period_start" class="block text-sm font-medium text-gray-700 mb-2">
                    Period Start (Optional)
                </label>
                <input type="date" 
                       name="period_start" 
                       id="period_start"
                       value="{{ old('period_start') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('period_start')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="period_end" class="block text-sm font-medium text-gray-700 mb-2">
                    Period End (Optional)
                </label>
                <input type="date" 
                       name="period_end" 
                       id="period_end"
                       value="{{ old('period_end') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('period_end')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="format" class="block text-sm font-medium text-gray-700 mb-2">
                    Export Format
                </label>
                <select name="format" 
                        id="format"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="pdf" {{ old('format', 'pdf') === 'pdf' ? 'selected' : '' }}>PDF</option>
                    <option value="excel" {{ old('format') === 'excel' ? 'selected' : '' }}>Excel</option>
                </select>
            </div>

            <div class="flex gap-4">
                <button type="submit" 
                        class="flex-1 bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Generate Report
                </button>
                <a href="{{ route('companies.reports.index', ['company' => currentCompany()?->slug]) }}" 
                   class="flex-1 bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400 text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
