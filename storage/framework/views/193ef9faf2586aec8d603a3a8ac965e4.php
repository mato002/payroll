<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'size' => 'md', // sm, md, lg
    'color' => 'indigo', // indigo, gray, white
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
    'size' => 'md', // sm, md, lg
    'color' => 'indigo', // indigo, gray, white
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $sizeClasses = match($size) {
        'sm' => 'h-4 w-4',
        'md' => 'h-5 w-5',
        'lg' => 'h-8 w-8',
        default => 'h-5 w-5',
    };
    
    $colorClasses = match($color) {
        'indigo' => 'text-indigo-600 dark:text-indigo-400',
        'gray' => 'text-gray-600 dark:text-gray-400',
        'white' => 'text-white',
        default => 'text-indigo-600 dark:text-indigo-400',
    };
?>

<svg 
    class="animate-spin <?php echo e($sizeClasses); ?> <?php echo e($colorClasses); ?>" 
    xmlns="http://www.w3.org/2000/svg" 
    fill="none" 
    viewBox="0 0 24 24"
    <?php echo e($attributes); ?>

>
    <circle 
        class="opacity-25" 
        cx="12" 
        cy="12" 
        r="10" 
        stroke="currentColor" 
        stroke-width="4"
    ></circle>
    <path 
        class="opacity-75" 
        fill="currentColor" 
        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
    ></path>
</svg>
<?php /**PATH C:\xampp\htdocs\payroll-system\resources\views/components/loading-spinner.blade.php ENDPATH**/ ?>