@php
    /** @var \Illuminate\Support\Collection|\App\Models\SubscriptionPlan[] $plans */
@endphp

@extends('layouts.marketing')

@section('title', 'Sign up your company – ' . config('app.name', 'Payroll SaaS'))

@section('content')
    <section class="bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-20">
            <div class="max-w-3xl mx-auto bg-white shadow-sm border rounded-2xl p-6 sm:p-8">
                <div class="flex flex-col sm:flex-row sm:items-baseline sm:justify-between gap-2">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Sign up your company</h1>
                        <p class="mt-1 text-sm text-gray-600">
                            Create your company account and start a free trial. No credit card required.
                        </p>
                    </div>
                    <p class="text-xs text-gray-500">
                        Already have an account?
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">Log in</a>
                        @endif
                    </p>
                </div>

                @if ($errors->any())
                    <div class="mt-4 mb-4 rounded-md bg-red-50 p-3 text-sm text-red-700" role="alert">
                        <p class="font-medium">Please fix the errors below and try again.</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('company.signup.store') }}" enctype="multipart/form-data" class="mt-4 space-y-8" novalidate>
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Company info --}}
                <div>
                    <h2 class="text-sm font-semibold text-gray-900 mb-3">Company details</h2>

                    <div class="mb-3">
                        <label for="company_name" class="block text-xs font-medium text-gray-700">Company name *</label>
                        <input
                            id="company_name"
                            type="text"
                            name="company_name"
                            value="{{ old('company_name') }}"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 @error('company_name') border-red-500 @enderror px-3 py-2 text-sm shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            @error('company_name') aria-invalid="true" aria-describedby="company_name-error" @enderror
                        >
                        @error('company_name')
                            <p id="company_name-error" class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="legal_name" class="block text-xs font-medium text-gray-700">Legal name</label>
                        <input
                            id="legal_name"
                            type="text"
                            name="legal_name"
                            value="{{ old('legal_name') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 px-3 py-2 text-sm shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        >
                    </div>

                    <div class="mb-3">
                        <label for="registration_number" class="block text-xs font-medium text-gray-700">Registration number</label>
                        <input
                            id="registration_number"
                            type="text"
                            name="registration_number"
                            value="{{ old('registration_number') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 px-3 py-2 text-sm shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        >
                    </div>

                    <div class="mb-3">
                        <label for="tax_id" class="block text-xs font-medium text-gray-700">Tax ID</label>
                        <input
                            id="tax_id"
                            type="text"
                            name="tax_id"
                            value="{{ old('tax_id') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 px-3 py-2 text-sm shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        >
                    </div>

                    <div class="mb-3">
                        <label for="billing_email" class="block text-xs font-medium text-gray-700">Billing email *</label>
                        <input
                            id="billing_email"
                            type="email"
                            name="billing_email"
                            value="{{ old('billing_email') }}"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 @error('billing_email') border-red-500 @enderror px-3 py-2 text-sm shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            @error('billing_email') aria-invalid="true" aria-describedby="billing_email-error" @enderror
                        >
                        @error('billing_email')
                            <p id="billing_email-error" class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="logo" class="block text-xs font-medium text-gray-700">Logo</label>
                        <input
                            id="logo"
                            type="file"
                            name="logo"
                            accept="image/*"
                            class="mt-1 block w-full rounded-md border-gray-300 px-3 py-2 text-sm shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        >
                        <p class="mt-1 text-[11px] text-gray-500">PNG or JPG, up to 2MB.</p>
                    </div>
                </div>

                {{-- Admin user --}}
                <div x-data="{ showPassword: false }">
                    <h2 class="text-sm font-semibold text-gray-900 mb-3">Admin user</h2>

                    <div class="mb-3">
                        <label for="admin_name" class="block text-xs font-medium text-gray-700">Full name *</label>
                        <input
                            id="admin_name"
                            type="text"
                            name="admin_name"
                            value="{{ old('admin_name') }}"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 @error('admin_name') border-red-500 @enderror px-3 py-2 text-sm shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            @error('admin_name') aria-invalid="true" aria-describedby="admin_name-error" @enderror
                        >
                        @error('admin_name')
                            <p id="admin_name-error" class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="admin_email" class="block text-xs font-medium text-gray-700">Email address *</label>
                        <input
                            id="admin_email"
                            type="email"
                            name="admin_email"
                            value="{{ old('admin_email') }}"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 @error('admin_email') border-red-500 @enderror px-3 py-2 text-sm shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            @error('admin_email') aria-invalid="true" aria-describedby="admin_email-error" @enderror
                        >
                        @error('admin_email')
                            <p id="admin_email-error" class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="admin_password" class="block text-xs font-medium text-gray-700">Password *</label>
                        <div class="mt-1 relative">
                            <input
                                :type="showPassword ? 'text' : 'password'"
                                id="admin_password"
                                name="admin_password"
                                required
                                class="block w-full rounded-md border-gray-300 @error('admin_password') border-red-500 @enderror px-3 py-2 text-sm shadow-sm focus:ring-indigo-500 focus:border-indigo-500 pr-10"
                                @error('admin_password') aria-invalid="true" aria-describedby="admin_password-error" @enderror
                            >
                            <button
                                type="button"
                                class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-gray-600"
                                @click="showPassword = !showPassword"
                                :aria-label="showPassword ? 'Hide password' : 'Show password'"
                            >
                                <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M3 3l18 18M10.477 10.489A3 3 0 0013.5 13.5m-1.759 3.267A8.258 8.258 0 0112 16.5c-4.477 0-8.268-2.943-9.542-7a13.134 13.134 0 013.303-5.197M9.88 4.24A8.254 8.254 0 0112 4.5c4.478 0 8.268 2.943 9.542 7-.225.717-.516 1.4-.867 2.043"/>
                                </svg>
                            </button>
                        </div>
                        @error('admin_password')
                            <p id="admin_password-error" class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-[11px] text-gray-500">Use at least 8 characters with a mix of letters and numbers.</p>
                    </div>

                    <div class="mb-3">
                        <label for="admin_password_confirmation" class="block text-xs font-medium text-gray-700">Confirm password *</label>
                        <input
                            id="admin_password_confirmation"
                            type="password"
                            name="admin_password_confirmation"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 px-3 py-2 text-sm shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        >
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Company profile --}}
                <div>
                    <h2 class="font-medium mb-3">Company profile</h2>

                    <label class="block mb-3 text-sm">
                        <span class="block mb-1">Country (ISO code, e.g. KE, US)</span>
                        <input type="text" name="country" value="{{ old('country') }}" class="w-full border rounded px-3 py-2">
                    </label>

                    <label class="block mb-3 text-sm">
                        <span class="block mb-1">Timezone</span>
                        <input type="text" name="timezone" value="{{ old('timezone', config('app.timezone')) }}" class="w-full border rounded px-3 py-2">
                    </label>

                    <label class="block mb-3 text-sm">
                        <span class="block mb-1">Currency (e.g. KES, USD)</span>
                        <input type="text" name="currency" value="{{ old('currency', 'USD') }}" required class="w-full border rounded px-3 py-2">
                    </label>

                    <label class="block mb-3 text-sm">
                        <span class="block mb-1">Address line 1</span>
                        <input type="text" name="address_line1" value="{{ old('address_line1') }}" class="w-full border rounded px-3 py-2">
                    </label>

                    <label class="block mb-3 text-sm">
                        <span class="block mb-1">Address line 2</span>
                        <input type="text" name="address_line2" value="{{ old('address_line2') }}" class="w-full border rounded px-3 py-2">
                    </label>

                    <div class="grid grid-cols-3 gap-2">
                        <label class="block mb-3 text-sm col-span-1">
                            <span class="block mb-1">City</span>
                            <input type="text" name="city" value="{{ old('city') }}" class="w-full border rounded px-3 py-2">
                        </label>
                        <label class="block mb-3 text-sm col-span-1">
                            <span class="block mb-1">State</span>
                            <input type="text" name="state" value="{{ old('state') }}" class="w-full border rounded px-3 py-2">
                        </label>
                        <label class="block mb-3 text-sm col-span-1">
                            <span class="block mb-1">Postal code</span>
                            <input type="text" name="postal_code" value="{{ old('postal_code') }}" class="w-full border rounded px-3 py-2">
                        </label>
                    </div>
                </div>

                {{-- Plan selection --}}
                <div>
                    <h2 class="font-medium mb-3">Choose your plan</h2>

                    @forelse ($plans as $plan)
                        <label class="block mb-3 border rounded px-3 py-2 cursor-pointer">
                            <div class="flex items-center justify-between">
                                <div>
                                    <input
                                        type="radio"
                                        name="plan_code"
                                        value="{{ $plan->code }}"
                                        @checked(old('plan_code') === $plan->code || $loop->first && ! old('plan_code'))
                                        class="mr-2"
                                    >
                                    <span class="font-medium">{{ $plan->name }}</span>
                                    <span class="text-xs text-gray-500 ml-1">({{ $plan->billing_model }})</span>
                                </div>
                                <div class="text-sm text-gray-700">
                                    {{ $plan->currency }} {{ number_format($plan->base_price, 2) }}
                                    @if ($plan->billing_model === 'per_employee' && $plan->price_per_employee)
                                        <span class="text-xs text-gray-500">
                                            + {{ $plan->currency }} {{ number_format($plan->price_per_employee, 2) }}/employee
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-1 text-xs text-gray-500">
                                Trial: {{ $plan->trial_days }} days
                            </div>
                        </label>
                    @empty
                        <p class="text-sm text-gray-600">
                            No plans are configured yet. Please contact support.
                        </p>
                    @endforelse
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2 bg-black text-white rounded hover:bg-gray-900 text-sm">
                    Start free trial
                </button>
            </div>
        </form>
    </div>
</body>
</html>

