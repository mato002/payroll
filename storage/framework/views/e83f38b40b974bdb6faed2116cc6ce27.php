
<div
    x-show="showModal"
    x-cloak
    class="fixed inset-0 z-50 overflow-y-auto"
    x-transition:enter="ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
>
    
    <div
        class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
        @click="closeModal()"
    ></div>

    
    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div
            @click.away="closeModal()"
            x-show="showModal"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all dark:bg-gray-800 sm:my-8 sm:w-full sm:max-w-4xl"
        >
            
            <div class="border-b border-gray-200 bg-gray-50 px-6 py-4 dark:border-gray-700 dark:bg-gray-900">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        <span x-text="editingId ? 'Edit Employee' : 'Add New Employee'"></span>
                    </h3>
                    <button
                        @click="closeModal()"
                        class="rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        <span class="sr-only">Close</span>
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            
            <?php
                $companySlug = $currentCompanySlug ?? currentCompany()?->slug;
            ?>
            <form
                x-bind:action="editingId ? '<?php echo e(url('/companies/' . $companySlug . '/admin/employees')); ?>/' + editingId : '<?php echo e(route('companies.employees.store', ['company' => $companySlug])); ?>'"
                method="POST"
                class="max-h-[calc(100vh-200px)] overflow-y-auto"
            >
                <?php echo csrf_field(); ?>
                <template x-if="editingId">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <div class="px-6 py-4 space-y-6">
                    
                    <div>
                        <h4 class="mb-4 text-sm font-semibold text-gray-900 dark:text-white">Personal Information</h4>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label for="employee_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Employee Code <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="employee_code"
                                    id="employee_code"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm"
                                >
                            </div>
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    First Name <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="first_name"
                                    id="first_name"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm"
                                >
                            </div>
                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Last Name <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="last_name"
                                    id="last_name"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm"
                                >
                            </div>
                            <div>
                                <label for="middle_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Middle Name
                                </label>
                                <input
                                    type="text"
                                    name="middle_name"
                                    id="middle_name"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm"
                                >
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="email"
                                    name="email"
                                    id="email"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm"
                                >
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Phone
                                </label>
                                <input
                                    type="tel"
                                    name="phone"
                                    id="phone"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm"
                                >
                            </div>
                            <div>
                                <label for="date_of_birth" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Date of Birth
                                </label>
                                <input
                                    type="date"
                                    name="date_of_birth"
                                    id="date_of_birth"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm"
                                >
                            </div>
                            <div>
                                <label for="national_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    National ID
                                </label>
                                <input
                                    type="text"
                                    name="national_id"
                                    id="national_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm"
                                >
                            </div>
                        </div>
                    </div>

                    
                    <div>
                        <h4 class="mb-4 text-sm font-semibold text-gray-900 dark:text-white">Employment Information</h4>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label for="hire_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Hire Date <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="date"
                                    name="hire_date"
                                    id="hire_date"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm"
                                >
                            </div>
                            <div>
                                <label for="termination_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Termination Date
                                </label>
                                <input
                                    type="date"
                                    name="termination_date"
                                    id="termination_date"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm"
                                >
                            </div>
                            <div>
                                <label for="employment_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Employment Status <span class="text-red-500">*</span>
                                </label>
                                <select
                                    name="employment_status"
                                    id="employment_status"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm"
                                >
                                    <option value="active">Active</option>
                                    <option value="on_leave">On Leave</option>
                                    <option value="terminated">Terminated</option>
                                    <option value="suspended">Suspended</option>
                                </select>
                            </div>
                            <div>
                                <label for="employment_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Employment Type <span class="text-red-500">*</span>
                                </label>
                                <select
                                    name="employment_type"
                                    id="employment_type"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm"
                                >
                                    <option value="full_time">Full Time</option>
                                    <option value="part_time">Part Time</option>
                                    <option value="contract">Contract</option>
                                    <option value="intern">Intern</option>
                                    <option value="temporary">Temporary</option>
                                </select>
                            </div>
                            <div>
                                <label for="job_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Job Title
                                </label>
                                <input
                                    type="text"
                                    name="job_title"
                                    id="job_title"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm"
                                >
                            </div>
                            <div>
                                <label for="pay_frequency" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Pay Frequency <span class="text-red-500">*</span>
                                </label>
                                <select
                                    name="pay_frequency"
                                    id="pay_frequency"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm"
                                >
                                    <option value="monthly">Monthly</option>
                                    <option value="bi_weekly">Bi-Weekly</option>
                                    <option value="weekly">Weekly</option>
                                </select>
                            </div>
                            <div class="sm:col-span-2">
                                <label for="is_active" class="flex items-center">
                                    <input
                                        type="checkbox"
                                        name="is_active"
                                        id="is_active"
                                        value="1"
                                        checked
                                        class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                    >
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Active Employee</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    
                    <div>
                        <h4 class="mb-4 text-sm font-semibold text-gray-900 dark:text-white">Salary Setup</h4>
                        <div>
                            <label for="salary_structure_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Salary Structure
                            </label>
                            <select
                                name="salary_structure_id"
                                id="salary_structure_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm"
                            >
                                <option value="">Select Salary Structure</option>
                                <?php $__currentLoopData = $salaryStructures ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $structure): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($structure->id); ?>"><?php echo e($structure->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                Assign a salary structure to define earnings, deductions, and contributions for this employee.
                            </p>
                        </div>
                    </div>

                    
                    <div>
                        <h4 class="mb-4 text-sm font-semibold text-gray-900 dark:text-white">Tax & Banking Information</h4>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label for="tax_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Tax Number
                                </label>
                                <input
                                    type="text"
                                    name="tax_number"
                                    id="tax_number"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm"
                                >
                            </div>
                            <div>
                                <label for="social_security_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Social Security Number
                                </label>
                                <input
                                    type="text"
                                    name="social_security_number"
                                    id="social_security_number"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm"
                                >
                            </div>
                            <div>
                                <label for="bank_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Bank Name
                                </label>
                                <input
                                    type="text"
                                    name="bank_name"
                                    id="bank_name"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm"
                                >
                            </div>
                            <div>
                                <label for="bank_account_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Account Number
                                </label>
                                <input
                                    type="text"
                                    name="bank_account_number"
                                    id="bank_account_number"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm"
                                >
                            </div>
                            <div>
                                <label for="bank_branch" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Bank Branch
                                </label>
                                <input
                                    type="text"
                                    name="bank_branch"
                                    id="bank_branch"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm"
                                >
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="border-t border-gray-200 bg-gray-50 px-6 py-4 dark:border-gray-700 dark:bg-gray-900">
                    <div class="flex justify-end gap-3">
                        <button
                            type="button"
                            @click="closeModal()"
                            class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600"
                        >
                            Cancel
                        </button>
                        <button
                            type="submit"
                            class="rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                        >
                            <span x-text="editingId ? 'Update Employee' : 'Create Employee'"></span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
[x-cloak] { display: none !important; }
</style>
<?php /**PATH C:\xampp\htdocs\payroll-system\resources\views/employees/partials/modal.blade.php ENDPATH**/ ?>