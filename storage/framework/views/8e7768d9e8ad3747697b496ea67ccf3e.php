

<?php $__env->startSection('title', 'Create Salary Structure'); ?>

<?php $__env->startSection('content'); ?>
    <div class="mx-auto max-w-5xl px-4 py-6 sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Create Salary Structure</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Define the salary components including base salary, allowances, and deductions.
            </p>
        </div>

        <form method="POST" action="<?php echo e(route('companies.salary-structures.store', ['company' => currentCompany()?->slug])); ?>" class="space-y-6">
            <?php echo csrf_field(); ?>

            
            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-950">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Basic Information</h2>
                
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Structure Name <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            required
                            class="w-full rounded-md border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
                            placeholder="e.g., Standard Employee Structure"
                        >
                    </div>

                    <div>
                        <label for="pay_frequency" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Pay Frequency <span class="text-red-500">*</span>
                        </label>
                        <select
                            id="pay_frequency"
                            name="pay_frequency"
                            required
                            class="w-full rounded-md border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
                        >
                            <option value="monthly">Monthly</option>
                            <option value="biweekly">Bi-weekly</option>
                            <option value="weekly">Weekly</option>
                            <option value="daily">Daily</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Description
                    </label>
                    <textarea
                        id="description"
                        name="description"
                        rows="3"
                        class="w-full rounded-md border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
                        placeholder="Optional description of this salary structure"
                    ></textarea>
                </div>
            </div>

            
            <?php if (isset($component)) { $__componentOriginal417b087978cd8c41bc2146263e4ac6bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal417b087978cd8c41bc2146263e4ac6bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.salary-structure-form','data' => ['currency' => auth()->user()->companies()->first()?->currency ?? 'USD']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('salary-structure-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['currency' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(auth()->user()->companies()->first()?->currency ?? 'USD')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal417b087978cd8c41bc2146263e4ac6bc)): ?>
<?php $attributes = $__attributesOriginal417b087978cd8c41bc2146263e4ac6bc; ?>
<?php unset($__attributesOriginal417b087978cd8c41bc2146263e4ac6bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal417b087978cd8c41bc2146263e4ac6bc)): ?>
<?php $component = $__componentOriginal417b087978cd8c41bc2146263e4ac6bc; ?>
<?php unset($__componentOriginal417b087978cd8c41bc2146263e4ac6bc); ?>
<?php endif; ?>

            
            <div class="flex items-center justify-end gap-3">
                <a
                    href="<?php echo e(route('companies.salary-structures.index', ['company' => currentCompany()?->slug])); ?>"
                    class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
                >
                    Cancel
                </a>
                <button
                    type="submit"
                    class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    Create Salary Structure
                </button>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\payroll-system\resources\views/salary-structures/create.blade.php ENDPATH**/ ?>