@extends('layouts.layout')

@section('title', __('Employee Dashboard'))

@section('content')
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                    {{ __('Welcome back, :name', ['name' => $employee->first_name]) }}
                </h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ __('Employee Dashboard') }} · {{ currentCompany()?->name }}
                </p>
            </div>
        </div>

        {{-- Quick Stats --}}
        <div class="grid gap-4 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-800 dark:bg-gray-950">
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400">
                    {{ __('Total Payslips') }}
                </p>
                <p class="mt-2 text-2xl font-semibold text-gray-900 dark:text-gray-100">
                    {{ $totalPayslips }}
                </p>
            </div>

            @if($latestPayslip)
                <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-800 dark:bg-gray-950">
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400">
                        {{ __('Latest Payslip') }}
                    </p>
                    <p class="mt-2 text-sm font-semibold text-gray-900 dark:text-gray-100">
                        {{ format_money($latestPayslip->net_amount ?? 0, currentCompany()?->currency ?? 'USD') }}
                    </p>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        {{ format_localized_date($latestPayslip->issue_date) }}
                    </p>
                </div>
            @endif

            <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-800 dark:bg-gray-950">
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400">
                    {{ __('Unread Notifications') }}
                </p>
                <p class="mt-2 text-2xl font-semibold text-gray-900 dark:text-gray-100">
                    {{ $unreadNotificationsCount }}
                </p>
            </div>

            <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-800 dark:bg-gray-950">
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400">
                    {{ __('Employee Code') }}
                </p>
                <p class="mt-2 text-lg font-semibold text-gray-900 dark:text-gray-100">
                    {{ $employee->employee_code }}
                </p>
            </div>
        </div>

        {{-- Recent Payslips --}}
        <div class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-950">
            <div class="flex items-center justify-between border-b border-gray-100 px-4 py-3 dark:border-gray-800">
                <div>
                    <h2 class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                        {{ __('Recent Payslips') }}
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        {{ __('Your most recent payslips') }}
                    </p>
                </div>
                <a
                    href="{{ route('companies.employee.payslips.index', ['company' => currentCompany()?->slug]) }}"
                    class="text-xs font-medium text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300"
                >
                    {{ __('View all') }}
                </a>
            </div>

            <div class="overflow-x-auto -mx-4 sm:mx-0">
                <div class="inline-block min-w-full align-middle px-4 sm:px-0">
                    <table class="min-w-full divide-y divide-gray-200 text-sm dark:divide-gray-800">
                        <thead class="bg-gray-50 dark:bg-gray-900/40">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 dark:text-gray-400">
                                {{ __('Payslip Number') }}
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 dark:text-gray-400">
                                {{ __('Issue Date') }}
                            </th>
                            <th class="px-4 py-2 text-right text-xs font-semibold text-gray-500 dark:text-gray-400">
                                {{ __('Net Amount') }}
                            </th>
                            <th class="px-4 py-2 text-right text-xs font-semibold text-gray-500 dark:text-gray-400">
                                {{ __('Actions') }}
                            </th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white dark:divide-gray-800 dark:bg-gray-950">
                        @forelse($recentPayslips as $payslip)
                            <tr>
                                <td class="whitespace-nowrap px-4 py-2 align-top">
                                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $payslip->payslip_number }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-4 py-2 align-top text-xs text-gray-700 dark:text-gray-200">
                                    {{ format_localized_date($payslip->issue_date) }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-2 align-top text-right text-xs text-gray-700 dark:text-gray-200">
                                    {{ format_money($payslip->net_amount ?? 0, currentCompany()?->currency ?? 'USD') }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-2 align-top text-right text-xs">
                                    <a
                                        href="{{ route('companies.employee.payslips.download', ['company' => currentCompany()?->slug, 'payslip' => $payslip->id]) }}"
                                        class="inline-flex items-center justify-center rounded-md border border-gray-200 bg-white px-3 py-2 text-xs font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:hover:bg-gray-800 min-h-[36px] min-w-[80px]"
                                    >
                                        {{ __('Download') }}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-4 text-center text-xs text-gray-500 dark:text-gray-400">
                                    {{ __('No payslips found.') }}
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
