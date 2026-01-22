@extends('layouts.layout')

@section('title', 'Review Payroll Run')

@section('content')
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                    Review Payroll Run
                </h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ $run->name }} · {{ format_localized_date($run->period_start_date) }} - {{ format_localized_date($run->period_end_date) }}
                </p>
            </div>
            <div class="flex items-center gap-2">
                <x-status-pill :status="$run->status" />
                <a href="{{ route('company.admin.dashboard', ['company' => $run->company->slug]) }}"
                   class="inline-flex items-center rounded-md border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 dark:hover:bg-gray-700">
                    Back to Dashboard
                </a>
            </div>
        </div>

        {{-- Status Messages --}}
        @if(session('status'))
            <div class="rounded-md bg-green-50 p-4 dark:bg-green-900/20">
                <p class="text-sm font-medium text-green-800 dark:text-green-200">
                    {{ session('status') }}
                </p>
            </div>
        @endif

        @if($errors->any())
            <div class="rounded-md bg-red-50 p-4 dark:bg-red-900/20">
                <ul class="list-disc list-inside text-sm text-red-800 dark:text-red-200">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Payroll Summary Cards --}}
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-800 dark:bg-gray-950">
                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Employees</div>
                <div class="mt-1 text-2xl font-semibold text-gray-900 dark:text-gray-100">
                    {{ $summary['total_employees'] }}
                </div>
            </div>
            <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-800 dark:bg-gray-950">
                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Gross</div>
                <div class="mt-1 text-2xl font-semibold text-gray-900 dark:text-gray-100">
                    {{ format_money($summary['total_gross'], $run->company->currency ?? 'USD') }}
                </div>
            </div>
            <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-800 dark:bg-gray-950">
                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Deductions</div>
                <div class="mt-1 text-2xl font-semibold text-gray-900 dark:text-gray-100">
                    {{ format_money($summary['total_deductions'], $run->company->currency ?? 'USD') }}
                </div>
            </div>
            <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-800 dark:bg-gray-950">
                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Net</div>
                <div class="mt-1 text-2xl font-semibold text-gray-900 dark:text-gray-100">
                    {{ format_money($summary['total_net'], $run->company->currency ?? 'USD') }}
                </div>
            </div>
        </div>

        {{-- Comparison with Previous Run --}}
        @if($previousRun && $differences)
            <div class="rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-950">
                <div class="border-b border-gray-200 px-4 py-3 dark:border-gray-800">
                    <h2 class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                        Comparison with Previous Run
                    </h2>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        {{ $previousRun->name }} ({{ format_localized_date($previousRun->period_end_date) }})
                    </p>
                </div>
                <div class="p-4">
                    <div class="grid gap-4 sm:grid-cols-3">
                        <div>
                            <div class="text-xs font-medium text-gray-500 dark:text-gray-400">Employee Count</div>
                            <div class="mt-1 flex items-baseline gap-2">
                                <span class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $differences['employee_count'] > 0 ? '+' : '' }}{{ $differences['employee_count'] }}
                                </span>
                                @if($differences['employee_count'] != 0)
                                    <span class="text-xs {{ $differences['employee_count'] > 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                        {{ $differences['employee_count'] > 0 ? '↑' : '↓' }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div>
                            <div class="text-xs font-medium text-gray-500 dark:text-gray-400">Gross Amount</div>
                            <div class="mt-1 flex items-baseline gap-2">
                                <span class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $differences['gross_amount'] > 0 ? '+' : '' }}{{ format_money($differences['gross_amount'], $run->company->currency ?? 'USD') }}
                                </span>
                                @if($differences['gross_amount'] != 0)
                                    <span class="text-xs {{ $differences['gross_amount'] > 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                        {{ $differences['gross_amount'] > 0 ? '↑' : '↓' }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div>
                            <div class="text-xs font-medium text-gray-500 dark:text-gray-400">Net Amount</div>
                            <div class="mt-1 flex items-baseline gap-2">
                                <span class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $differences['net_amount'] > 0 ? '+' : '' }}{{ format_money($differences['net_amount'], $run->company->currency ?? 'USD') }}
                                </span>
                                @if($differences['net_amount'] != 0)
                                    <span class="text-xs {{ $differences['net_amount'] > 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                        {{ $differences['net_amount'] > 0 ? '↑' : '↓' }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Payroll Summary Table --}}
        <div class="rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-950">
            <div class="border-b border-gray-200 px-4 py-3 dark:border-gray-800">
                <h2 class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                    Payroll Summary
                </h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm dark:divide-gray-800">
                    <thead class="bg-gray-50 dark:bg-gray-900/40">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400">
                                Employee
                            </th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400">
                                Gross
                            </th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400">
                                Earnings
                            </th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400">
                                Deductions
                            </th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400">
                                Contributions
                            </th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400">
                                Net
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white dark:divide-gray-800 dark:bg-gray-950">
                        @forelse($run->items as $item)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/40">
                                <td class="whitespace-nowrap px-4 py-3">
                                    <div class="flex flex-col">
                                        <span class="font-medium text-gray-900 dark:text-gray-100">
                                            {{ $item->employee->name ?? 'N/A' }}
                                        </span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $item->employee->employee_code ?? 'N/A' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-right text-gray-700 dark:text-gray-200">
                                    {{ format_money((float) $item->gross_amount, $item->currency ?? 'USD') }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-right text-gray-700 dark:text-gray-200">
                                    {{ format_money((float) $item->total_earnings, $item->currency ?? 'USD') }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-right text-red-600 dark:text-red-400">
                                    {{ format_money((float) $item->total_deductions, $item->currency ?? 'USD') }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-right text-gray-700 dark:text-gray-200">
                                    {{ format_money((float) $item->total_contributions, $item->currency ?? 'USD') }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-right font-semibold text-gray-900 dark:text-gray-100">
                                    {{ format_money((float) $item->net_amount, $item->currency ?? 'USD') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                    No payroll items found.
                                </td>
                            </tr>
                        @endforelse
                        {{-- Totals Row --}}
                        @if($run->items->count() > 0)
                            <tr class="border-t-2 border-gray-300 bg-gray-50 font-semibold dark:border-gray-700 dark:bg-gray-900/40">
                                <td class="px-4 py-3 text-gray-900 dark:text-gray-100">Total</td>
                                <td class="px-4 py-3 text-right text-gray-900 dark:text-gray-100">
                                    {{ format_money($summary['total_gross'], $run->company->currency ?? 'USD') }}
                                </td>
                                <td class="px-4 py-3 text-right text-gray-900 dark:text-gray-100">
                                    {{ format_money($summary['total_earnings'], $run->company->currency ?? 'USD') }}
                                </td>
                                <td class="px-4 py-3 text-right text-red-600 dark:text-red-400">
                                    {{ format_money($summary['total_deductions'], $run->company->currency ?? 'USD') }}
                                </td>
                                <td class="px-4 py-3 text-right text-gray-900 dark:text-gray-100">
                                    {{ format_money($summary['total_contributions'], $run->company->currency ?? 'USD') }}
                                </td>
                                <td class="px-4 py-3 text-right text-gray-900 dark:text-gray-100">
                                    {{ format_money($summary['total_net'], $run->company->currency ?? 'USD') }}
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Approval Actions & Comments --}}
        @if($run->isUnderReview())
            <div class="rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-950">
                <div class="border-b border-gray-200 px-4 py-3 dark:border-gray-800">
                    <h2 class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                        Review & Approval
                    </h2>
                </div>
                <div class="p-4 space-y-4">
                    {{-- Comments Section --}}
                    <div>
                        <label for="approval_comments" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                            Approval Comments (Optional)
                        </label>
                        <textarea
                            id="approval_comments"
                            name="approval_comments"
                            rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 sm:text-sm"
                            placeholder="Add any notes or comments about this approval..."
                        ></textarea>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex items-center justify-end gap-3 border-t border-gray-200 pt-4 dark:border-gray-800">
                        @can('approve', $run)
                            {{-- Reject Form --}}
                            <form
                                method="POST"
                                action="{{ route('companies.payroll.runs.path.reject', ['company' => $run->company->slug, 'run' => $run->id]) }}"
                                class="flex-1"
                                x-data="{ showReject: false }"
                            >
                                @csrf
                                <div x-show="showReject" x-cloak class="mb-3">
                                    <label for="rejection_reason" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                                        Rejection Reason <span class="text-red-600">*</span>
                                    </label>
                                    <textarea
                                        id="rejection_reason"
                                        name="rejection_reason"
                                        rows="3"
                                        required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 sm:text-sm"
                                        placeholder="Please provide a reason for rejection..."
                                    ></textarea>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button
                                        type="button"
                                        @click="showReject = !showReject"
                                        class="inline-flex items-center rounded-md border border-red-300 bg-white px-4 py-2 text-sm font-medium text-red-700 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:border-red-700 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-red-900/20"
                                    >
                                        Reject
                                    </button>
                                    <button
                                        type="submit"
                                        x-show="showReject"
                                        x-cloak
                                        class="inline-flex items-center rounded-md bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                                    >
                                        Confirm Rejection
                                    </button>
                                </div>
                            </form>

                            {{-- Approve Form --}}
                            <form
                                method="POST"
                                action="{{ route('companies.payroll.runs.path.approve', ['company' => $run->company->slug, 'run' => $run->id]) }}"
                                class="flex items-center gap-2"
                            >
                                @csrf
                                <input type="hidden" name="approval_comments" id="approval_comments_hidden" value="">
                                <button
                                    type="submit"
                                    onclick="document.getElementById('approval_comments_hidden').value = document.getElementById('approval_comments').value"
                                    class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                >
                                    <svg class="mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                    Approve Payroll
                                </button>
                            </form>
                        @else
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                You do not have permission to approve or reject this payroll run.
                            </p>
                        @endcan
                    </div>
                </div>
            </div>
        @elseif($run->isApproved())
            <div class="rounded-lg border border-green-200 bg-green-50 p-4 dark:border-green-800 dark:bg-green-900/20">
                <div class="flex items-center gap-2">
                    <svg class="h-5 w-5 text-green-600 dark:text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-green-800 dark:text-green-200">
                            This payroll run has been approved.
                        </p>
                        @if($run->approved_at)
                            <p class="mt-1 text-xs text-green-600 dark:text-green-400">
                                Approved on {{ format_localized_date($run->approved_at, 'F d, Y \a\t g:i A') }}
                                @if($run->approvedBy)
                                    by {{ $run->approvedBy->name }}
                                @endif
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        {{-- Run Details --}}
        <div class="rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-950">
            <div class="border-b border-gray-200 px-4 py-3 dark:border-gray-800">
                <h2 class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                    Run Details
                </h2>
            </div>
            <div class="p-4">
                <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Period</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                            {{ format_localized_date($run->period_start_date) }} - {{ format_localized_date($run->period_end_date) }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Pay Date</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                            {{ format_localized_date($run->pay_date) }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Frequency</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                            {{ ucfirst(str_replace('_', ' ', $run->pay_frequency)) }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Status</dt>
                        <dd class="mt-1">
                            <x-status-pill :status="$run->status" />
                        </dd>
                    </div>
                    @if($run->description)
                        <div class="sm:col-span-2">
                            <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Description</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $run->description }}
                            </dd>
                        </div>
                    @endif
                </dl>
            </div>
        </div>
    </div>
@endsection
