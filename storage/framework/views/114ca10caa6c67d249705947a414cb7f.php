

<?php $__env->startSection('title', 'Employees'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex-1" x-data="employeeManagement()">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Employees</h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Manage your company employees</p>
            </div>
            <div class="flex items-center gap-3">
                <?php
                    $company = currentCompany();
                    $currentCompanySlug = $company?->slug;
                    $exportUrl = $currentCompanySlug ? route('companies.employees.export', ['company' => $currentCompanySlug]) : '#';
                ?>
                <?php if (isset($component)) { $__componentOriginalbbe0c50ca1644acc2de128b41c5b4ecb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbbe0c50ca1644acc2de128b41c5b4ecb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.export-dropdown','data' => ['exportUrl' => $exportUrl,'formats' => ['xlsx' => 'Excel (.xlsx)', 'csv' => 'CSV (.csv)'],'defaultFormat' => 'xlsx','label' => 'Export']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('export-dropdown'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['exportUrl' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($exportUrl),'formats' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['xlsx' => 'Excel (.xlsx)', 'csv' => 'CSV (.csv)']),'defaultFormat' => 'xlsx','label' => 'Export']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbbe0c50ca1644acc2de128b41c5b4ecb)): ?>
<?php $attributes = $__attributesOriginalbbe0c50ca1644acc2de128b41c5b4ecb; ?>
<?php unset($__attributesOriginalbbe0c50ca1644acc2de128b41c5b4ecb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbbe0c50ca1644acc2de128b41c5b4ecb)): ?>
<?php $component = $__componentOriginalbbe0c50ca1644acc2de128b41c5b4ecb; ?>
<?php unset($__componentOriginalbbe0c50ca1644acc2de128b41c5b4ecb); ?>
<?php endif; ?>
                <button
                    @click="openModal()"
                    class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                >
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add Employee
                </button>
            </div>
        </div>

        
        <div class="mb-6 rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <form method="GET" action="<?php echo e(route('companies.employees.index', ['company' => $currentCompanySlug])); ?>" class="space-y-4 md:space-y-0 md:flex md:items-end md:gap-4">
                
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Search
                    </label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input
                            type="text"
                            name="search"
                            id="search"
                            value="<?php echo e(request('search')); ?>"
                            placeholder="Search by name, code, email..."
                            class="block w-full rounded-md border-gray-300 pl-10 pr-3 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm"
                        >
                    </div>
                </div>

                
                <div class="md:w-48">
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Status
                    </label>
                    <select
                        name="status"
                        id="status"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm"
                    >
                        <option value="">All</option>
                        <option value="active" <?php echo e(request('status') === 'active' ? 'selected' : ''); ?>>Active</option>
                        <option value="terminated" <?php echo e(request('status') === 'terminated' ? 'selected' : ''); ?>>Terminated</option>
                    </select>
                </div>

                
                <div class="md:w-48">
                    <label for="employment_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Employment Type
                    </label>
                    <select
                        name="employment_type"
                        id="employment_type"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm"
                    >
                        <option value="">All</option>
                        <?php $__currentLoopData = ['full_time' => 'Full Time', 'part_time' => 'Part Time', 'contract' => 'Contract', 'intern' => 'Intern', 'temporary' => 'Temporary']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($value); ?>" <?php echo e(request('employment_type') === $value ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                
                <div class="flex gap-2">
                    <button
                        type="submit"
                        class="inline-flex items-center rounded-md bg-gray-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
                    >
                        Filter
                    </button>
                    <a
                        href="<?php echo e(route('companies.employees.index', ['company' => $currentCompanySlug])); ?>"
                        class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600"
                    >
                        Clear
                    </a>
                </div>
            </form>
        </div>

        
        <?php if(session('success')): ?>
            <div class="mb-4 rounded-lg bg-green-50 border border-green-200 p-4 text-green-800 dark:bg-green-900/20 dark:border-green-800 dark:text-green-200">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        
        <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow dark:border-gray-700 dark:bg-gray-800">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Employee
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Code
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Job Title
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Type
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Hire Date
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                        <?php $__empty_1 = true; $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0">
                                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 text-blue-600 dark:bg-blue-900 dark:text-blue-300">
                                                <span class="text-sm font-medium">
                                                    <?php echo e(strtoupper(substr($employee->first_name, 0, 1) . substr($employee->last_name, 0, 1))); ?>

                                                </span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                <?php echo e($employee->first_name); ?> <?php echo e($employee->last_name); ?>

                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400"><?php echo e($employee->email); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-white">
                                    <?php echo e($employee->employee_code); ?>

                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                    <?php echo e($employee->job_title ?? 'N/A'); ?>

                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <?php if($employee->is_active && !$employee->termination_date): ?>
                                        <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-200">
                                            Active
                                        </span>
                                    <?php elseif($employee->termination_date): ?>
                                        <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800 dark:bg-red-900 dark:text-red-200">
                                            Terminated
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                            Inactive
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                    <?php echo e(ucfirst(str_replace('_', ' ', $employee->employment_type ?? 'N/A'))); ?>

                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                    <?php echo e($employee->hire_date?->format('M d, Y') ?? 'N/A'); ?>

                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2">
                                        <button
                                            @click="openModal(<?php echo e($employee->id); ?>)"
                                            class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300"
                                            title="Edit"
                                        >
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                        <a
                                            href="<?php echo e(route('companies.employees.show', ['company' => $currentCompanySlug, 'employee' => $employee])); ?>"
                                            class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-300"
                                            title="View"
                                        >
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="px-6 py-12">
                                    <?php if (isset($component)) { $__componentOriginal9f4481251648eaf1b7166a462db62b8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f4481251648eaf1b7166a462db62b8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-states.no-employees','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-states.no-employees'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9f4481251648eaf1b7166a462db62b8e)): ?>
<?php $attributes = $__attributesOriginal9f4481251648eaf1b7166a462db62b8e; ?>
<?php unset($__attributesOriginal9f4481251648eaf1b7166a462db62b8e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9f4481251648eaf1b7166a462db62b8e)): ?>
<?php $component = $__componentOriginal9f4481251648eaf1b7166a462db62b8e; ?>
<?php unset($__componentOriginal9f4481251648eaf1b7166a462db62b8e); ?>
<?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            
            <?php if($employees->hasPages()): ?>
                <div class="border-t border-gray-200 bg-white px-4 py-3 dark:border-gray-700 dark:bg-gray-800 sm:px-6">
                    <?php echo e($employees->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>

    
    <?php echo $__env->make('employees.partials.modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
function employeeManagement() {
    return {
        showModal: false,
        editingId: null,
        loading: false,

        openModal(employeeId = null) {
            this.editingId = employeeId;
            this.showModal = true;
            if (employeeId) {
                this.loadEmployee(employeeId);
            }
        },

        closeModal() {
            this.showModal = false;
            this.editingId = null;
        },

        async loadEmployee(id) {
            this.loading = true;
            try {
                const response = await fetch(`<?php echo e(url('/admin/employees')); ?>/${id}/get`);
                const employee = await response.json();
                // Populate form with employee data
                Object.keys(employee).forEach(key => {
                    const input = document.querySelector(`[name="${key}"]`);
                    if (input) {
                        if (input.type === 'checkbox') {
                            input.checked = employee[key] == 1 || employee[key] === true;
                        } else {
                            input.value = employee[key] || '';
                        }
                    }
                });
            } catch (error) {
                console.error('Error loading employee:', error);
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\payroll-system\resources\views/employees/index.blade.php ENDPATH**/ ?>