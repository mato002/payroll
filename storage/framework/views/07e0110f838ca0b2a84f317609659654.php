<?php $__env->startSection('title', 'Contact – ' . config('app.name')); ?>

<?php $__env->startSection('content'); ?>
    <section class="bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-20">
            <div class="text-center">
                <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900">Talk to our team.</h1>
                <p class="mt-3 text-gray-600 max-w-xl mx-auto">
                    Have questions about pricing, implementation, or security? Send us a message and we’ll respond within one business day.
                </p>
            </div>

            <div class="mt-10 grid gap-10 md:grid-cols-3">
                <!-- Contact info -->
                <div class="md:col-span-1 space-y-6 text-sm text-gray-700">
                    <div>
                        <h2 class="text-base font-semibold text-gray-900">Sales</h2>
                        <p class="mt-1 text-gray-600">
                            For demos, pricing, and custom requirements.
                        </p>
                        <p class="mt-1 text-indigo-600">sales@example.com</p>
                    </div>
                    <div>
                        <h2 class="text-base font-semibold text-gray-900">Support</h2>
                        <p class="mt-1 text-gray-600">
                            For technical issues and product questions.
                        </p>
                        <p class="mt-1 text-indigo-600">support@example.com</p>
                    </div>
                    <div>
                        <h2 class="text-base font-semibold text-gray-900">Office</h2>
                        <p class="mt-1 text-gray-600">
                            123 Payroll Street<br>
                            Suite 400<br>
                            Example City, Country
                        </p>
                    </div>
                </div>

                <!-- Contact form -->
                <div class="md:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm border p-6 sm:p-8">
                        <?php if(session('status')): ?>
                            <div class="mb-4 rounded-md bg-green-50 p-3 text-sm text-green-700">
                                <?php echo e(session('status')); ?>

                            </div>
                        <?php endif; ?>

                        <form method="POST" action="<?php echo e(route('contact.submit')); ?>" class="space-y-4">
                            <?php echo csrf_field(); ?>
                            <div class="grid gap-4 sm:grid-cols-2">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Full name</label>
                                    <input type="text" name="name" id="name" value="<?php echo e(old('name')); ?>" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div>
                                    <label for="company" class="block text-sm font-medium text-gray-700">Company</label>
                                    <input type="text" name="company" id="company" value="<?php echo e(old('company')); ?>"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                    <?php $__errorArgs = ['company'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="grid gap-4 sm:grid-cols-2">
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Work email</label>
                                    <input type="email" name="email" id="email" value="<?php echo e(old('email')); ?>" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div>
                                    <label for="employees" class="block text-sm font-medium text-gray-700">Employees</label>
                                    <select id="employees" name="employees"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                        <option value="">Select</option>
                                        <option value="1-15" <?php if(old('employees') === '1-15'): echo 'selected'; endif; ?>>1–15</option>
                                        <option value="16-50" <?php if(old('employees') === '16-50'): echo 'selected'; endif; ?>>16–50</option>
                                        <option value="51-200" <?php if(old('employees') === '51-200'): echo 'selected'; endif; ?>>51–200</option>
                                        <option value="200+" <?php if(old('employees') === '200+'): echo 'selected'; endif; ?>>200+</option>
                                    </select>
                                    <?php $__errorArgs = ['employees'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div>
                                <label for="topic" class="block text-sm font-medium text-gray-700">Topic</label>
                                <select id="topic" name="topic"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                    <option value="demo" <?php if(old('topic') === 'demo'): echo 'selected'; endif; ?>>Product demo</option>
                                    <option value="pricing" <?php if(old('topic') === 'pricing'): echo 'selected'; endif; ?>>Pricing</option>
                                    <option value="implementation" <?php if(old('topic') === 'implementation'): echo 'selected'; endif; ?>>Implementation</option>
                                    <option value="support" <?php if(old('topic') === 'support'): echo 'selected'; endif; ?>>Support</option>
                                    <option value="other" <?php if(old('topic') === 'other'): echo 'selected'; endif; ?>>Other</option>
                                </select>
                                <?php $__errorArgs = ['topic'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700">How can we help?</label>
                                <textarea id="message" name="message" rows="4" required
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"><?php echo e(old('message')); ?></textarea>
                                <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="flex items-start space-x-2 text-xs text-gray-500">
                                <input id="consent" name="consent" type="checkbox"
                                       class="mt-1 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500"
                                       <?php echo e(old('consent') ? 'checked' : ''); ?>>
                                <label for="consent">
                                    I agree to receive communications. You can unsubscribe at any time.
                                </label>
                            </div>

                            <button type="submit"
                                    class="w-full inline-flex items-center justify-center px-4 py-2 rounded-md text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700">
                                Submit
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="mt-12 text-center text-sm text-gray-500">
                Prefer email? Reach us directly at <span class="text-indigo-600">sales@example.com</span>.
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.marketing', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\payroll-system\resources\views/contact.blade.php ENDPATH**/ ?>