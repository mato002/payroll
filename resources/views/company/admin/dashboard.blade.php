@extends('layouts.layout')

@section('title', __('Company Dashboard'))

@section('content')
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                    {{ __('Company dashboard') }}
                </h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ currentCompany()?->name }} · {{ $monthLabel }}
                </p>
            </div>

            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-2">
                @php
                    $companySlug = currentCompany()?->slug;
                    $wizardRoute = $companySlug && Route::has('payroll.runs.path.wizard.create') 
                        ? route('payroll.runs.path.wizard.create', ['company' => $companySlug])
                        : ($companySlug && Route::has('payroll.runs.wizard.create') 
                            ? route('payroll.runs.wizard.create', ['company' => $companySlug])
                            : '#');
                @endphp
                <a
                    href="{{ $wizardRoute }}"
                    class="inline-flex items-center justify-center rounded-md bg-indigo-600 px-4 py-3 sm:py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 min-h-[44px]"
                >
                    {{ __('Run payroll') }}
                </a>
                <button
                    type="button"
                    class="inline-flex items-center justify-center rounded-md border border-gray-200 bg-white px-4 py-3 sm:py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:hover:bg-gray-800 min-h-[44px]"
                >
                    {{ __('Add employee') }}
                </button>
            </div>
        </div>

        {{-- KPI row --}}
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <x-stat-card
                :title="__('Employees')"
                :value="$employeeCount"
                :hint="__('Active employees in this company')"
            />

            @php
                $companyCurrency = currentCompany()?->currency ?? 'USD';
                $monthlyPayrollFormatted = function_exists('format_money') 
                    ? format_money($monthlyPayroll ?? 0, $companyCurrency)
                    : \App\Support\Formatting::money($monthlyPayroll ?? 0, $companyCurrency);
            @endphp
            <x-stat-card
                :title="__('Monthly payroll')"
                :value="$monthlyPayrollFormatted"
                :hint="$monthLabel"
            />

            @php
                /** @var \App\Models\PayrollRun|null $currentRun */
                $currentRun = $runs->first();
            @endphp

            @php
                $payDateFormatted = null;
                if ($currentRun) {
                    $payDateFormatted = function_exists('format_localized_date')
                        ? format_localized_date($currentRun->pay_date)
                        : \App\Support\Formatting::localizedDate($currentRun->pay_date);
                }
            @endphp
            <x-stat-card
                :title="__('Current run status')"
                :value="$currentRun ? ucfirst($currentRun->status) : __('No runs')"
                :hint="$currentRun ? __('Pay date :date', ['date' => $payDateFormatted]) : null"
            />

            <x-stat-card
                :title="__('Pending approvals')"
                :value="$pendingApprovalsTotal"
                :hint="__(':payroll payroll, :payslip payslips', ['payroll' => $pendingPayrollApprovals, 'payslip' => $pendingPayslipApprovals])"
            />
        </div>

        {{-- Main content --}}
        <div class="grid gap-6 lg:grid-cols-3">
            <div class="space-y-6 lg:col-span-2">
                <x-payroll-run-table :runs="$runs" />
            </div>

            <div class="space-y-6">
                <x-approvals-list
                    :total="$pendingApprovalsTotal"
                    :payroll-count="$pendingPayrollApprovals"
                    :payslip-count="$pendingPayslipApprovals"
                />
            </div>
        </div>
    </div>
@endsection

