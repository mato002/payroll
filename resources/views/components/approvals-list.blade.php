@props([
    'total' => 0,
    'payrollCount' => 0,
    'payslipCount' => 0,
])

<div class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-950">
    <div class="flex items-center justify-between border-b border-gray-100 px-4 py-3 dark:border-gray-800">
        <div>
            <h2 class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                {{ __('Pending approvals') }}
            </h2>
            <p class="text-xs text-gray-500 dark:text-gray-400">
                {{ __('Items that require your review and approval.') }}
            </p>
        </div>
        <span class="inline-flex items-center rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-medium text-amber-700 dark:bg-amber-900/30 dark:text-amber-300">
            {{ $total }}
        </span>
    </div>

    <div class="divide-y divide-gray-100 dark:divide-gray-800">
        <div class="px-4 py-3 text-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Payroll runs') }}
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        {{ trans_choice(':count run awaiting approval|:count runs awaiting approval', $payrollCount, ['count' => $payrollCount]) }}
                    </p>
                </div>
            </div>
        </div>

        <div class="px-4 py-3 text-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Payslips') }}
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        {{ trans_choice(':count payslip pending release|:count payslips pending release', $payslipCount, ['count' => $payslipCount]) }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

