<?php
    /** @var \Illuminate\Support\Collection|\App\Models\SubscriptionPlan[] $plans */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up your company – <?php echo e(config('app.name', 'MatechPay')); ?></title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="antialiased bg-gradient-to-br from-gray-50 via-indigo-50/30 to-white min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <!-- Background decoration -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-indigo-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-pink-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>
    </div>

    <div class="relative max-w-5xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <a href="<?php echo e(route('landing')); ?>" class="inline-flex items-center space-x-3 mb-6">
                <span class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-600 to-indigo-700 text-white font-bold text-lg shadow-lg shadow-indigo-500/25">
                    MP
                </span>
                <span class="text-2xl font-bold tracking-tight text-gray-900"><?php echo e(config('app.name', 'MatechPay')); ?></span>
            </a>
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900">Sign up your company</h1>
            <p class="mt-2 text-gray-600">
                Create your company account and start a free trial. No credit card required.
            </p>
            <p class="mt-4 text-sm text-gray-500">
                Already have an account?
                <?php if(Route::has('login')): ?>
                    <a href="<?php echo e(route('login')); ?>" class="font-semibold text-indigo-600 hover:text-indigo-500 transition-colors">Log in</a>
                <?php endif; ?>
            </p>
        </div>

        <!-- Signup form card -->
        <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-2xl border border-gray-200/50 p-8 sm:p-10">
            <?php if($errors->any()): ?>
                <div class="mb-8 rounded-xl bg-red-50 border border-red-200 p-4 text-sm text-red-700" role="alert">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <p class="font-semibold mb-1">Please fix the errors below and try again.</p>
                            <ul class="list-disc list-inside space-y-1">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('company.signup.store')); ?>" enctype="multipart/form-data" class="space-y-8" novalidate>
                <?php echo csrf_field(); ?>

                <!-- Company Details & Admin User -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Company Details -->
                    <div class="space-y-6">
                        <div class="pb-4 border-b border-gray-200">
                            <h2 class="text-lg font-bold text-gray-900 flex items-center">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 mr-3 text-sm font-bold">1</span>
                                Company details
                            </h2>
                        </div>

                        <div>
                            <label for="company_name" class="block text-sm font-semibold text-gray-700 mb-2">Company name <span class="text-red-500">*</span></label>
                            <input
                                id="company_name"
                                type="text"
                                name="company_name"
                                value="<?php echo e(old('company_name')); ?>"
                                required
                                placeholder="Acme Corporation"
                                class="block w-full rounded-xl border <?php $__errorArgs = ['company_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 bg-red-50 <?php else: ?> border-gray-300 bg-white <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> px-4 py-3 text-sm shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                <?php $__errorArgs = ['company_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> aria-invalid="true" aria-describedby="company_name-error" <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            >
                            <?php $__errorArgs = ['company_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p id="company_name-error" class="mt-2 text-xs text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label for="legal_name" class="block text-sm font-semibold text-gray-700 mb-2">Legal name</label>
                            <input
                                id="legal_name"
                                type="text"
                                name="legal_name"
                                value="<?php echo e(old('legal_name')); ?>"
                                placeholder="Acme Corporation Ltd."
                                class="block w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                            >
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="registration_number" class="block text-sm font-semibold text-gray-700 mb-2">Registration number</label>
                                <input
                                    id="registration_number"
                                    type="text"
                                    name="registration_number"
                                    value="<?php echo e(old('registration_number')); ?>"
                                    placeholder="REG123456"
                                    class="block w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                >
                            </div>
                            <div>
                                <label for="tax_id" class="block text-sm font-semibold text-gray-700 mb-2">Tax ID</label>
                                <input
                                    id="tax_id"
                                    type="text"
                                    name="tax_id"
                                    value="<?php echo e(old('tax_id')); ?>"
                                    placeholder="TAX789012"
                                    class="block w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                >
                            </div>
                        </div>

                        <div>
                            <label for="billing_email" class="block text-sm font-semibold text-gray-700 mb-2">Billing email <span class="text-red-500">*</span></label>
                            <input
                                id="billing_email"
                                type="email"
                                name="billing_email"
                                value="<?php echo e(old('billing_email')); ?>"
                                required
                                placeholder="billing@company.com"
                                class="block w-full rounded-xl border <?php $__errorArgs = ['billing_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 bg-red-50 <?php else: ?> border-gray-300 bg-white <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> px-4 py-3 text-sm shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                <?php $__errorArgs = ['billing_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> aria-invalid="true" aria-describedby="billing_email-error" <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            >
                            <?php $__errorArgs = ['billing_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p id="billing_email-error" class="mt-2 text-xs text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label for="logo" class="block text-sm font-semibold text-gray-700 mb-2">Company logo</label>
                            <input
                                id="logo"
                                type="file"
                                name="logo"
                                accept="image/*"
                                class="block w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                            >
                            <p class="mt-2 text-xs text-gray-500">PNG or JPG, up to 2MB.</p>
                        </div>
                    </div>

                    <!-- Admin User -->
                    <div class="space-y-6" x-data="{ showPassword: false, showPasswordConfirmation: false }">
                        <div class="pb-4 border-b border-gray-200">
                            <h2 class="text-lg font-bold text-gray-900 flex items-center">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-purple-100 text-purple-600 mr-3 text-sm font-bold">2</span>
                                Admin user
                            </h2>
                        </div>

                        <div>
                            <label for="admin_name" class="block text-sm font-semibold text-gray-700 mb-2">Full name <span class="text-red-500">*</span></label>
                            <input
                                id="admin_name"
                                type="text"
                                name="admin_name"
                                value="<?php echo e(old('admin_name')); ?>"
                                required
                                placeholder="John Doe"
                                class="block w-full rounded-xl border <?php $__errorArgs = ['admin_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 bg-red-50 <?php else: ?> border-gray-300 bg-white <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> px-4 py-3 text-sm shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                <?php $__errorArgs = ['admin_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> aria-invalid="true" aria-describedby="admin_name-error" <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            >
                            <?php $__errorArgs = ['admin_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p id="admin_name-error" class="mt-2 text-xs text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label for="admin_email" class="block text-sm font-semibold text-gray-700 mb-2">Email address <span class="text-red-500">*</span></label>
                            <input
                                id="admin_email"
                                type="email"
                                name="admin_email"
                                value="<?php echo e(old('admin_email')); ?>"
                                required
                                placeholder="admin@company.com"
                                class="block w-full rounded-xl border <?php $__errorArgs = ['admin_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 bg-red-50 <?php else: ?> border-gray-300 bg-white <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> px-4 py-3 text-sm shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                <?php $__errorArgs = ['admin_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> aria-invalid="true" aria-describedby="admin_email-error" <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            >
                            <?php $__errorArgs = ['admin_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p id="admin_email-error" class="mt-2 text-xs text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label for="admin_password" class="block text-sm font-semibold text-gray-700 mb-2">Password <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input
                                    :type="showPassword ? 'text' : 'password'"
                                    id="admin_password"
                                    name="admin_password"
                                    required
                                    placeholder="Create a strong password"
                                    class="block w-full rounded-xl border <?php $__errorArgs = ['admin_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 bg-red-50 <?php else: ?> border-gray-300 bg-white <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> px-4 py-3 pr-10 text-sm shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                    <?php $__errorArgs = ['admin_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> aria-invalid="true" aria-describedby="admin_password-error" <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                >
                                <button
                                    type="button"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition-colors"
                                    @click="showPassword = !showPassword"
                                    :aria-label="showPassword ? 'Hide password' : 'Show password'"
                                >
                                    <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18M10.477 10.489A3 3 0 0013.5 13.5m-1.759 3.267A8.258 8.258 0 0112 16.5c-4.477 0-8.268-2.943-9.542-7a13.134 13.134 0 013.303-5.197M9.88 4.24A8.254 8.254 0 0112 4.5c4.478 0 8.268 2.943 9.542 7-.225.717-.516 1.4-.867 2.043"/>
                                    </svg>
                                </button>
                            </div>
                            <?php $__errorArgs = ['admin_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p id="admin_password-error" class="mt-2 text-xs text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <p class="mt-2 text-xs text-gray-500">Use at least 8 characters with a mix of letters and numbers.</p>
                        </div>

                        <div>
                            <label for="admin_password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Confirm password <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input
                                    :type="showPasswordConfirmation ? 'text' : 'password'"
                                    id="admin_password_confirmation"
                                    name="admin_password_confirmation"
                                    required
                                    placeholder="Confirm your password"
                                    class="block w-full rounded-xl border border-gray-300 bg-white px-4 py-3 pr-10 text-sm shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                >
                                <button
                                    type="button"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition-colors"
                                    @click="showPasswordConfirmation = !showPasswordConfirmation"
                                    :aria-label="showPasswordConfirmation ? 'Hide password' : 'Show password'"
                                >
                                    <svg x-show="!showPasswordConfirmation" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <svg x-show="showPasswordConfirmation" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18M10.477 10.489A3 3 0 0013.5 13.5m-1.759 3.267A8.258 8.258 0 0112 16.5c-4.477 0-8.268-2.943-9.542-7a13.134 13.134 0 013.303-5.197M9.88 4.24A8.254 8.254 0 0112 4.5c4.478 0 8.268 2.943 9.542 7-.225.717-.516 1.4-.867 2.043"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Company Profile & Plan Selection -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 pt-8 border-t border-gray-200">
                    <!-- Company Profile -->
                    <div class="space-y-6">
                        <div class="pb-4 border-b border-gray-200">
                            <h2 class="text-lg font-bold text-gray-900 flex items-center">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-pink-100 text-pink-600 mr-3 text-sm font-bold">3</span>
                                Company profile
                            </h2>
                        </div>

                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label for="country" class="block text-sm font-semibold text-gray-700 mb-2">Country</label>
                                <input type="text" id="country" name="country" value="<?php echo e(old('country')); ?>" placeholder="KE" class="block w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                            </div>
                            <div>
                                <label for="timezone" class="block text-sm font-semibold text-gray-700 mb-2">Timezone</label>
                                <input type="text" id="timezone" name="timezone" value="<?php echo e(old('timezone', config('app.timezone'))); ?>" placeholder="UTC" class="block w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                            </div>
                            <div>
                                <label for="currency" class="block text-sm font-semibold text-gray-700 mb-2">Currency <span class="text-red-500">*</span></label>
                                <input type="text" id="currency" name="currency" value="<?php echo e(old('currency', 'USD')); ?>" required placeholder="USD" class="block w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                            </div>
                        </div>

                        <div>
                            <label for="address_line1" class="block text-sm font-semibold text-gray-700 mb-2">Address line 1</label>
                            <input type="text" id="address_line1" name="address_line1" value="<?php echo e(old('address_line1')); ?>" placeholder="123 Main Street" class="block w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                        </div>

                        <div>
                            <label for="address_line2" class="block text-sm font-semibold text-gray-700 mb-2">Address line 2</label>
                            <input type="text" id="address_line2" name="address_line2" value="<?php echo e(old('address_line2')); ?>" placeholder="Suite 100" class="block w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                        </div>

                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label for="city" class="block text-sm font-semibold text-gray-700 mb-2">City</label>
                                <input type="text" id="city" name="city" value="<?php echo e(old('city')); ?>" placeholder="Nairobi" class="block w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                            </div>
                            <div>
                                <label for="state" class="block text-sm font-semibold text-gray-700 mb-2">State</label>
                                <input type="text" id="state" name="state" value="<?php echo e(old('state')); ?>" placeholder="State" class="block w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                            </div>
                            <div>
                                <label for="postal_code" class="block text-sm font-semibold text-gray-700 mb-2">Postal code</label>
                                <input type="text" id="postal_code" name="postal_code" value="<?php echo e(old('postal_code')); ?>" placeholder="00100" class="block w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                            </div>
                        </div>
                    </div>

                    <!-- Plan Selection -->
                    <div class="space-y-6">
                        <div class="pb-4 border-b border-gray-200">
                            <h2 class="text-lg font-bold text-gray-900 flex items-center">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 mr-3 text-sm font-bold">4</span>
                                Choose your plan
                            </h2>
                        </div>

                        <div class="space-y-3">
                            <?php $__empty_1 = true; $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <?php
                                    $isSelected = old('plan_code') === $plan->code || ($loop->first && ! old('plan_code'));
                                ?>
                                <label class="block p-4 rounded-xl border-2 <?php echo e($isSelected ? 'border-indigo-500 bg-indigo-50' : 'border-gray-200 hover:border-indigo-300 hover:bg-indigo-50/50'); ?> cursor-pointer transition-all duration-200">
                                    <div class="flex items-start">
                                        <input
                                            type="radio"
                                            name="plan_code"
                                            value="<?php echo e($plan->code); ?>"
                                            <?php if(old('plan_code') === $plan->code || $loop->first && ! old('plan_code')): echo 'checked'; endif; ?>
                                            class="mt-1 h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300"
                                        >
                                        <div class="ml-3 flex-1">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <span class="font-bold text-gray-900"><?php echo e($plan->name); ?></span>
                                                    <span class="ml-2 text-xs text-gray-500">(<?php echo e($plan->billing_model); ?>)</span>
                                                </div>
                                                <div class="text-right">
                                                    <div class="text-sm font-bold text-gray-900">
                                                        <?php echo e($plan->currency); ?> <?php echo e(number_format($plan->base_price, 2)); ?>

                                                    </div>
                                                    <?php if($plan->billing_model === 'per_employee' && $plan->price_per_employee): ?>
                                                        <div class="text-xs text-gray-500">
                                                            + <?php echo e($plan->currency); ?> <?php echo e(number_format($plan->price_per_employee, 2)); ?>/employee
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="mt-2 text-xs text-gray-500">
                                                <span class="inline-flex items-center px-2 py-1 rounded-full bg-emerald-100 text-emerald-700 font-medium">
                                                    <?php echo e($plan->trial_days); ?>-day free trial
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="p-4 rounded-xl border border-gray-200 bg-gray-50">
                                    <p class="text-sm text-gray-600">
                                        No plans are configured yet. Please contact support.
                                    </p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Submit button -->
                <div class="pt-8 border-t border-gray-200">
                    <button type="submit" class="w-full sm:w-auto sm:float-right inline-flex items-center justify-center px-8 py-4 rounded-xl text-base font-semibold text-white bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 shadow-lg shadow-indigo-500/25 hover:shadow-xl hover:shadow-indigo-500/30 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:-translate-y-0.5">
                        Start free trial
                        <svg class="ml-2 w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        <!-- Back to home -->
        <div class="mt-6 text-center">
            <a href="<?php echo e(route('landing')); ?>" class="text-sm text-gray-600 hover:text-indigo-600 transition-colors inline-flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to home
            </a>
        </div>
    </div>

    <style>
        @keyframes blob {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\payroll-system\resources\views/auth/company-signup.blade.php ENDPATH**/ ?>