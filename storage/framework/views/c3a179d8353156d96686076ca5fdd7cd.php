<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title',
    'description' => null,
    'action' => null,
    'actionLabel' => null,
    'secondaryAction' => null,
    'secondaryActionLabel' => null,
    'size' => 'md', // sm, md, lg
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
    'description' => null,
    'action' => null,
    'actionLabel' => null,
    'secondaryAction' => null,
    'secondaryActionLabel' => null,
    'size' => 'md', // sm, md, lg
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $titleSize = match($size) {
        'sm' => 'text-base',
        'md' => 'text-lg',
        'lg' => 'text-xl',
        default => 'text-lg',
    };
?>

<div class="flex flex-col items-center justify-center py-12 px-4 text-center">
    <?php if(isset($icon)): ?>
        <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">
            <?php echo e($icon); ?>

        </div>
    <?php endif; ?>

    <h3 class="<?php echo e($titleSize); ?> font-semibold text-gray-900 dark:text-gray-100 mb-2">
        <?php echo e($title); ?>

    </h3>

    <?php if($description): ?>
        <p class="mx-auto max-w-sm text-sm text-gray-500 dark:text-gray-400 mb-6">
            <?php echo e($description); ?>

        </p>
    <?php endif; ?>

    <?php if($action || $secondaryAction): ?>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
            <?php if($action && $actionLabel): ?>
                <a
                    href="<?php echo e($action); ?>"
                    class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    <?php echo e($actionLabel); ?>

                </a>
            <?php endif; ?>

            <?php if($secondaryAction && $secondaryActionLabel): ?>
                <a
                    href="<?php echo e($secondaryAction); ?>"
                    class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
                >
                    <?php echo e($secondaryActionLabel); ?>

                </a>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if(!isset($icon)): ?>
        <?php echo e($slot); ?>

    <?php endif; ?>
</div>
<?php /**PATH C:\xampp\htdocs\payroll-system\resources\views/components/empty-state.blade.php ENDPATH**/ ?>