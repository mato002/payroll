<?php $__env->startSection('title', 'Companies Management'); ?>

<?php $__env->startSection('content'); ?>
    <main class="flex-1">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Companies</h1>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Manage all companies on the platform.
                    </p>
                </div>
                <?php if(Route::has('admin.companies.create')): ?>
                    <a href="<?php echo e(route('admin.companies.create')); ?>"
                       class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        New Company
                    </a>
                <?php endif; ?>
            </div>

            <?php if(session('success')): ?>
                <div class="rounded-xl bg-emerald-50 border border-emerald-200 dark:bg-emerald-900/20 dark:border-emerald-800 p-4 text-sm text-emerald-700 dark:text-emerald-300">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <div class="bg-white dark:bg-gray-950 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
                        <thead class="bg-gray-50 dark:bg-gray-900/40">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Company
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Subscription
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Created
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-950 divide-y divide-gray-200 dark:divide-gray-800">
                            <?php $__empty_1 = true; $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div>
                                                <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                                    <?php echo e($company->name); ?>

                                                </div>
                                                <?php if($company->legal_name): ?>
                                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                                        <?php echo e($company->legal_name); ?>

                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php
                                            $statusColor = $company->is_active 
                                                ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300'
                                                : 'bg-gray-100 text-gray-700 dark:bg-gray-900/40 dark:text-gray-300';
                                        ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($statusColor); ?>">
                                            <?php echo e($company->is_active ? 'Active' : 'Inactive'); ?>

                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        <?php if($company->subscriptions->isNotEmpty()): ?>
                                            <?php
                                                $sub = $company->subscriptions->first();
                                                $subColor = match($sub->status) {
                                                    'active' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300',
                                                    'trial' => 'bg-sky-100 text-sky-700 dark:bg-sky-900/30 dark:text-sky-300',
                                                    'past_due' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300',
                                                    default => 'bg-gray-100 text-gray-700 dark:bg-gray-900/40 dark:text-gray-300',
                                                };
                                            ?>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($subColor); ?>">
                                                <?php echo e(strtoupper($sub->status)); ?>

                                            </span>
                                        <?php else: ?>
                                            <span class="text-gray-400">No subscription</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        <?php echo e($company->created_at->format('M d, Y')); ?>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="#" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.75 21h16.5M4.5 3.75h15a.75.75 0 01.75.75v11.25H3.75V4.5a.75.75 0 01.75-.75z" />
                                        </svg>
                                        <h3 class="mt-2 text-sm font-semibold text-gray-900 dark:text-gray-100">No companies</h3>
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by creating a new company.</p>
                                        <?php if(Route::has('admin.companies.create')): ?>
                                            <div class="mt-6">
                                                <a href="<?php echo e(route('admin.companies.create')); ?>" class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm">
                                                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15" />
                                                    </svg>
                                                    New Company
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php if($companies->hasPages()): ?>
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-800">
                        <?php echo e($companies->links()); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\payroll-system\resources\views/admin/companies/index.blade.php ENDPATH**/ ?>