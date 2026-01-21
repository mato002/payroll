@props([
    'runs',
])

<div class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-950">
    <div class="flex items-center justify-between border-b border-gray-100 px-4 py-3 dark:border-gray-800">
        <div>
            <h2 class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                {{ __('Payroll run history') }}
            </h2>
            <p class="text-xs text-gray-500 dark:text-gray-400">
                {{ __('Recent payroll runs for this company.') }}
            </p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm dark:divide-gray-800">
            <thead class="bg-gray-50 dark:bg-gray-900/40">
            <tr>
                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 dark:text-gray-400">
                    {{ __('Run') }}
                </th>
                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 dark:text-gray-400">
                    {{ __('Period') }}
                </th>
                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 dark:text-gray-400">
                    {{ __('Pay date') }}
                </th>
                <th class="px-4 py-2 text-right text-xs font-semibold text-gray-500 dark:text-gray-400">
                    {{ __('Total net') }}
                </th>
                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 dark:text-gray-400">
                    {{ __('Status') }}
                </th>
                <th class="px-4 py-2 text-right text-xs font-semibold text-gray-500 dark:text-gray-400">
                    {{ __('Actions') }}
                </th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white dark:divide-gray-800 dark:bg-gray-950">
            @forelse($runs as $run)
                <tr>
                    <td class="whitespace-nowrap px-4 py-2 align-top">
                        <div class="flex flex-col">
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                {{ $run->name }}
                            </span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                {{ ucfirst($run->pay_frequency) }}
                            </span>
                        </div>
                    </td>
                    <td class="whitespace-nowrap px-4 py-2 align-top text-xs text-gray-700 dark:text-gray-200">
                        {{ format_localized_date($run->period_start_date) }}
                        &ndash;
                        {{ format_localized_date($run->period_end_date) }}
                    </td>
                    <td class="whitespace-nowrap px-4 py-2 align-top text-xs text-gray-700 dark:text-gray-200">
                        {{ format_localized_date($run->pay_date) }}
                    </td>
                    <td class="whitespace-nowrap px-4 py-2 align-top text-right text-xs text-gray-700 dark:text-gray-200">
                        {{ format_money($run->total_net_amount ?? 0, currentCompany()?->currency ?? 'USD') }}
                    </td>
                    <td class="whitespace-nowrap px-4 py-2 align-top text-xs">
                        <x-status-pill :status="$run->status" />
                    </td>
                    <td class="whitespace-nowrap px-4 py-2 align-top text-right text-xs">
                        <div class="inline-flex items-center gap-1">
                            <a href="#"
                               class="inline-flex items-center rounded-md border border-gray-200 bg-white px-2 py-1 text-xs font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:hover:bg-gray-800">
                                {{ __('View') }}
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-4 text-center text-xs text-gray-500 dark:text-gray-400">
                        {{ __('No payroll runs found.') }}
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

