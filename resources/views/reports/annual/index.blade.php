@extends('layouts.layout')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Annual Payroll Summary Report</h1>

        <form action="{{ route('companies.reports.annual.generate', ['company' => currentCompany()?->slug]) }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
            @csrf

            <div class="mb-4">
                <label for="year" class="block text-sm font-medium text-gray-700 mb-2">
                    Year <span class="text-red-500">*</span>
                </label>
                <input type="number" 
                       name="year" 
                       id="year"
                       min="2000"
                       max="{{ now()->year + 1 }}"
                       value="{{ old('year', now()->year) }}"
                       required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('year')
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
