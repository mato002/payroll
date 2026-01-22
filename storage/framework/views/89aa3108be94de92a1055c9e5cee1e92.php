<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title',
    'value',
    'hint' => null,
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
    'title',
    'value',
    'hint' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-800 dark:bg-gray-950">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-xs font-medium text-gray-500 dark:text-gray-400"><?php echo e($title); ?></p>
            <p class="mt-1 text-2xl font-semibold text-gray-900 dark:text-gray-100">
                <?php echo e($value); ?>

            </p>
        </div>
        <?php echo e($icon ?? ''); ?>

    </div>
    <?php if($hint): ?>
        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
            <?php echo e($hint); ?>

        </p>
    <?php endif; ?>
</div>

<?php /**PATH C:\xampp\htdocs\payroll-system\resources\views/components/stat-card.blade.php ENDPATH**/ ?>