@php
    /** @var \Illuminate\Support\Collection|\App\Models\SubscriptionPlan[] $plans */
@endphp

@extends('layouts.layout')

@section('title', 'Create New Company')

@section('content')
    <main class="flex-1">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Create New Company</h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Add a new company to the platform. The admin user will be created or updated if they already exist.
                </p>
            </div>

            @if (session('success'))
                <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 dark:bg-emerald-900/20 dark:border-emerald-800 p-4 text-sm text-emerald-700 dark:text-emerald-300" role="alert">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-xl bg-red-50 border border-red-200 dark:bg-red-900/20 dark:border-red-800 p-4 text-sm text-red-700 dark:text-red-300" role="alert">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <p class="font-semibold mb-1">Please fix the errors below and try again.</p>
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-950 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm">
                <form method="POST" action="{{ route('admin.companies.store') }}" enctype="multipart/form-data" class="p-6 space-y-8" novalidate>
                    @csrf

                    <!-- Company Details & Admin User -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Company Details -->
                        <div class="space-y-6">
                            <div class="pb-4 border-b border-gray-200 dark:border-gray-800">
                                <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 flex items-center">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 mr-3 text-sm font-bold">1</span>
                                    Company details
                                </h2>
                            </div>

                            <div>
                                <label for="company_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Company name <span class="text-red-500">*</span></label>
                                <input
                                    id="company_name"
                                    type="text"
                                    name="company_name"
                                    value="{{ old('company_name') }}"
                                    required
                                    placeholder="Acme Corporation"
                                    class="block w-full rounded-lg border @error('company_name') border-red-300 bg-red-50 dark:bg-red-900/20 @else border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 @enderror px-4 py-2.5 text-sm shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                    @error('company_name') aria-invalid="true" aria-describedby="company_name-error" @enderror
                                >
                                @error('company_name')
                                    <p id="company_name-error" class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="legal_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Legal name</label>
                                <input
                                    id="legal_name"
                                    type="text"
                                    name="legal_name"
                                    value="{{ old('legal_name') }}"
                                    placeholder="Acme Corporation Ltd."
                                    class="block w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-2.5 text-sm shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                >
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="registration_number" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Registration number</label>
                                    <input
                                        id="registration_number"
                                        type="text"
                                        name="registration_number"
                                        value="{{ old('registration_number') }}"
                                        placeholder="REG123456"
                                        class="block w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-2.5 text-sm shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                    >
                                </div>
                                <div>
                                    <label for="tax_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tax ID</label>
                                    <input
                                        id="tax_id"
                                        type="text"
                                        name="tax_id"
                                        value="{{ old('tax_id') }}"
                                        placeholder="TAX789012"
                                        class="block w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-2.5 text-sm shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                    >
                                </div>
                            </div>

                            <div>
                                <label for="billing_email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Billing email <span class="text-red-500">*</span></label>
                                <input
                                    id="billing_email"
                                    type="email"
                                    name="billing_email"
                                    value="{{ old('billing_email') }}"
                                    required
                                    placeholder="billing@company.com"
                                    class="block w-full rounded-lg border @error('billing_email') border-red-300 bg-red-50 dark:bg-red-900/20 @else border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 @enderror px-4 py-2.5 text-sm shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                    @error('billing_email') aria-invalid="true" aria-describedby="billing_email-error" @enderror
                                >
                                @error('billing_email')
                                    <p id="billing_email-error" class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="logo" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Company logo</label>
                                <input
                                    id="logo"
                                    type="file"
                                    name="logo"
                                    accept="image/*"
                                    class="block w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-2.5 text-sm shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors file:mr-4 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 dark:file:bg-indigo-900/30 file:text-indigo-700 dark:file:text-indigo-300 hover:file:bg-indigo-100 dark:hover:file:bg-indigo-900/50"
                                >
                                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">PNG or JPG, up to 2MB.</p>
                            </div>
                        </div>

                        <!-- Admin User -->
                        <div class="space-y-6" x-data="{ showPassword: false, showPasswordConfirmation: false }">
                            <div class="pb-4 border-b border-gray-200 dark:border-gray-800">
                                <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 flex items-center">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 mr-3 text-sm font-bold">2</span>
                                    Admin user
                                </h2>
                            </div>

                            <div>
                                <label for="admin_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Full name <span class="text-red-500">*</span></label>
                                <input
                                    id="admin_name"
                                    type="text"
                                    name="admin_name"
                                    value="{{ old('admin_name') }}"
                                    required
                                    placeholder="John Doe"
                                    class="block w-full rounded-lg border @error('admin_name') border-red-300 bg-red-50 dark:bg-red-900/20 @else border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 @enderror px-4 py-2.5 text-sm shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                    @error('admin_name') aria-invalid="true" aria-describedby="admin_name-error" @enderror
                                >
                                @error('admin_name')
                                    <p id="admin_name-error" class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="admin_email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Email address <span class="text-red-500">*</span></label>
                                <input
                                    id="admin_email"
                                    type="email"
                                    name="admin_email"
                                    value="{{ old('admin_email') }}"
                                    required
                                    placeholder="admin@company.com"
                                    class="block w-full rounded-lg border @error('admin_email') border-red-300 bg-red-50 dark:bg-red-900/20 @else border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 @enderror px-4 py-2.5 text-sm shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                    @error('admin_email') aria-invalid="true" aria-describedby="admin_email-error" @enderror
                                >
                                @error('admin_email')
                                    <p id="admin_email-error" class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="admin_password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Password <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input
                                        :type="showPassword ? 'text' : 'password'"
                                        id="admin_password"
                                        name="admin_password"
                                        required
                                        placeholder="Create a strong password"
                                        class="block w-full rounded-lg border @error('admin_password') border-red-300 bg-red-50 dark:bg-red-900/20 @else border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 @enderror px-4 py-2.5 pr-10 text-sm shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                        @error('admin_password') aria-invalid="true" aria-describedby="admin_password-error" @enderror
                                    >
                                    <button
                                        type="button"
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
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
                                @error('admin_password')
                                    <p id="admin_password-error" class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Use at least 8 characters with a mix of letters and numbers.</p>
                            </div>

                            <div>
                                <label for="admin_password_confirmation" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Confirm password <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input
                                        :type="showPasswordConfirmation ? 'text' : 'password'"
                                        id="admin_password_confirmation"
                                        name="admin_password_confirmation"
                                        required
                                        placeholder="Confirm your password"
                                        class="block w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-2.5 pr-10 text-sm shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                    >
                                    <button
                                        type="button"
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
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
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 pt-8 border-t border-gray-200 dark:border-gray-800">
                        <!-- Company Profile -->
                        <div class="space-y-6">
                            <div class="pb-4 border-b border-gray-200 dark:border-gray-800">
                                <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 flex items-center">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-pink-100 dark:bg-pink-900/30 text-pink-600 dark:text-pink-400 mr-3 text-sm font-bold">3</span>
                                    Company profile
                                </h2>
                            </div>

                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <label for="country" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Country</label>
                                    <input type="text" id="country" name="country" value="{{ old('country') }}" placeholder="KE" class="block w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-2.5 text-sm shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                                </div>
                                <div>
                                    <label for="timezone" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Timezone</label>
                                    <input type="text" id="timezone" name="timezone" value="{{ old('timezone', config('app.timezone')) }}" placeholder="UTC" class="block w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-2.5 text-sm shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                                </div>
                                <div>
                                    <label for="currency" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Currency <span class="text-red-500">*</span></label>
                                    <input type="text" id="currency" name="currency" value="{{ old('currency', 'USD') }}" required placeholder="USD" class="block w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-2.5 text-sm shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                                </div>
                            </div>

                            <div>
                                <label for="address_line1" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Address line 1</label>
                                <input type="text" id="address_line1" name="address_line1" value="{{ old('address_line1') }}" placeholder="123 Main Street" class="block w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-2.5 text-sm shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                            </div>

                            <div>
                                <label for="address_line2" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Address line 2</label>
                                <input type="text" id="address_line2" name="address_line2" value="{{ old('address_line2') }}" placeholder="Suite 100" class="block w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-2.5 text-sm shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                            </div>

                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <label for="city" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">City</label>
                                    <input type="text" id="city" name="city" value="{{ old('city') }}" placeholder="Nairobi" class="block w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-2.5 text-sm shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                                </div>
                                <div>
                                    <label for="state" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">State</label>
                                    <input type="text" id="state" name="state" value="{{ old('state') }}" placeholder="State" class="block w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-2.5 text-sm shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                                </div>
                                <div>
                                    <label for="postal_code" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Postal code</label>
                                    <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code') }}" placeholder="00100" class="block w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-2.5 text-sm shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                                </div>
                            </div>
                        </div>

                        <!-- Plan Selection -->
                        <div class="space-y-6">
                            <div class="pb-4 border-b border-gray-200 dark:border-gray-800">
                                <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 flex items-center">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 mr-3 text-sm font-bold">4</span>
                                    Choose your plan
                                </h2>
                            </div>

                            <div class="space-y-3">
                                @forelse ($plans as $plan)
                                    @php
                                        $isSelected = old('plan_code') === $plan->code || ($loop->first && ! old('plan_code'));
                                    @endphp
                                    <label class="block p-4 rounded-lg border-2 {{ $isSelected ? 'border-indigo-500 bg-indigo-50 dark:bg-indigo-900/20' : 'border-gray-200 dark:border-gray-700 hover:border-indigo-300 dark:hover:border-indigo-700 hover:bg-indigo-50/50 dark:hover:bg-indigo-900/10' }} cursor-pointer transition-all duration-200">
                                        <div class="flex items-start">
                                            <input
                                                type="radio"
                                                name="plan_code"
                                                value="{{ $plan->code }}"
                                                @checked($isSelected)
                                                class="mt-1 h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300"
                                            >
                                            <div class="ml-3 flex-1">
                                                <div class="flex items-center justify-between">
                                                    <div>
                                                        <span class="font-bold text-gray-900 dark:text-gray-100">{{ $plan->name }}</span>
                                                        <span class="ml-2 text-xs text-gray-500 dark:text-gray-400">({{ $plan->billing_model }})</span>
                                                    </div>
                                                    <div class="text-right">
                                                        <div class="text-sm font-bold text-gray-900 dark:text-gray-100">
                                                            {{ $plan->currency }} {{ number_format($plan->base_price, 2) }}
                                                        </div>
                                                        @if ($plan->billing_model === 'per_employee' && $plan->price_per_employee)
                                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                                + {{ $plan->currency }} {{ number_format($plan->price_per_employee, 2) }}/employee
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 font-medium">
                                                        {{ $plan->trial_days }}-day free trial
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                @empty
                                    <div class="p-4 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            No plans are configured yet. Please contact support.
                                        </p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Submit button -->
                    <div class="pt-8 border-t border-gray-200 dark:border-gray-800 flex items-center justify-between">
                        <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex items-center justify-center px-6 py-3 rounded-lg text-sm font-semibold text-white bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 shadow-lg shadow-indigo-500/25 hover:shadow-xl hover:shadow-indigo-500/30 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:-translate-y-0.5">
                            Create Company
                            <svg class="ml-2 w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection
