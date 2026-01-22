<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'total' => 0,
    'payrollCount' => 0,
    'payslipCount' => 0,
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
    'total' => 0,
    'payrollCount' => 0,
    'payslipCount' => 0,
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
                <?php echo e(__('Pending approvals')); ?>

            </h2>
            <p class="text-xs text-gray-500 dark:text-gray-400">
                <?php echo e(__('Items that require your review and approval.')); ?>

            </p>
        </div>
        <span class="inline-flex items-center rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-medium text-amber-700 dark:bg-amber-900/30 dark:text-amber-300">
            <?php echo e($total); ?>

        </span>
    </div>

    <?php if($total > 0): ?>
        <div class="divide-y divide-gray-100 dark:divide-gray-800">
            <div class="px-4 py-3 text-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-medium text-gray-900 dark:text-gray-100">
                            <?php echo e(__('Payroll runs')); ?>

                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            <?php echo e(trans_choice(':count run awaiting approval|:count runs awaiting approval', $payrollCount, ['count' => $payrollCount])); ?>

                        </p>
                    </div>
                </div>
            </div>

            <div class="px-4 py-3 text-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-medium text-gray-900 dark:text-gray-100">
                            <?php echo e(__('Payslips')); ?>

                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            <?php echo e(trans_choice(':count payslip pending release|:count payslips pending release', $payslipCount, ['count' => $payslipCount])); ?>

                        </p>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="px-4 py-6">
            <?php if (isset($component)) { $__componentOriginal3f20510054e748ca321958c9b6245fd7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3f20510054e748ca321958c9b6245fd7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-states.no-notifications','data' => ['description' => 'No pending approvals. All payroll runs and payslips are up to date.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-states.no-notifications'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['description' => 'No pending approvals. All payroll runs and payslips are up to date.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3f20510054e748ca321958c9b6245fd7)): ?>
<?php $attributes = $__attributesOriginal3f20510054e748ca321958c9b6245fd7; ?>
<?php unset($__attributesOriginal3f20510054e748ca321958c9b6245fd7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3f20510054e748ca321958c9b6245fd7)): ?>
<?php $component = $__componentOriginal3f20510054e748ca321958c9b6245fd7; ?>
<?php unset($__componentOriginal3f20510054e748ca321958c9b6245fd7); ?>
<?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<?php /**PATH C:\xampp\htdocs\payroll-system\resources\views/components/approvals-list.blade.php ENDPATH**/ ?>