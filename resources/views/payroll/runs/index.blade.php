@extends('layouts.layout')

@section('title', __('Payroll runs'))

@section('content')
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                    {{ __('Payroll runs') }}
                </h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ currentCompany()?->name }}
                </p>
            </div>

            <div class="flex items-center gap-2">
                @php
                    $wizardCreateRoute = \Route::has('companies.payroll.runs.path.wizard.create')
                        ? 'companies.payroll.runs.path.wizard.create'
                        : 'payroll.runs.wizard.create';
                @endphp
                <a
                    href="{{ route($wizardCreateRoute, ['company' => currentCompany()?->slug]) }}"
                    class="inline-flex items-center justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900"
                >
                    <svg class="-ml-0.5 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>
                    {{ __('Run new payroll') }}
                </a>
            </div>
        </div>

        {{-- Table --}}
        <div class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-950">
            <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
                <h2 class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                    {{ __('Payroll history') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    {{ trans_choice(':count run|:count runs', $runs->total(), ['count' => $runs->total()]) }}
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm dark:divide-gray-800">
                    <thead class="bg-gray-50 dark:bg-gray-900/40">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                            {{ __('Name') }}
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                            {{ __('Period') }}
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                            {{ __('Pay date') }}
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                            {{ __('Employees') }}
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                            {{ __('Status') }}
                        </th>
                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white dark:divide-gray-800 dark:bg-gray-950">
                    @forelse($runs as $run)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/40">
                            <td class="px-4 py-3 align-top">
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $run->name ?? __('Payroll run #:id', ['id' => $run->id]) }}
                                    </span>
                                    <span class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">
                                        {{ $run->created_at?->format('M j, Y H:i') }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-4 py-3 align-top text-sm text-gray-700 dark:text-gray-200">
                                @if($run->period_start_date && $run->period_end_date)
                                    {{ $run->period_start_date->format('M j, Y') }}
                                    <span class="text-gray-400">→</span>
                                    {{ $run->period_end_date->format('M j, Y') }}
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 align-top text-sm text-gray-700 dark:text-gray-200">
                                @if($run->pay_date)
                                    {{ $run->pay_date->format('M j, Y') }}
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 align-top text-sm text-gray-700 dark:text-gray-200">
                                {{ $run->items_count }}
                            </td>
                            <td class="px-4 py-3 align-top">
                                @php
                                    $status = $run->status ?? 'draft';
                                    $statusLabel = ucfirst(str_replace('_', ' ', $status));
                                    $statusClasses = match ($status) {
                                        'draft' => 'bg-gray-100 text-gray-800 dark:bg-gray-900/40 dark:text-gray-200',
                                        'processing' => 'bg-amber-50 text-amber-800 dark:bg-amber-900/30 dark:text-amber-200',
                                        'completed' => 'bg-emerald-50 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-200',
                                        'closed' => 'bg-indigo-50 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-200',
                                        'canceled' => 'bg-rose-50 text-rose-800 dark:bg-rose-900/30 dark:text-rose-200',
                                        default => 'bg-gray-100 text-gray-800 dark:bg-gray-900/40 dark:text-gray-200',
                                    };
                                @endphp
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $statusClasses }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>
                            <td class="px-4 py-3 align-top text-right text-sm">
                                @php
                                    $reviewRoute = \Route::has('companies.payroll.runs.path.review')
                                        ? 'companies.payroll.runs.path.review'
                                        : 'payroll.runs.path.review';
                                @endphp
                                @if(Route::has('payroll.runs.path.review') || Route::has('companies.payroll.runs.path.review'))
                                    <a
                                        href="{{ route('companies.payroll.runs.path.review', ['company' => currentCompany()?->slug, 'run' => $run->id]) }}"
                                        class="inline-flex items-center rounded-md border border-gray-200 px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-900"
                                    >
                                        {{ __('View') }}
                                    </a>
                                @else
                                    <span class="text-xs text-gray-400">{{ __('Coming soon') }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                <div class="flex flex-col items-center gap-2">
                                    <svg class="h-10 w-10 text-gray-300 dark:text-gray-700" fill="none"
                                         viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M19.5 14.25v-6.75A2.25 2.25 0 0017.25 5.25H6.75A2.25 2.25 0 004.5 7.5v9A2.25 2.25 0 006.75 18.75h6.75"/>
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M16.5 17.25 18.75 19.5 21 16.5"/>
                                    </svg>
                                    <p class="font-medium">
                                        {{ __('No payroll runs yet') }}
                                    </p>
                                    <p class="text-xs text-gray-400">
                                        {{ __('Run your first payroll to see it listed here.') }}
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($runs->hasPages())
                <div class="border-t border-gray-100 px-4 py-3 dark:border-gray-800">
                    {{ $runs->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

