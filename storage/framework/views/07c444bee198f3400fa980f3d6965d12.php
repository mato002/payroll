<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'runs',
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'runs',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-950">
    <div class="flex items-center justify-between border-b border-gray-100 px-4 py-3 dark:border-gray-800">
        <div>
            <h2 class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                <?php echo e(__('Payroll run history')); ?>

            </h2>
            <p class="text-xs text-gray-500 dark:text-gray-400">
                <?php echo e(__('Recent payroll runs for this company.')); ?>

            </p>
        </div>
    </div>

    <div class="overflow-x-auto -mx-4 sm:mx-0">
        <div class="inline-block min-w-full align-middle px-4 sm:px-0">
            <table class="min-w-full divide-y divide-gray-200 text-sm dark:divide-gray-800">
            <thead class="bg-gray-50 dark:bg-gray-900/40">
            <tr>
                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 dark:text-gray-400">
                    <?php echo e(__('Run')); ?>

                </th>
                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 dark:text-gray-400">
                    <?php echo e(__('Period')); ?>

                </th>
                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 dark:text-gray-400">
                    <?php echo e(__('Pay date')); ?>

                </th>
                <th class="px-4 py-2 text-right text-xs font-semibold text-gray-500 dark:text-gray-400">
                    <?php echo e(__('Total net')); ?>

                </th>
                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 dark:text-gray-400">
                    <?php echo e(__('Status')); ?>

                </th>
                <th class="px-4 py-2 text-right text-xs font-semibold text-gray-500 dark:text-gray-400">
                    <?php echo e(__('Actions')); ?>

                </th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white dark:divide-gray-800 dark:bg-gray-950">
            <?php $__empty_1 = true; $__currentLoopData = $runs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $run): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="whitespace-nowrap px-4 py-2 align-top">
                        <div class="flex flex-col">
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                <?php echo e($run->name); ?>

                            </span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                <?php echo e(ucfirst($run->pay_frequency)); ?>

                            </span>
                        </div>
                    </td>
                    <?php
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
                    ?>
                    <td class="whitespace-nowrap px-4 py-2 align-top text-xs text-gray-700 dark:text-gray-200">
                        <?php echo e($formatDate($run->period_start_date)); ?>

                        &ndash;
                        <?php echo e($formatDate($run->period_end_date)); ?>

                    </td>
                    <td class="whitespace-nowrap px-4 py-2 align-top text-xs text-gray-700 dark:text-gray-200">
                        <?php echo e($formatDate($run->pay_date)); ?>

                    </td>
                    <td class="whitespace-nowrap px-4 py-2 align-top text-right text-xs text-gray-700 dark:text-gray-200">
                        <?php echo e($formatMoney($run->total_net_amount ?? 0, $companyCurrency)); ?>

                    </td>
                    <td class="whitespace-nowrap px-4 py-2 align-top text-xs">
                        <?php if (isset($component)) { $__componentOriginal0f0f6d48f1e3fcafba02703e0b070890 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0f0f6d48f1e3fcafba02703e0b070890 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-pill','data' => ['status' => $run->status]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status-pill'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($run->status)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0f0f6d48f1e3fcafba02703e0b070890)): ?>
<?php $attributes = $__attributesOriginal0f0f6d48f1e3fcafba02703e0b070890; ?>
<?php unset($__attributesOriginal0f0f6d48f1e3fcafba02703e0b070890); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0f0f6d48f1e3fcafba02703e0b070890)): ?>
<?php $component = $__componentOriginal0f0f6d48f1e3fcafba02703e0b070890; ?>
<?php unset($__componentOriginal0f0f6d48f1e3fcafba02703e0b070890); ?>
<?php endif; ?>
                    </td>
                    <td class="whitespace-nowrap px-4 py-2 align-top text-right text-xs">
                        <div class="inline-flex items-center gap-1">
                            <?php
                                $company = currentCompany();
                                $currentCompanySlug = $company?->slug;
                                $reviewRoute = null;
                                if ($currentCompanySlug) {
                                    if (Route::has('companies.payroll.runs.path.review')) {
                                        $reviewRoute = route('companies.payroll.runs.path.review', ['company' => $currentCompanySlug, 'run' => $run->id]);
                                    } elseif (Route::has('payroll.runs.review')) {
                                        $reviewRoute = route('payroll.runs.review', ['company' => $currentCompanySlug, 'run' => $run->id]);
                                    }
                                }
                            ?>
                            <?php if($reviewRoute): ?>
                                <a href="<?php echo e($reviewRoute); ?>"
                                   class="inline-flex items-center justify-center rounded-md border border-gray-200 bg-white px-3 py-2 text-xs font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:hover:bg-gray-800 min-h-[36px] min-w-[60px]">
                                    <?php echo e(__('View')); ?>

                                </a>
                            <?php else: ?>
                                <span class="inline-flex items-center justify-center rounded-md border border-gray-200 bg-white px-3 py-2 text-xs font-medium text-gray-400 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-500 min-h-[36px] min-w-[60px]">
                                    <?php echo e(__('View')); ?>

                                </span>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="px-4 py-4">
                        <?php if (isset($component)) { $__componentOriginal979a5a0839a19b54f0fdd60d58a6e4a9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal979a5a0839a19b54f0fdd60d58a6e4a9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-states.no-payroll-runs','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-states.no-payroll-runs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal979a5a0839a19b54f0fdd60d58a6e4a9)): ?>
<?php $attributes = $__attributesOriginal979a5a0839a19b54f0fdd60d58a6e4a9; ?>
<?php unset($__attributesOriginal979a5a0839a19b54f0fdd60d58a6e4a9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal979a5a0839a19b54f0fdd60d58a6e4a9)): ?>
<?php $component = $__componentOriginal979a5a0839a19b54f0fdd60d58a6e4a9; ?>
<?php unset($__componentOriginal979a5a0839a19b54f0fdd60d58a6e4a9); ?>
<?php endif; ?>
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
        </div>
    </div>
</div>

<?php /**PATH C:\xampp\htdocs\payroll-system\resources\views/components/payroll-run-table.blade.php ENDPATH**/ ?>