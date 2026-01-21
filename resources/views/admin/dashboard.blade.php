@extends('layouts.layout')

@section('title', 'Super Admin Dashboard')

@section('content')
    <main class="flex-1">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 space-y-6">
            {{-- Metrics cards --}}
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-800 dark:bg-gray-950">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Total Companies</p>
                            <p class="mt-1 text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                {{ $summary['total_companies'] }}
                            </p>
                        </div>
                        <div class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600 dark:bg-indigo-900/30">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M3.75 21h16.5M4.5 3.75h15a.75.75 0 01.75.75v11.25H3.75V4.5a.75.75 0 01.75-.75z" />
                            </svg>
                        </div>
                    </div>
                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                        Active: {{ $summary['active_companies'] }}
                    </p>
                </div>

                <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-800 dark:bg-gray-950">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Active Subscriptions</p>
                            <p class="mt-1 text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                {{ $summary['active_subscriptions'] }}
                            </p>
                        </div>
                        <div class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 dark:bg-emerald-900/30">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                        </div>
                    </div>
                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                        Trialing: {{ $summary['trial_subscriptions'] }}
                    </p>
                </div>

                <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-800 dark:bg-gray-950">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400">MRR (approx.)</p>
                            <p class="mt-1 text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                {{ number_format($summary['mrr'], 2) }}
                            </p>
                        </div>
                        <div class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-blue-50 text-blue-600 dark:bg-blue-900/30">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M3.75 18.75l4.5-4.5 3 3 6-6 3 3M3.75 5.25h16.5" />
                            </svg>
                        </div>
                    </div>
                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                        Based on active and trial subscriptions
                    </p>
                </div>

                <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-800 dark:bg-gray-950">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Revenue (this month)</p>
                            <p class="mt-1 text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                {{ number_format($summary['monthly_revenue'], 2) }}
                            </p>
                        </div>
                        <div class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-amber-50 text-amber-600 dark:bg-amber-900/30">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M12 8.25v7.5m-3-4.5h6m8.25.75a9.75 9.75 0 11-19.5 0 9.75 9.75 0 0119.5 0z" />
                            </svg>
                        </div>
                    </div>
                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                        Paid and partially paid invoices
                    </p>
                </div>
            </div>

            {{-- Companies table --}}
            <div class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-950">
                <div class="flex items-center justify-between border-b border-gray-100 px-4 py-3 dark:border-gray-800">
                    <div>
                        <h2 class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                            Recent Companies
                        </h2>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            Last 10 companies created, with subscription status.
                        </p>
                    </div>

                    {{-- Quick actions (global) --}}
                    <div class="flex items-center gap-2">
                        <a href="{{ route('company.signup') }}"
                           class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-indigo-700">
                            + New Company
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm dark:divide-gray-800">
                        <thead class="bg-gray-50 dark:bg-gray-900/40">
                        <tr>
                            <th scope="col" class="px-4 py-2 text-left text-xs font-semibold text-gray-500 dark:text-gray-400">
                                Company
                            </th>
                            <th scope="col" class="px-4 py-2 text-left text-xs font-semibold text-gray-500 dark:text-gray-400">
                                Plan
                            </th>
                            <th scope="col" class="px-4 py-2 text-left text-xs font-semibold text-gray-500 dark:text-gray-400">
                                Subscription
                            </th>
                            <th scope="col" class="px-4 py-2 text-left text-xs font-semibold text-gray-500 dark:text-gray-400">
                                Next billing
                            </th>
                            <th scope="col" class="px-4 py-2 text-left text-xs font-semibold text-gray-500 dark:text-gray-400">
                                Status
                            </th>
                            <th scope="col" class="px-4 py-2 text-right text-xs font-semibold text-gray-500 dark:text-gray-400">
                                Actions
                            </th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white dark:divide-gray-800 dark:bg-gray-950">
                        @forelse($companies as $company)
                            <tr>
                                <td class="whitespace-nowrap px-4 py-2 align-top">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ $company['name'] }}
                                        </span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">
                                            Created {{ $company['created_at']->format('Y-m-d') }}
                                        </span>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-4 py-2 align-top text-xs text-gray-700 dark:text-gray-200">
                                    {{ $company['plan_code'] ?? '—' }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-2 align-top text-xs">
                                    @php
                                        $subStatus = $company['sub_status'] ?? 'none';
                                        $subColor = match ($subStatus) {
                                            'active'   => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300',
                                            'trial'    => 'bg-sky-50 text-sky-700 dark:bg-sky-900/30 dark:text-sky-300',
                                            'past_due' => 'bg-amber-50 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300',
                                            'canceled', 'paused' => 'bg-rose-50 text-rose-700 dark:bg-rose-900/30 dark:text-rose-300',
                                            default    => 'bg-gray-50 text-gray-700 dark:bg-gray-900/40 dark:text-gray-300',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $subColor }}">
                                        {{ strtoupper($subStatus) }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-4 py-2 align-top text-xs text-gray-700 dark:text-gray-200">
                                    {{ optional($company['next_billing'])->toDateString() ?? '—' }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-2 align-top text-xs">
                                    @php
                                        $companyStatus = $company['status'] ?? 'trial';
                                        $companyColor = match ($companyStatus) {
                                            'active'    => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300',
                                            'trial'     => 'bg-sky-50 text-sky-700 dark:bg-sky-900/30 dark:text-sky-300',
                                            'past_due'  => 'bg-amber-50 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300',
                                            'canceled'  => 'bg-rose-50 text-rose-700 dark:bg-rose-900/30 dark:text-rose-300',
                                            'paused'    => 'bg-rose-50 text-rose-700 dark:bg-rose-900/30 dark:text-rose-300',
                                            default     => 'bg-gray-50 text-gray-700 dark:bg-gray-900/40 dark:text-gray-300',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $companyColor }}">
                                        {{ strtoupper($companyStatus) }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-4 py-2 align-top text-right text-xs">
                                    <div class="inline-flex items-center gap-1">
                                        {{-- View --}}
                                        <a href="#"
                                           class="inline-flex items-center rounded-md border border-gray-200 bg-white px-2 py-1 text-xs font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:hover:bg-gray-800">
                                            View
                                        </a>
                                        {{-- Edit --}}
                                        <a href="#"
                                           class="inline-flex items-center rounded-md border border-gray-200 bg-white px-2 py-1 text-xs font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:hover:bg-gray-800">
                                            Edit
                                        </a>
                                        {{-- Suspend --}}
                                        <button type="button"
                                                class="inline-flex items-center rounded-md border border-rose-200 bg-rose-50 px-2 py-1 text-xs font-medium text-rose-700 hover:bg-rose-100 dark:border-rose-800 dark:bg-rose-950 dark:text-rose-300 dark:hover:bg-rose-900">
                                            Suspend
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-4 text-center text-xs text-gray-500 dark:text-gray-400">
                                    No companies found.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection

