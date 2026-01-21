@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Compliance Reports</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Tax Summary Report -->
            <div class="bg-white shadow-md rounded-lg p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center mb-4">
                    <div class="bg-blue-100 rounded-full p-3 mr-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold">Tax Summary</h2>
                </div>
                <p class="text-gray-600 mb-4 text-sm">
                    Generate tax summary reports for employees with total gross pay and tax deductions.
                </p>
                <a href="{{ route('reports.tax.index') }}" 
                   class="inline-block bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors">
                    Generate Report
                </a>
            </div>

            <!-- Pension/NSSF Report -->
            <div class="bg-white shadow-md rounded-lg p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center mb-4">
                    <div class="bg-green-100 rounded-full p-3 mr-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold">Pension / NSSF</h2>
                </div>
                <p class="text-gray-600 mb-4 text-sm">
                    Generate pension and NSSF contribution reports with employee and employer contributions.
                </p>
                <a href="{{ route('reports.pension.index') }}" 
                   class="inline-block bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition-colors">
                    Generate Report
                </a>
            </div>

            <!-- Annual Payroll Summary -->
            <div class="bg-white shadow-md rounded-lg p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center mb-4">
                    <div class="bg-purple-100 rounded-full p-3 mr-4">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold">Annual Summary</h2>
                </div>
                <p class="text-gray-600 mb-4 text-sm">
                    Generate comprehensive annual payroll summaries for financial reporting and compliance.
                </p>
                <a href="{{ route('reports.annual.index') }}" 
                   class="inline-block bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 transition-colors">
                    Generate Report
                </a>
            </div>
        </div>

        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <h3 class="font-semibold text-blue-900 mb-2">Report Features</h3>
            <ul class="list-disc list-inside text-sm text-blue-800 space-y-1">
                <li>Export to PDF or Excel format</li>
                <li>Filter by date range (where applicable)</li>
                <li>Company-wide summaries and employee-level details</li>
                <li>Compliance-ready formatting</li>
            </ul>
        </div>
    </div>
</div>
@endsection
