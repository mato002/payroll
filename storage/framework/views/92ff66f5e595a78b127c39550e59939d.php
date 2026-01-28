

<?php $__env->startSection('title', 'Pricing – ' . config('app.name', 'MatechPay')); ?>

<?php $__env->startSection('content'); ?>
    <section class="bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-20">
            <div class="text-center max-w-2xl mx-auto">
                <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900">Simple, transparent pricing.</h1>
                <p class="mt-3 text-gray-600">
                    Pay only for active employees. All plans include compliance, support, and secure payslip delivery.
                </p>
            </div>

            <div class="mt-10 grid gap-8 lg:grid-cols-3">
                <!-- Starter -->
                <div class="border rounded-xl bg-white shadow-sm flex flex-col">
                    <div class="p-6 border-b">
                        <p class="text-sm font-semibold text-indigo-600 uppercase tracking-wide">Starter</p>
                        <h2 class="mt-3 text-3xl font-extrabold text-gray-900">
                            $49<span class="text-base font-medium text-gray-500"> / month</span>
                        </h2>
                        <p class="mt-2 text-sm text-gray-600">For small teams getting started with payroll automation.</p>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <ul class="space-y-3 text-sm text-gray-700">
                            <li class="flex items-start">
                                <span class="text-green-500 mt-0.5">✓</span>
                                <span class="ml-2">Up to 15 employees</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-green-500 mt-0.5">✓</span>
                                <span class="ml-2">Monthly payroll runs</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-green-500 mt-0.5">✓</span>
                                <span class="ml-2">Standard support</span>
                            </li>
                        </ul>
                        <?php if(Route::has('company.signup')): ?>
                            <a href="<?php echo e(route('company.signup')); ?>"
                               class="mt-6 inline-flex items-center justify-center px-4 py-2 rounded-md text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 w-full">
                                Start free trial
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Growth -->
                <div class="border-2 border-indigo-600 rounded-xl bg-white shadow-lg transform lg:-mt-2 flex flex-col">
                    <div class="p-6 border-b bg-indigo-50">
                        <p class="text-sm font-semibold text-indigo-600 uppercase tracking-wide">Most popular</p>
                        <h2 class="mt-3 text-3xl font-extrabold text-gray-900">
                            $99<span class="text-base font-medium text-gray-500"> / month</span>
                        </h2>
                        <p class="mt-2 text-sm text-gray-600">For growing businesses that need scalable payroll.</p>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <ul class="space-y-3 text-sm text-gray-700">
                            <li class="flex items-start">
                                <span class="text-green-500 mt-0.5">✓</span>
                                <span class="ml-2">Up to 50 employees</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-green-500 mt-0.5">✓</span>
                                <span class="ml-2">Unlimited payroll runs</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-green-500 mt-0.5">✓</span>
                                <span class="ml-2">Automated tax calculations</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-green-500 mt-0.5">✓</span>
                                <span class="ml-2">Employee self-service portal</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-green-500 mt-0.5">✓</span>
                                <span class="ml-2">Priority support</span>
                            </li>
                        </ul>
                        <?php if(Route::has('company.signup')): ?>
                            <a href="<?php echo e(route('company.signup')); ?>"
                               class="mt-6 inline-flex items-center justify-center px-4 py-2 rounded-md text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 w-full">
                                Choose Growth
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Enterprise -->
                <div class="border rounded-xl bg-white shadow-sm flex flex-col">
                    <div class="p-6 border-b">
                        <p class="text-sm font-semibold text-indigo-600 uppercase tracking-wide">Enterprise</p>
                        <h2 class="mt-3 text-3xl font-extrabold text-gray-900">Custom</h2>
                        <p class="mt-2 text-sm text-gray-600">
                            For organizations with complex payroll and compliance needs.
                        </p>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <ul class="space-y-3 text-sm text-gray-700">
                            <li class="flex items-start">
                                <span class="text-green-500 mt-0.5">✓</span>
                                <span class="ml-2">Unlimited employees</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-green-500 mt-0.5">✓</span>
                                <span class="ml-2">Advanced reporting & exports</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-green-500 mt-0.5">✓</span>
                                <span class="ml-2">Dedicated success manager</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-green-500 mt-0.5">✓</span>
                                <span class="ml-2">Custom integrations & onboarding</span>
                            </li>
                        </ul>
                        <a href="<?php echo e(route('contact')); ?>"
                           class="mt-6 inline-flex items-center justify-center px-4 py-2 rounded-md text-sm font-semibold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 w-full">
                            Talk to sales
                        </a>
                    </div>
                </div>
            </div>

            <!-- FAQ -->
            <div class="mt-16 max-w-3xl mx-auto">
                <h2 class="text-xl font-semibold text-gray-900 text-center">Frequently asked questions</h2>
                <dl class="mt-6 space-y-6">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <dt class="text-sm font-semibold text-gray-900">Is there a free trial?</dt>
                        <dd class="mt-2 text-sm text-gray-600">
                            Yes, all plans include a 14-day free trial. You can cancel anytime during the trial period.
                        </dd>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <dt class="text-sm font-semibold text-gray-900">Can I change plans later?</dt>
                        <dd class="mt-2 text-sm text-gray-600">
                            You can upgrade or downgrade your plan at any time. Changes are prorated.
                        </dd>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <dt class="text-sm font-semibold text-gray-900">Do you offer implementation support?</dt>
                        <dd class="mt-2 text-sm text-gray-600">
                            Yes. Our team will help you import employees, configure payroll rules, and run your first payroll.
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.marketing', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\payroll-system\resources\views/pricing.blade.php ENDPATH**/ ?>