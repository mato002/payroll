

<?php $__env->startSection('title', 'Subscription Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex-1">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Subscription Management</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Manage your subscription plan and billing</p>
        </div>

        
        <?php if($currentSubscription): ?>
        <div class="mb-8 rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-950">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-4">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Current Plan</h2>
                        <?php
                            $statusColor = match($currentSubscription->status) {
                                'active' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300',
                                'trial' => 'bg-sky-50 text-sky-700 dark:bg-sky-900/30 dark:text-sky-300',
                                'past_due' => 'bg-amber-50 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300',
                                'canceled', 'paused' => 'bg-rose-50 text-rose-700 dark:bg-rose-900/30 dark:text-rose-300',
                                default => 'bg-gray-50 text-gray-700 dark:bg-gray-900/40 dark:text-gray-300',
                            };
                        ?>
                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium <?php echo e($statusColor); ?>">
                            <?php echo e(strtoupper($currentSubscription->status)); ?>

                        </span>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Plan Name</p>
                            <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">
                                <?php echo e($currentSubscription->plan->name ?? $currentSubscription->plan_code); ?>

                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Billing Cycle</p>
                            <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">
                                <?php echo e(ucfirst($currentSubscription->billing_cycle ?? 'monthly')); ?>

                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Next Billing Date</p>
                            <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">
                                <?php echo e($currentSubscription->next_billing_date?->format('M d, Y') ?? 'N/A'); ?>

                            </p>
                        </div>
                    </div>

                    <?php if($currentSubscription->isOnTrial() && $currentSubscription->trial_end_date): ?>
                    <div class="mt-4 rounded-lg bg-sky-50 border border-sky-200 p-4 dark:bg-sky-900/20 dark:border-sky-800">
                        <p class="text-sm text-sky-800 dark:text-sky-200">
                            <strong>Trial ends:</strong> <?php echo e($currentSubscription->trial_end_date->format('M d, Y')); ?>

                            (<?php echo e($currentSubscription->trial_end_date->diffForHumans()); ?>)
                        </p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        
        <?php if($recentPayments->count() > 0): ?>
        <div class="mb-8 rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-950">
            <div class="border-b border-gray-100 px-6 py-4 dark:border-gray-800">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Recent Payments</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm dark:divide-gray-800">
                    <thead class="bg-gray-50 dark:bg-gray-900/40">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400">Method</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400">Invoice</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white dark:divide-gray-800 dark:bg-gray-950">
                        <?php $__currentLoopData = $recentPayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="whitespace-nowrap px-6 py-4 text-gray-900 dark:text-gray-100">
                                <?php echo e($payment->payment_date->format('M d, Y')); ?>

                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-gray-900 dark:text-gray-100">
                                <?php echo e($payment->currency); ?> <?php echo e(number_format($payment->amount, 2)); ?>

                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-gray-700 dark:text-gray-300">
                                <?php echo e(ucfirst(str_replace('_', ' ', $payment->payment_method ?? 'N/A'))); ?>

                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <?php
                                    $paymentStatusColor = match($payment->status) {
                                        'completed' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300',
                                        'pending' => 'bg-amber-50 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300',
                                        'failed' => 'bg-rose-50 text-rose-700 dark:bg-rose-900/30 dark:text-rose-300',
                                        'refunded' => 'bg-gray-50 text-gray-700 dark:bg-gray-900/40 dark:text-gray-300',
                                        default => 'bg-gray-50 text-gray-700 dark:bg-gray-900/40 dark:text-gray-300',
                                    };
                                ?>
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium <?php echo e($paymentStatusColor); ?>">
                                    <?php echo e(strtoupper($payment->status)); ?>

                                </span>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <?php if($payment->invoice): ?>
                                <a href="<?php echo e(route('companies.subscriptions.invoices.download', ['company' => currentCompany()?->slug, 'invoice' => $payment->invoice])); ?>" 
                                   class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">
                                    <?php echo e($payment->invoice->invoice_number); ?>

                                </a>
                                <?php else: ?>
                                <span class="text-gray-400">—</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>

        
        <div class="mb-8">
            <div class="mb-4">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Available Plans</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Choose a plan that fits your needs</p>
            </div>
            
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                <?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $isCurrentPlan = $currentSubscription && $currentSubscription->plan_code === $plan->code;
                    $isUpgrade = $currentSubscription && $plan->base_price > $currentSubscription->base_price;
                    $isDowngrade = $currentSubscription && $plan->base_price < $currentSubscription->base_price;
                ?>
                <div class="relative rounded-xl border-2 <?php echo e($isCurrentPlan ? 'border-indigo-500 bg-indigo-50 dark:bg-indigo-900/20' : 'border-gray-200 dark:border-gray-800'); ?> bg-white p-6 shadow-sm dark:bg-gray-950">
                    <?php if($isCurrentPlan): ?>
                    <div class="absolute top-4 right-4">
                        <span class="inline-flex items-center rounded-full bg-indigo-600 px-3 py-1 text-xs font-medium text-white">
                            Current Plan
                        </span>
                    </div>
                    <?php endif; ?>
                    
                    <div class="mb-4">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100"><?php echo e($plan->name); ?></h3>
                        <div class="mt-2 flex items-baseline">
                            <span class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                                <?php echo e($plan->currency ?? 'USD'); ?> <?php echo e(number_format($plan->base_price, 2)); ?>

                            </span>
                            <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">
                                /<?php echo e($plan->billing_model === 'monthly' ? 'month' : 'year'); ?>

                            </span>
                        </div>
                        <?php if($plan->price_per_employee > 0): ?>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            + <?php echo e($plan->currency ?? 'USD'); ?> <?php echo e(number_format($plan->price_per_employee, 2)); ?> per employee
                        </p>
                        <?php endif; ?>
                    </div>

                    <?php if($plan->features && is_array($plan->features)): ?>
                    <ul class="mb-6 space-y-2">
                        <?php $__currentLoopData = $plan->features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="flex items-start">
                            <svg class="mr-2 h-5 w-5 flex-shrink-0 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-sm text-gray-700 dark:text-gray-300"><?php echo e($feature); ?></span>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <?php endif; ?>

                    <div class="mt-6">
                        <?php if($isCurrentPlan): ?>
                        <button disabled class="w-full rounded-lg bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-500 cursor-not-allowed dark:bg-gray-800 dark:text-gray-600">
                            Current Plan
                        </button>
                        <?php else: ?>
                        <a href="<?php echo e(route('companies.subscriptions.change-plan.show', ['company' => currentCompany()?->slug, 'plan' => $plan])); ?>" 
                           class="block w-full rounded-lg <?php echo e($isUpgrade ? 'bg-indigo-600 hover:bg-indigo-700' : ($isDowngrade ? 'bg-gray-600 hover:bg-gray-700' : 'bg-indigo-600 hover:bg-indigo-700')); ?> px-4 py-2 text-center text-sm font-semibold text-white shadow-sm transition">
                            <?php echo e($isUpgrade ? 'Upgrade' : ($isDowngrade ? 'Downgrade' : 'Select Plan')); ?>

                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        
        <div class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-950">
            <div class="border-b border-gray-100 px-6 py-4 dark:border-gray-800">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Invoice History</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm dark:divide-gray-800">
                    <thead class="bg-gray-50 dark:bg-gray-900/40">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400">Invoice #</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400">Issue Date</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400">Due Date</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white dark:divide-gray-800 dark:bg-gray-950">
                        <?php $__empty_1 = true; $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="whitespace-nowrap px-6 py-4 text-gray-900 dark:text-gray-100">
                                <?php echo e($invoice->invoice_number); ?>

                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-gray-700 dark:text-gray-300">
                                <?php echo e($invoice->issue_date->format('M d, Y')); ?>

                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-gray-700 dark:text-gray-300">
                                <?php echo e($invoice->due_date?->format('M d, Y') ?? '—'); ?>

                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-gray-900 dark:text-gray-100">
                                <?php echo e($invoice->currency); ?> <?php echo e(number_format($invoice->total_amount, 2)); ?>

                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <?php
                                    $invoiceStatusColor = match($invoice->status) {
                                        'paid' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300',
                                        'pending' => 'bg-amber-50 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300',
                                        'overdue' => 'bg-rose-50 text-rose-700 dark:bg-rose-900/30 dark:text-rose-300',
                                        'canceled' => 'bg-gray-50 text-gray-700 dark:bg-gray-900/40 dark:text-gray-300',
                                        default => 'bg-gray-50 text-gray-700 dark:bg-gray-900/40 dark:text-gray-300',
                                    };
                                ?>
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium <?php echo e($invoiceStatusColor); ?>">
                                    <?php echo e(strtoupper($invoice->status)); ?>

                                </span>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-right">
                                <a href="<?php echo e(route('companies.subscriptions.invoices.download', ['company' => currentCompany()?->slug, 'invoice' => $invoice])); ?>" 
                                   class="inline-flex items-center rounded-md border border-gray-200 bg-white px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:hover:bg-gray-800">
                                    <svg class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Download
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-8">
                                <?php if (isset($component)) { $__componentOriginal3a48860f85f8c35fd556d53deb53c643 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3a48860f85f8c35fd556d53deb53c643 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-states.no-invoices','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-states.no-invoices'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3a48860f85f8c35fd556d53deb53c643)): ?>
<?php $attributes = $__attributesOriginal3a48860f85f8c35fd556d53deb53c643; ?>
<?php unset($__attributesOriginal3a48860f85f8c35fd556d53deb53c643); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3a48860f85f8c35fd556d53deb53c643)): ?>
<?php $component = $__componentOriginal3a48860f85f8c35fd556d53deb53c643; ?>
<?php unset($__componentOriginal3a48860f85f8c35fd556d53deb53c643); ?>
<?php endif; ?>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        
        <?php if($currentSubscription && $currentSubscription->isActive()): ?>
        <div class="mt-8 rounded-xl border border-rose-200 bg-rose-50 p-6 dark:border-rose-800 dark:bg-rose-900/20">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-rose-900 dark:text-rose-100">Cancel Subscription</h3>
                    <p class="mt-1 text-sm text-rose-700 dark:text-rose-300">
                        If you cancel your subscription, you'll continue to have access until the end of your current billing period.
                    </p>
                </div>
                <form method="POST" action="<?php echo e(route('companies.subscriptions.cancel', ['company' => currentCompany()?->slug])); ?>" 
                      onsubmit="return confirm('Are you sure you want to cancel your subscription?')">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="confirm" value="1">
                    <button type="submit" 
                            class="ml-4 rounded-lg border border-rose-300 bg-white px-4 py-2 text-sm font-semibold text-rose-700 hover:bg-rose-50 dark:border-rose-700 dark:bg-rose-900/40 dark:text-rose-300 dark:hover:bg-rose-900/60">
                        Cancel Subscription
                    </button>
                </form>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\payroll-system\resources\views/subscriptions/index.blade.php ENDPATH**/ ?>