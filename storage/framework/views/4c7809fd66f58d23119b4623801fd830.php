

<?php $__env->startSection('title', 'Switch Company'); ?>

<?php $__env->startSection('content'); ?>
    <main class="flex-1">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Switch Company</h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Select a company to manage or switch your current company context.
                </p>
            </div>

            <div class="bg-white dark:bg-gray-950 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm">
                <div class="p-6">
                    <?php if(session('success')): ?>
                        <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 dark:bg-emerald-900/20 dark:border-emerald-800 p-4 text-sm text-emerald-700 dark:text-emerald-300" role="alert">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span><?php echo e(session('success')); ?></span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if(session('error')): ?>
                        <div class="mb-6 rounded-xl bg-red-50 border border-red-200 dark:bg-red-900/20 dark:border-red-800 p-4 text-sm text-red-700 dark:text-red-300" role="alert">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                <span><?php echo e(session('error')); ?></span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if($companies->isEmpty()): ?>
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.75 21h16.5M4.5 3.75h15a.75.75 0 01.75.75v11.25H3.75V4.5a.75.75 0 01.75-.75z" />
                            </svg>
                            <h3 class="mt-4 text-sm font-semibold text-gray-900 dark:text-gray-100">No companies found</h3>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">You don't belong to any companies yet.</p>
                            <?php if(Route::has('admin.companies.create')): ?>
                                <div class="mt-6">
                                    <a href="<?php echo e(route('admin.companies.create')); ?>" class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm">
                                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15" />
                                        </svg>
                                        Create a new company
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="space-y-3">
                            <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="border-2 rounded-xl p-5 hover:bg-gray-50 dark:hover:bg-gray-900/50 transition-colors
                                    <?php echo e($currentCompany && $currentCompany->id === $company->id ? 'border-indigo-500 bg-indigo-50 dark:bg-indigo-900/20' : 'border-gray-200 dark:border-gray-700'); ?>">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-3">
                                                <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100"><?php echo e($company->name); ?></h3>
                                                <?php if($company->pivot->is_owner): ?>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300">Owner</span>
                                                <?php endif; ?>
                                            </div>
                                            <?php if($company->legal_name): ?>
                                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400"><?php echo e($company->legal_name); ?></p>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <div class="flex items-center gap-3">
                                            <?php if($currentCompany && $currentCompany->id === $company->id): ?>
                                                <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-semibold bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300">Current</span>
                                                
                                                <?php
                                                    // Try path-based route first, fallback to subdomain
                                                    if (Route::has('companies.company.admin.dashboard.path')) {
                                                        $companyDashboardUrl = route('companies.company.admin.dashboard.path', ['company' => $company->slug]);
                                                    } else {
                                                        $baseDomain = config('tenancy.base_domain', 'app.test');
                                                        $protocol = request()->getScheme();
                                                        $companyDashboardUrl = sprintf('%s://%s.%s/admin/dashboard', $protocol, $company->slug, $baseDomain);
                                                    }
                                                ?>
                                                <a href="<?php echo e($companyDashboardUrl); ?>" 
                                                   class="px-5 py-2.5 rounded-lg text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm transition-colors">
                                                    Go to Dashboard
                                                </a>
                                            <?php else: ?>
                                                <form action="<?php echo e(route('companies.switch.store', $company)); ?>" method="POST" class="inline">
                                                    <?php echo csrf_field(); ?>
                                                    <?php
                                                        // Try path-based route first, fallback to subdomain
                                                        if (Route::has('companies.company.admin.dashboard.path')) {
                                                            $companyDashboardUrl = route('companies.company.admin.dashboard.path', ['company' => $company->slug]);
                                                        } else {
                                                            $baseDomain = config('tenancy.base_domain', 'app.test');
                                                            $protocol = request()->getScheme();
                                                            $companyDashboardUrl = sprintf('%s://%s.%s/admin/dashboard', $protocol, $company->slug, $baseDomain);
                                                        }
                                                    ?>
                                                    <input type="hidden" name="redirect_to" value="<?php echo e(request()->get('redirect_to', $companyDashboardUrl)); ?>">
                                                    <button type="submit" 
                                                        class="px-5 py-2.5 rounded-lg text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm transition-colors">
                                                        Switch
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <?php if($currentCompany): ?>
                            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-800">
                                <form action="<?php echo e(route('companies.switch.clear')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 transition-colors">
                                        Clear company context
                                    </button>
                                </form>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\payroll-system\resources\views/companies/switch.blade.php ENDPATH**/ ?>