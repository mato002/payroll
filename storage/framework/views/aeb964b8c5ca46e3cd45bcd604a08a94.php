

<?php $__env->startSection('title', __('Company Dashboard')); ?>

<?php $__env->startSection('content'); ?>
    <div class="space-y-6">
        
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                    <?php echo e(__('Company dashboard')); ?>

                </h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    <?php echo e(currentCompany()?->name); ?> · <?php echo e($monthLabel); ?>

                </p>
            </div>

            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-2">
                <?php
                    $companySlug = currentCompany()?->slug;
                    $wizardRoute = '#';
                    if ($companySlug) {
                        if (Route::has('companies.payroll.runs.path.wizard.create')) {
                            $wizardRoute = route('companies.payroll.runs.path.wizard.create', ['company' => $companySlug]);
                        } elseif (Route::has('payroll.runs.wizard.create')) {
                            $wizardRoute = route('companies.payroll.runs.path.wizard.create', ['company' => $companySlug]);
                        }
                    }
                ?>
                <a
                    href="<?php echo e($wizardRoute); ?>"
                    class="inline-flex items-center justify-center rounded-md bg-indigo-600 px-4 py-3 sm:py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 min-h-[44px]"
                >
                    <?php echo e(__('Run payroll')); ?>

                </a>
                <button
                    type="button"
                    class="inline-flex items-center justify-center rounded-md border border-gray-200 bg-white px-4 py-3 sm:py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:hover:bg-gray-800 min-h-[44px]"
                >
                    <?php echo e(__('Add employee')); ?>

                </button>
            </div>
        </div>

        
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <?php if (isset($component)) { $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stat-card','data' => ['title' => __('Employees'),'value' => $employeeCount,'hint' => __('Active employees in this company')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Employees')),'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($employeeCount),'hint' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Active employees in this company'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $attributes = $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $component = $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>

            <?php
                $companyCurrency = currentCompany()?->currency ?? 'USD';
                $monthlyPayrollFormatted = function_exists('format_money') 
                    ? format_money($monthlyPayroll ?? 0, $companyCurrency)
                    : \App\Support\Formatting::money($monthlyPayroll ?? 0, $companyCurrency);
            ?>
            <?php if (isset($component)) { $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stat-card','data' => ['title' => __('Monthly payroll'),'value' => $monthlyPayrollFormatted,'hint' => $monthLabel]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Monthly payroll')),'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($monthlyPayrollFormatted),'hint' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($monthLabel)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $attributes = $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $component = $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>

            <?php
                /** @var \App\Models\PayrollRun|null $currentRun */
                $currentRun = $runs->first();
            ?>

            <?php
                $payDateFormatted = null;
                if ($currentRun) {
                    $payDateFormatted = function_exists('format_localized_date')
                        ? format_localized_date($currentRun->pay_date)
                        : \App\Support\Formatting::localizedDate($currentRun->pay_date);
                }
            ?>
            <?php if (isset($component)) { $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stat-card','data' => ['title' => __('Current run status'),'value' => $currentRun ? ucfirst($currentRun->status) : __('No runs'),'hint' => $currentRun ? __('Pay date :date', ['date' => $payDateFormatted]) : null]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Current run status')),'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentRun ? ucfirst($currentRun->status) : __('No runs')),'hint' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentRun ? __('Pay date :date', ['date' => $payDateFormatted]) : null)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $attributes = $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $component = $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stat-card','data' => ['title' => __('Pending approvals'),'value' => $pendingApprovalsTotal,'hint' => __(':payroll payroll, :payslip payslips', ['payroll' => $pendingPayrollApprovals, 'payslip' => $pendingPayslipApprovals])]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Pending approvals')),'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pendingApprovalsTotal),'hint' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__(':payroll payroll, :payslip payslips', ['payroll' => $pendingPayrollApprovals, 'payslip' => $pendingPayslipApprovals]))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $attributes = $__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__attributesOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682)): ?>
<?php $component = $__componentOriginal527fae77f4db36afc8c8b7e9f5f81682; ?>
<?php unset($__componentOriginal527fae77f4db36afc8c8b7e9f5f81682); ?>
<?php endif; ?>
        </div>

        
        <div class="grid gap-6 lg:grid-cols-3">
            <div class="space-y-6 lg:col-span-2">
                <?php if (isset($component)) { $__componentOriginaldb096d806c7c400442c67926eeed90f8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldb096d806c7c400442c67926eeed90f8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.payroll-run-table','data' => ['runs' => $runs]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('payroll-run-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['runs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($runs)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldb096d806c7c400442c67926eeed90f8)): ?>
<?php $attributes = $__attributesOriginaldb096d806c7c400442c67926eeed90f8; ?>
<?php unset($__attributesOriginaldb096d806c7c400442c67926eeed90f8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldb096d806c7c400442c67926eeed90f8)): ?>
<?php $component = $__componentOriginaldb096d806c7c400442c67926eeed90f8; ?>
<?php unset($__componentOriginaldb096d806c7c400442c67926eeed90f8); ?>
<?php endif; ?>
            </div>

            <div class="space-y-6">
                <?php if (isset($component)) { $__componentOriginaleb8e4ac5bec674daefb2cc2ff1661b7f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaleb8e4ac5bec674daefb2cc2ff1661b7f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.approvals-list','data' => ['total' => $pendingApprovalsTotal,'payrollCount' => $pendingPayrollApprovals,'payslipCount' => $pendingPayslipApprovals]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('approvals-list'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['total' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pendingApprovalsTotal),'payroll-count' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pendingPayrollApprovals),'payslip-count' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pendingPayslipApprovals)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaleb8e4ac5bec674daefb2cc2ff1661b7f)): ?>
<?php $attributes = $__attributesOriginaleb8e4ac5bec674daefb2cc2ff1661b7f; ?>
<?php unset($__attributesOriginaleb8e4ac5bec674daefb2cc2ff1661b7f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaleb8e4ac5bec674daefb2cc2ff1661b7f)): ?>
<?php $component = $__componentOriginaleb8e4ac5bec674daefb2cc2ff1661b7f; ?>
<?php unset($__componentOriginaleb8e4ac5bec674daefb2cc2ff1661b7f); ?>
<?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\payroll-system\resources\views/company/admin/dashboard.blade.php ENDPATH**/ ?>