

<?php $__env->startSection('title', __('Company Settings')); ?>

<?php $__env->startSection('content'); ?>
<div class="flex-1">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white"><?php echo e(__('Company Settings')); ?></h1>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                <?php echo e(__('Manage your company information and preferences')); ?>

            </p>
        </div>

        <form action="<?php echo e(route('companies.settings.update', ['company' => currentCompany()?->slug])); ?>" method="POST" class="space-y-8">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            
            <div class="rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800 p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-6"><?php echo e(__('Company Information')); ?></h2>
                
                <div class="space-y-6">
                    
                    <div>
                        <label for="company_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <?php echo e(__('Company Name')); ?>

                        </label>
                        <input
                            type="text"
                            id="company_name"
                            name="company_name"
                            value="<?php echo e(currentCompany()?->name ?? ''); ?>"
                            disabled
                            class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2.5 text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm"
                        />
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            <?php echo e(__('Contact support to change company name')); ?>

                        </p>
                    </div>

                    
                    <div>
                        <label for="currency" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <?php echo e(__('Currency')); ?>

                        </label>
                        <select
                            id="currency"
                            name="currency"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >
                            <option value="USD" <?php echo e((currentCompany()?->currency ?? 'USD') === 'USD' ? 'selected' : ''); ?>>USD - US Dollar</option>
                            <option value="EUR" <?php echo e((currentCompany()?->currency ?? 'USD') === 'EUR' ? 'selected' : ''); ?>>EUR - Euro</option>
                            <option value="GBP" <?php echo e((currentCompany()?->currency ?? 'USD') === 'GBP' ? 'selected' : ''); ?>>GBP - British Pound</option>
                            <option value="KES" <?php echo e((currentCompany()?->currency ?? 'USD') === 'KES' ? 'selected' : ''); ?>>KES - Kenyan Shilling</option>
                            <option value="ZAR" <?php echo e((currentCompany()?->currency ?? 'USD') === 'ZAR' ? 'selected' : ''); ?>>ZAR - South African Rand</option>
                            <option value="NGN" <?php echo e((currentCompany()?->currency ?? 'USD') === 'NGN' ? 'selected' : ''); ?>>NGN - Nigerian Naira</option>
                        </select>
                    </div>

                    
                    <div>
                        <label for="tax_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <?php echo e(__('Tax Identification Number (TIN)')); ?>

                        </label>
                        <input
                            type="text"
                            id="tax_id"
                            name="tax_id"
                            placeholder="<?php echo e(__('e.g., A123456789')); ?>"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-900 placeholder-gray-400 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm focus:border-indigo-500 focus:ring-indigo-500"
                        />
                    </div>

                    
                    <div>
                        <label for="registration_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <?php echo e(__('Company Registration Number')); ?>

                        </label>
                        <input
                            type="text"
                            id="registration_number"
                            name="registration_number"
                            placeholder="<?php echo e(__('e.g., REG123456')); ?>"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-900 placeholder-gray-400 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm focus:border-indigo-500 focus:ring-indigo-500"
                        />
                    </div>
                </div>
            </div>

            
            <div class="rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800 p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-6"><?php echo e(__('Payroll Settings')); ?></h2>
                
                <div class="space-y-6">
                    
                    <div>
                        <label for="payment_frequency" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <?php echo e(__('Default Payment Frequency')); ?>

                        </label>
                        <select
                            id="payment_frequency"
                            name="payment_frequency"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >
                            <option value="monthly" selected><?php echo e(__('Monthly')); ?></option>
                            <option value="bi-weekly"><?php echo e(__('Bi-weekly')); ?></option>
                            <option value="weekly"><?php echo e(__('Weekly')); ?></option>
                            <option value="daily"><?php echo e(__('Daily')); ?></option>
                        </select>
                    </div>

                    
                    <div>
                        <label for="payment_method" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <?php echo e(__('Default Payment Method')); ?>

                        </label>
                        <select
                            id="payment_method"
                            name="payment_method"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >
                            <option value="bank_transfer" selected><?php echo e(__('Bank Transfer')); ?></option>
                            <option value="cash"><?php echo e(__('Cash')); ?></option>
                            <option value="check"><?php echo e(__('Check')); ?></option>
                            <option value="mobile_money"><?php echo e(__('Mobile Money')); ?></option>
                        </select>
                    </div>
                </div>
            </div>

            
            <div class="rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800 p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-6"><?php echo e(__('Notification Settings')); ?></h2>
                
                <div class="space-y-4">
                    
                    <div class="flex items-center">
                        <input
                            type="checkbox"
                            id="email_notifications"
                            name="email_notifications"
                            checked
                            class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                        />
                        <label for="email_notifications" class="ml-3 text-sm text-gray-700 dark:text-gray-300">
                            <?php echo e(__('Send email notifications for payroll events')); ?>

                        </label>
                    </div>

                    
                    <div class="flex items-center">
                        <input
                            type="checkbox"
                            id="payslip_notifications"
                            name="payslip_notifications"
                            checked
                            class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                        />
                        <label for="payslip_notifications" class="ml-3 text-sm text-gray-700 dark:text-gray-300">
                            <?php echo e(__('Notify employees when payslips are ready')); ?>

                        </label>
                    </div>
                </div>
            </div>

            
            <div class="flex items-center justify-end gap-3">
                <a
                    href="<?php echo e(route('companies.company.admin.dashboard.path', ['company' => currentCompany()?->slug])); ?>"
                    class="rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700"
                >
                    <?php echo e(__('Cancel')); ?>

                </a>
                <button
                    type="submit"
                    class="rounded-lg bg-indigo-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
                >
                    <?php echo e(__('Save Changes')); ?>

                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\payroll-system\resources\views/company/settings/index.blade.php ENDPATH**/ ?>