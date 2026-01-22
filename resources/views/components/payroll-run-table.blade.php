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

    <div class="overflow-x-auto -mx-4 sm:mx-0">
        <div class="inline-block min-w-full align-middle px-4 sm:px-0">
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
                    @php
                        $formatDate = function($date) {
                            return function_exists('format_localized_date')
                                ? format_localized_date($date)
                                : \App\Support\Formatting::localizedDate($date);
                        };
                        $formatMoney = function($amount, $currency) {
                            return function_exists('format_money')
                                ? format_money($amount, $currency)
                                : \App\Support\Formatting::money($amount, $currency);
                        };
                        $companyCurrency = currentCompany()?->currency ?? 'USD';
                    @endphp
                    <td class="whitespace-nowrap px-4 py-2 align-top text-xs text-gray-700 dark:text-gray-200">
                        {{ $formatDate($run->period_start_date) }}
                        &ndash;
                        {{ $formatDate($run->period_end_date) }}
                    </td>
                    <td class="whitespace-nowrap px-4 py-2 align-top text-xs text-gray-700 dark:text-gray-200">
                        {{ $formatDate($run->pay_date) }}
                    </td>
                    <td class="whitespace-nowrap px-4 py-2 align-top text-right text-xs text-gray-700 dark:text-gray-200">
                        {{ $formatMoney($run->total_net_amount ?? 0, $companyCurrency) }}
                    </td>
                    <td class="whitespace-nowrap px-4 py-2 align-top text-xs">
                        <x-status-pill :status="$run->status" />
                    </td>
                    <td class="whitespace-nowrap px-4 py-2 align-top text-right text-xs">
                        <div class="inline-flex items-center gap-1">
                            @php
                                $company = currentCompany();
                                $currentCompanySlug = $company?->slug;
                                $reviewRoute = null;
                                if ($currentCompanySlug) {
                                    if (Route::has('companies.payroll.runs.path.review')) {
                                        $reviewRoute = route('companies.payroll.runs.path.review', ['company' => $currentCompanySlug, 'run' => $run->id]);
                                    } elseif (Route::has('payroll.runs.review')) {
                                        $reviewRoute = route('companies.payroll.runs.path.review', ['company' => $currentCompanySlug, 'run' => $run->id]);
                                    }
                                }
                            @endphp
                            @if($reviewRoute)
                                <a href="{{ $reviewRoute }}"
                                   class="inline-flex items-center justify-center rounded-md border border-gray-200 bg-white px-3 py-2 text-xs font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:hover:bg-gray-800 min-h-[36px] min-w-[60px]">
                                    {{ __('View') }}
                                </a>
                            @else
                                <span class="inline-flex items-center justify-center rounded-md border border-gray-200 bg-white px-3 py-2 text-xs font-medium text-gray-400 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-500 min-h-[36px] min-w-[60px]">
                                    {{ __('View') }}
                                </span>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-4">
                        <x-empty-states.no-payroll-runs />
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>

