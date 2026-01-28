<?php $__env->startSection('title', __('Users & roles')); ?>

<?php $__env->startSection('content'); ?>
    <div class="mx-auto max-w-6xl space-y-6">
        
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    <?php echo e(__('Users & roles')); ?>

                </h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    <?php echo e(__('Manage which users can access :company and what they can do.', ['company' => $company->name])); ?>

                </p>
            </div>

            <div class="flex items-center gap-2">
                <a
                    href="<?php echo e(route('companies.users-roles.create', ['company' => $company->slug])); ?>"
                    class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-950"
                >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 4v16m8-8H4"/>
                    </svg>
                    <?php echo e(__('Add user')); ?>

                </a>
            </div>
        </div>

        <?php if(session('success')): ?>
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 dark:border-emerald-900/50 dark:bg-emerald-950 dark:text-emerald-200">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-950">
            <div class="border-b border-gray-100 px-4 py-3 dark:border-gray-800">
                <h2 class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                    <?php echo e(__('Company users')); ?>

                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm dark:divide-gray-800">
                    <thead class="bg-gray-50 dark:bg-gray-900/40">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                            <?php echo e(__('User')); ?>

                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                            <?php echo e(__('Role')); ?>

                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                            <?php echo e(__('Status')); ?>

                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                            <?php echo e(__('Last login')); ?>

                        </th>
                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                            <?php echo e(__('Actions')); ?>

                        </th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white dark:divide-gray-800 dark:bg-gray-950">
                    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $companyPivot = $user->companies->firstWhere('id', $company->id);
                            $role = $user->roles->first();
                        ?>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/40">
                            <td class="px-4 py-3 align-top">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-9 w-9 items-center justify-center rounded-full bg-indigo-100 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-200">
                                        <span class="text-xs font-semibold">
                                            <?php echo e(strtoupper(Str::substr($user->name ?? $user->email, 0, 2))); ?>

                                        </span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                            <?php echo e($user->name ?? '—'); ?>

                                        </span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">
                                            <?php echo e($user->email); ?>

                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 align-top text-sm text-gray-700 dark:text-gray-200">
                                <?php if($role): ?>
                                    <?php echo e($role->name); ?>

                                <?php else: ?>
                                    <span class="text-xs text-gray-400"><?php echo e(__('No role')); ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-3 align-top text-sm">
                                <?php if($companyPivot && $companyPivot->pivot->status === 'active'): ?>
                                    <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-medium text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-200">
                                        <?php echo e(__('Active')); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-700 dark:bg-gray-900/40 dark:text-gray-300">
                                        <?php echo e(__('Pending / Inactive')); ?>

                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-3 align-top text-sm text-gray-700 dark:text-gray-200">
                                <?php if($user->last_login_at): ?>
                                    <?php echo e($user->last_login_at->diffForHumans()); ?>

                                <?php else: ?>
                                    <span class="text-xs text-gray-400"><?php echo e(__('Never')); ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-3 align-top text-right text-sm">
                                <a
                                    href="<?php echo e(route('companies.users-roles.edit', ['company' => $company->slug, 'user' => $user->id])); ?>"
                                    class="inline-flex items-center rounded-md border border-gray-200 px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-900"
                                >
                                    <?php echo e(__('Edit')); ?>

                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="px-4 py-10 text-center text-sm text-gray-500 dark:text-gray-400">
                                <div class="flex flex-col items-center gap-2">
                                    <svg class="h-10 w-10 text-gray-300 dark:text-gray-700" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952A4.125 4.125 0 0015 15.75m0 3.378v.106A12.318 12.318 0 018.624 21 12.31 12.31 0 012.25 19.234v-.106A6.375 6.375 0 018.624 12.75M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0z"/>
                                    </svg>
                                    <p class="font-medium">
                                        <?php echo e(__('No users yet')); ?>

                                    </p>
                                    <p class="text-xs text-gray-400">
                                        <?php echo e(__('Add your first company admin or payroll officer to get started.')); ?>

                                    </p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if($users->hasPages()): ?>
                <div class="border-t border-gray-100 px-4 py-3 dark:border-gray-800">
                    <?php echo e($users->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('title', __('Users & Roles')); ?>

<?php $__env->startSection('content'); ?>
<div class="flex-1">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white"><?php echo e(__('Users & Roles')); ?></h1>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                    <?php echo e(__('Manage company users and their roles')); ?>

                </p>
            </div>
            <a
                href="<?php echo e(route('companies.users-roles.create', ['company' => currentCompany()?->slug])); ?>"
                class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <?php echo e(__('Add User')); ?>

            </a>
        </div>

        
        <div class="rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="border-b border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-900">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                <?php echo e(__('Name')); ?>

                            </th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                <?php echo e(__('Email')); ?>

                            </th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                <?php echo e(__('Role')); ?>

                            </th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                <?php echo e(__('Status')); ?>

                            </th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                <?php echo e(__('Joined')); ?>

                            </th>
                            <th class="px-6 py-3 text-right text-sm font-semibold text-gray-900 dark:text-white">
                                <?php echo e(__('Actions')); ?>

                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center">
                                        <span class="text-sm font-semibold text-indigo-600 dark:text-indigo-400">
                                            <?php echo e(substr(auth()->user()->name ?? 'U', 0, 1)); ?>

                                        </span>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">
                                        <?php echo e(auth()->user()->name); ?>

                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                <?php echo e(auth()->user()->email); ?>

                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                    <?php echo e(__('Admin')); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-800 dark:bg-green-900/30 dark:text-green-300">
                                    <?php echo e(__('Active')); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                <?php echo e(auth()->user()->created_at?->format('Y-m-d') ?? 'N/A'); ?>

                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a
                                        href="<?php echo e(route('companies.users-roles.edit', ['company' => currentCompany()?->slug, 'user' => auth()->user()->id])); ?>"
                                        class="inline-flex items-center gap-1 rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700"
                                    >
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        <?php echo e(__('Edit')); ?>

                                    </a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            
            <div class="px-6 py-12 text-center">
                <svg class="h-12 w-12 mx-auto text-gray-400 dark:text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0zM6 20a9 9 0 0118 0v2h2v-2c0-4.165-2.224-7.798-5.526-9.79M6.464 4.536A9.978 9.978 0 0115 4c4.418 0 8.27 2.943 9.526 7.21"></path>
                </svg>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    <?php echo e(__('No additional users added yet. Add your first team member to get started.')); ?>

                </p>
            </div>
        </div>

        
        <div class="mt-8 rounded-lg border border-blue-200 bg-blue-50 p-6 dark:border-blue-900/30 dark:bg-blue-900/20">
            <div class="flex gap-3">
                <div class="h-6 w-6 flex-shrink-0 text-blue-600 dark:text-blue-400">
                    <svg fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-blue-900 dark:text-blue-100">
                        <?php echo e(__('User Management')); ?>

                    </h3>
                    <p class="mt-1 text-sm text-blue-800 dark:text-blue-200">
                        <?php echo e(__('Add team members to your company and assign them roles. Admin users can manage payroll and view reports, while regular employees can only view their own payslips.')); ?>

                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('layouts.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\payroll-system\resources\views/company/users-roles/index.blade.php ENDPATH**/ ?>