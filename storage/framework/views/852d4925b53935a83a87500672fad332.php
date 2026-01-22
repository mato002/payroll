<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'action' => null,
    'actionLabel' => 'Create Payroll Run',
    'secondaryAction' => null,
    'secondaryActionLabel' => 'View Documentation',
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
    'actionLabel' => 'Create Payroll Run',
    'secondaryAction' => null,
    'secondaryActionLabel' => 'View Documentation',
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
    $defaultAction = $companySlug && Route::has('payroll.runs.wizard.create') 
        ? route('companies.payroll.runs.path.wizard.create', ['company' => $companySlug]) 
        : null;
?>

<?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['action' => $action ?? $defaultAction,'actionLabel' => $actionLabel,'secondaryAction' => $secondaryAction,'secondaryActionLabel' => $secondaryActionLabel,'title' => 'No payroll runs yet','description' => 'Create your first payroll run to process employee payments. The payroll wizard will guide you through selecting the pay period, reviewing employees, and calculating payments.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action ?? $defaultAction),'action-label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($actionLabel),'secondary-action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($secondaryAction),'secondary-action-label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($secondaryActionLabel),'title' => 'No payroll runs yet','description' => 'Create your first payroll run to process employee payments. The payroll wizard will guide you through selecting the pay period, reviewing employees, and calculating payments.']); ?>
     <?php $__env->slot('icon', null, []); ?> 
        <svg class="h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8.25v7.5m-3-4.5h6m5.25-3.75A2.25 2.25 0 0018 5.25H6A2.25 2.25 0 003.75 7.5v9A2.25 2.25 0 006 18.75h12a2.25 2.25 0 002.25-2.25v-9z" />
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
<?php /**PATH C:\xampp\htdocs\payroll-system\resources\views/components/empty-states/no-payroll-runs.blade.php ENDPATH**/ ?>