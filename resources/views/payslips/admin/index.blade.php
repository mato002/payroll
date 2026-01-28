@extends('layouts.layout')

@section('title', __('Company Payslips'))

@section('content')
<div class="flex-1">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 py-8 space-y-6">
        {{-- Header --}}
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                    {{ __('Payslips') }}
                </h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('View and download payslips generated for this company.') }}
                </p>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-950">
            <div class="border-b border-gray-100 px-4 py-3 dark:border-gray-800">
                <h2 class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                    {{ __('All payslips') }}
                </h2>
            </div>

            @if($payslips->count())
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm dark:divide-gray-800">
                        <thead class="bg-gray-50 dark:bg-gray-900/40">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                    {{ __('Payslip #') }}
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                    {{ __('Employee') }}
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                    {{ __('Issue date') }}
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                    {{ __('Net pay') }}
                                </th>
                                <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                    {{ __('Actions') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white dark:divide-gray-800 dark:bg-gray-950">
                            @foreach($payslips as $payslip)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/40">
                                    <td class="px-4 py-3 align-top font-medium text-gray-900 dark:text-gray-100">
                                        {{ $payslip->payslip_number ?? $payslip->id }}
                                    </td>
                                    <td class="px-4 py-3 align-top text-gray-700 dark:text-gray-200">
                                        {{ $payslip->employee?->full_name ?? $payslip->employee?->name ?? __('Employee') }}
                                    </td>
                                    <td class="px-4 py-3 align-top text-gray-700 dark:text-gray-200">
                                        {{ optional($payslip->issue_date)->format('Y-m-d') ?? '—' }}
                                    </td>
                                    <td class="px-4 py-3 align-top text-gray-900 dark:text-gray-100">
                                        {{ number_format($payslip->net_pay ?? 0, 2) }}
                                    </td>
                                    <td class="px-4 py-3 align-top text-right">
                                        <a
                                            href="{{ route('companies.payslips.download', ['company' => currentCompany()?->slug, 'payslip' => $payslip->id]) }}"
                                            class="inline-flex items-center rounded-md border border-gray-200 px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-900"
                                        >
                                            {{ __('Download PDF') }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($payslips->hasPages())
                    <div class="border-t border-gray-100 px-4 py-3 dark:border-gray-800">
                        {{ $payslips->links() }}
                    </div>
                @endif
            @else
                <div class="px-6 py-12 text-center text-sm text-gray-500 dark:text-gray-400">
                    <div class="flex flex-col items-center gap-3">
                        <svg class="h-10 w-10 text-gray-300 dark:text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-6.75A2.25 2.25 0 0017.25 5.25H6.75A2.25 2.25 0 004.5 7.5v9A2.25 2.25 0 006.75 18.75h6.75" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 17.25 18.75 19.5 21 16.5" />
                        </svg>
                        <p class="font-medium">
                            {{ __('No payslips yet') }}
                        </p>
                        <p class="text-xs text-gray-400">
                            {{ __('Run payroll to generate payslips for your employees.') }}
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

