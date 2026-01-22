@extends('layouts.layout')

@section('title', $salaryStructure->name)

@section('content')
    <div class="mx-auto max-w-5xl px-4 py-6 sm:px-6 lg:px-8">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $salaryStructure->name }}</h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ $salaryStructure->description ?? 'No description provided.' }}
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a
                    href="{{ route('salary-structures.edit', $salaryStructure) }}"
                    class="inline-flex items-center gap-2 rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
                >
                    Edit
                </a>
                <a
                    href="{{ route('salary-structures.index') }}"
                    class="inline-flex items-center gap-2 rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700"
                >
                    Back to List
                </a>
            </div>
        </div>

        {{-- Structure Details --}}
        <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-800 dark:bg-gray-950">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pay Frequency</p>
                <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">
                    {{ ucfirst($salaryStructure->pay_frequency) }}
                </p>
            </div>
            <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-800 dark:bg-gray-950">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Currency</p>
                <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">
                    {{ $salaryStructure->currency }}
                </p>
            </div>
            <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-800 dark:bg-gray-950">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Assigned Employees</p>
                <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">
                    {{ $salaryStructure->employeeAssignments->count() }}
                </p>
            </div>
        </div>

        {{-- Salary Components --}}
        <div class="space-y-6">
            {{-- Base Salary --}}
            @php
                $baseSalary = $salaryStructure->components->where('code', 'basic_salary')->first();
                $allowances = $salaryStructure->components->where('type', 'earning')->where('code', '!=', 'basic_salary');
                $deductions = $salaryStructure->components->where('type', 'deduction');
                
                $totalAllowances = $allowances->sum(function($c) use ($baseSalary) {
                    if ($c->calculation_type === 'fixed') {
                        return $c->amount ?? 0;
                    } elseif ($c->calculation_type === 'percentage_of_basic') {
                        return (($baseSalary->amount ?? 0) * ($c->percentage ?? 0)) / 100;
                    }
                    return 0;
                });
                
                $grossSalary = ($baseSalary->amount ?? 0) + $totalAllowances;
                
                $totalDeductions = $deductions->sum(function($c) use ($baseSalary, $grossSalary) {
                    if ($c->calculation_type === 'fixed') {
                        return $c->amount ?? 0;
                    } elseif ($c->calculation_type === 'percentage_of_basic') {
                        return (($baseSalary->amount ?? 0) * ($c->percentage ?? 0)) / 100;
                    } elseif ($c->calculation_type === 'percentage_of_gross') {
                        return ($grossSalary * ($c->percentage ?? 0)) / 100;
                    }
                    return 0;
                });
                
                $netSalary = $grossSalary - $totalDeductions;
            @endphp

            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-950">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Base Salary</h2>
                <div class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                    {{ $salaryStructure->currency }} {{ number_format($baseSalary->amount ?? 0, 2) }}
                </div>
            </div>

            {{-- Allowances --}}
            @if($allowances->isNotEmpty())
                <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-950">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Allowances</h2>
                    <div class="space-y-3">
                        @foreach($allowances as $allowance)
                            <div class="flex items-center justify-between rounded-md border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-900">
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-gray-100">{{ $allowance->name }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        @if($allowance->calculation_type === 'fixed')
                                            Fixed: {{ $salaryStructure->currency }} {{ number_format($allowance->amount, 2) }}
                                        @else
                                            {{ $allowance->percentage }}% of Basic
                                        @endif
                                        @if($allowance->taxable)
                                            <span class="ml-2 text-xs text-gray-400">(Taxable)</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-semibold text-emerald-600 dark:text-emerald-400">
                                        {{ $salaryStructure->currency }} 
                                        {{ number_format($allowance->calculation_type === 'fixed' ? $allowance->amount : (($baseSalary->amount ?? 0) * $allowance->percentage) / 100, 2) }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4 border-t border-gray-200 pt-4 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <p class="font-semibold text-gray-900 dark:text-gray-100">Total Allowances</p>
                            <p class="text-xl font-bold text-emerald-600 dark:text-emerald-400">
                                {{ $salaryStructure->currency }} {{ number_format($totalAllowances, 2) }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Deductions --}}
            @if($deductions->isNotEmpty())
                <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-950">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Deductions</h2>
                    <div class="space-y-3">
                        @foreach($deductions as $deduction)
                            <div class="flex items-center justify-between rounded-md border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-900">
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-gray-100">{{ $deduction->name }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        @if($deduction->calculation_type === 'fixed')
                                            Fixed: {{ $salaryStructure->currency }} {{ number_format($deduction->amount, 2) }}
                                        @elseif($deduction->calculation_type === 'percentage_of_basic')
                                            {{ $deduction->percentage }}% of Basic
                                        @else
                                            {{ $deduction->percentage }}% of Gross
                                        @endif
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-semibold text-red-600 dark:text-red-400">
                                        {{ $salaryStructure->currency }} 
                                        {{ number_format(
                                            $deduction->calculation_type === 'fixed' 
                                                ? $deduction->amount 
                                                : ($deduction->calculation_type === 'percentage_of_basic' 
                                                    ? (($baseSalary->amount ?? 0) * $deduction->percentage) / 100
                                                    : ($grossSalary * $deduction->percentage) / 100
                                                ), 
                                            2
                                        ) }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4 border-t border-gray-200 pt-4 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <p class="font-semibold text-gray-900 dark:text-gray-100">Total Deductions</p>
                            <p class="text-xl font-bold text-red-600 dark:text-red-400">
                                {{ $salaryStructure->currency }} {{ number_format($totalDeductions, 2) }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Summary --}}
            <div class="rounded-lg border-2 border-indigo-500 bg-gradient-to-r from-indigo-50 to-blue-50 p-6 shadow-lg dark:from-indigo-900/20 dark:to-blue-900/20 dark:border-indigo-400">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Salary Summary</h2>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Base Salary</p>
                        <p class="mt-1 text-2xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $salaryStructure->currency }} {{ number_format($baseSalary->amount ?? 0, 2) }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Allowances</p>
                        <p class="mt-1 text-2xl font-bold text-emerald-600 dark:text-emerald-400">
                            {{ $salaryStructure->currency }} {{ number_format($totalAllowances, 2) }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Deductions</p>
                        <p class="mt-1 text-2xl font-bold text-red-600 dark:text-red-400">
                            {{ $salaryStructure->currency }} {{ number_format($totalDeductions, 2) }}
                        </p>
                    </div>
                    <div class="border-l-2 border-indigo-300 pl-4 dark:border-indigo-600">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Net Salary</p>
                        <p class="mt-1 text-3xl font-bold text-indigo-600 dark:text-indigo-400">
                            {{ $salaryStructure->currency }} {{ number_format($netSalary, 2) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
