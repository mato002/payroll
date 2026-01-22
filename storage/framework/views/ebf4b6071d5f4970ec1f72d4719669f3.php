<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'action' => null,
    'actionLabel' => 'Add Your First Employee',
    'secondaryAction' => null,
    'secondaryActionLabel' => 'Import Employees',
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
    'action' => null,
    'actionLabel' => 'Add Your First Employee',
    'secondaryAction' => null,
    'secondaryActionLabel' => 'Import Employees',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $company = currentCompany();
    $companySlug = $company?->slug;
    $defaultAction = $companySlug && Route::has('companies.employees.create') 
        ? route('companies.employees.create', ['company' => $companySlug]) 
        : null;
    $defaultSecondaryAction = $companySlug && Route::has('companies.employees.import.create') 
        ? route('companies.employees.import.create', ['company' => $companySlug]) 
        : null;
?>

<?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['action' => $action ?? $defaultAction,'actionLabel' => $actionLabel,'secondaryAction' => $secondaryAction ?? $defaultSecondaryAction,'secondaryActionLabel' => $secondaryActionLabel,'title' => 'No employees yet','description' => 'Get started by adding your first employee to the system. You can add employees individually or import them in bulk from a spreadsheet.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action ?? $defaultAction),'action-label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($actionLabel),'secondary-action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($secondaryAction ?? $defaultSecondaryAction),'secondary-action-label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($secondaryActionLabel),'title' => 'No employees yet','description' => 'Get started by adding your first employee to the system. You can add employees individually or import them in bulk from a spreadsheet.']); ?>
     <?php $__env->slot('icon', null, []); ?> 
        <svg class="h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 19.5a7.5 7.5 0 0115 0" />
        </svg>
     <?php $__env->endSlot(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal074a021b9d42f490272b5eefda63257c)): ?>
<?php $attributes = $__attributesOriginal074a021b9d42f490272b5eefda63257c; ?>
<?php unset($__attributesOriginal074a021b9d42f490272b5eefda63257c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal074a021b9d42f490272b5eefda63257c)): ?>
<?php $component = $__componentOriginal074a021b9d42f490272b5eefda63257c; ?>
<?php unset($__componentOriginal074a021b9d42f490272b5eefda63257c); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\payroll-system\resources\views/components/empty-states/no-employees.blade.php ENDPATH**/ ?>