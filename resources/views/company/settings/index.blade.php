@extends('layouts.layout')

@section('title', __('Company settings'))

@section('content')
    <div class="mx-auto max-w-5xl space-y-6">
        {{-- Header --}}
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                {{ __('Company settings') }}
            </h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Manage basic details, billing information, and localization for this company.') }}
            </p>
        </div>

        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 dark:border-emerald-900/50 dark:bg-emerald-950 dark:text-emerald-200">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800 dark:border-rose-900/50 dark:bg-rose-950 dark:text-rose-200">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('companies.settings.update', ['company' => $company->slug]) }}" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- General --}}
            <div class="grid gap-6 md:grid-cols-2">
                <div class="md:col-span-2 bg-white dark:bg-gray-950 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-6 space-y-4">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        {{ __('General information') }}
                    </h2>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <x-label for="name" :value="__('Company name')" required />
                            <x-input
                                id="name"
                                name="name"
                                type="text"
                                class="mt-1 block w-full"
                                :value="old('name', $company->name)"
                                required
                            />
                        </div>

                        <div>
                            <x-label for="legal_name" :value="__('Legal name')" />
                            <x-input
                                id="legal_name"
                                name="legal_name"
                                type="text"
                                class="mt-1 block w-full"
                                :value="old('legal_name', $company->legal_name)"
                            />
                        </div>

                        <div>
                            <x-label for="registration_number" :value="__('Registration number')" />
                            <x-input
                                id="registration_number"
                                name="registration_number"
                                type="text"
                                class="mt-1 block w-full"
                                :value="old('registration_number', $company->registration_number)"
                            />
                        </div>

                        <div>
                            <x-label for="tax_id" :value="__('Tax ID')" />
                            <x-input
                                id="tax_id"
                                name="tax_id"
                                type="text"
                                class="mt-1 block w-full"
                                :value="old('tax_id', $company->tax_id)"
                            />
                        </div>
                    </div>
                </div>

                {{-- Billing / Contact --}}
                <div class="bg-white dark:bg-gray-950 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-6 space-y-4">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        {{ __('Billing & contact') }}
                    </h2>

                    <div class="space-y-4">
                        <div>
                            <x-label for="billing_email" :value="__('Billing email')" />
                            <x-input
                                id="billing_email"
                                name="billing_email"
                                type="email"
                                class="mt-1 block w-full"
                                :value="old('billing_email', $company->billing_email)"
                                placeholder="billing@example.com"
                            />
                        </div>

                        <div>
                            <x-label for="country" :value="__('Country (ISO code)')" />
                            <x-input
                                id="country"
                                name="country"
                                type="text"
                                maxlength="2"
                                class="mt-1 block w-full uppercase"
                                :value="old('country', $company->country)"
                                placeholder="KE"
                            />
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                {{ __('Use 2-letter ISO country code, e.g. KE, US, GB.') }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Localization --}}
                <div class="bg-white dark:bg-gray-950 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-6 space-y-4">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        {{ __('Localization') }}
                    </h2>

                    <div class="space-y-4">
                        <div>
                            <x-label for="timezone" :value="__('Timezone')" />
                            <x-input
                                id="timezone"
                                name="timezone"
                                type="text"
                                class="mt-1 block w-full"
                                :value="old('timezone', $company->timezone ?? config('app.timezone'))"
                                placeholder="Africa/Nairobi"
                            />
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                {{ __('Use a valid PHP timezone identifier, e.g. Africa/Nairobi.') }}
                            </p>
                        </div>

                        <div>
                            <x-label for="currency" :value="__('Currency (ISO code)')" />
                            <x-input
                                id="currency"
                                name="currency"
                                type="text"
                                maxlength="3"
                                class="mt-1 block w-full uppercase"
                                :value="old('currency', $company->currency ?? config('app.currency', 'USD'))"
                                placeholder="KES"
                            />
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                {{ __('Use 3-letter ISO currency code, e.g. KES, USD, EUR.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Address --}}
            <div class="bg-white dark:bg-gray-950 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-6 space-y-4">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                    {{ __('Registered address') }}
                </h2>

                <div class="grid gap-4 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <x-label for="address_line1" :value="__('Address line 1')" />
                        <x-input
                            id="address_line1"
                            name="address_line1"
                            type="text"
                            class="mt-1 block w-full"
                            :value="old('address_line1', $company->address_line1)"
                        />
                    </div>

                    <div class="md:col-span-2">
                        <x-label for="address_line2" :value="__('Address line 2')" />
                        <x-input
                            id="address_line2"
                            name="address_line2"
                            type="text"
                            class="mt-1 block w-full"
                            :value="old('address_line2', $company->address_line2)"
                        />
                    </div>

                    <div>
                        <x-label for="city" :value="__('City')" />
                        <x-input
                            id="city"
                            name="city"
                            type="text"
                            class="mt-1 block w-full"
                            :value="old('city', $company->city)"
                        />
                    </div>

                    <div>
                        <x-label for="state" :value="__('State / Region')" />
                        <x-input
                            id="state"
                            name="state"
                            type="text"
                            class="mt-1 block w-full"
                            :value="old('state', $company->state)"
                        />
                    </div>

                    <div>
                        <x-label for="postal_code" :value="__('Postal code')" />
                        <x-input
                            id="postal_code"
                            name="postal_code"
                            type="text"
                            class="mt-1 block w-full"
                            :value="old('postal_code', $company->postal_code)"
                        />
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3">
                <a
                    href="{{ route('companies.company.admin.dashboard.path', ['company' => $company->slug]) }}"
                    class="inline-flex items-center justify-center rounded-md border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:hover:bg-gray-800"
                >
                    {{ __('Cancel') }}
                </a>

                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-md bg-indigo-600 px-5 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-950"
                >
                    {{ __('Save changes') }}
                </button>
            </div>
        </form>
    </div>
@endsection

@extends('layouts.layout')

@section('title', __('Company Settings'))

@section('content')
<div class="flex-1">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-8">
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('Company Settings') }}</h1>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                {{ __('Manage your company information and preferences') }}
            </p>
        </div>

        <form action="{{ route('companies.settings.update', ['company' => currentCompany()?->slug]) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            {{-- Company Information Section --}}
            <div class="rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800 p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">{{ __('Company Information') }}</h2>
                
                <div class="space-y-6">
                    {{-- Company Name --}}
                    <div>
                        <label for="company_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Company Name') }}
                        </label>
                        <input
                            type="text"
                            id="company_name"
                            name="company_name"
                            value="{{ currentCompany()?->name ?? '' }}"
                            disabled
                            class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2.5 text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm"
                        />
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            {{ __('Contact support to change company name') }}
                        </p>
                    </div>

                    {{-- Currency --}}
                    <div>
                        <label for="currency" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Currency') }}
                        </label>
                        <select
                            id="currency"
                            name="currency"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >
                            <option value="USD" {{ (currentCompany()?->currency ?? 'USD') === 'USD' ? 'selected' : '' }}>USD - US Dollar</option>
                            <option value="EUR" {{ (currentCompany()?->currency ?? 'USD') === 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                            <option value="GBP" {{ (currentCompany()?->currency ?? 'USD') === 'GBP' ? 'selected' : '' }}>GBP - British Pound</option>
                            <option value="KES" {{ (currentCompany()?->currency ?? 'USD') === 'KES' ? 'selected' : '' }}>KES - Kenyan Shilling</option>
                            <option value="ZAR" {{ (currentCompany()?->currency ?? 'USD') === 'ZAR' ? 'selected' : '' }}>ZAR - South African Rand</option>
                            <option value="NGN" {{ (currentCompany()?->currency ?? 'USD') === 'NGN' ? 'selected' : '' }}>NGN - Nigerian Naira</option>
                        </select>
                    </div>

                    {{-- Tax Identification Number --}}
                    <div>
                        <label for="tax_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Tax Identification Number (TIN)') }}
                        </label>
                        <input
                            type="text"
                            id="tax_id"
                            name="tax_id"
                            placeholder="{{ __('e.g., A123456789') }}"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-900 placeholder-gray-400 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm focus:border-indigo-500 focus:ring-indigo-500"
                        />
                    </div>

                    {{-- Registration Number --}}
                    <div>
                        <label for="registration_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Company Registration Number') }}
                        </label>
                        <input
                            type="text"
                            id="registration_number"
                            name="registration_number"
                            placeholder="{{ __('e.g., REG123456') }}"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-900 placeholder-gray-400 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm focus:border-indigo-500 focus:ring-indigo-500"
                        />
                    </div>
                </div>
            </div>

            {{-- Payroll Settings Section --}}
            <div class="rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800 p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">{{ __('Payroll Settings') }}</h2>
                
                <div class="space-y-6">
                    {{-- Payment Frequency --}}
                    <div>
                        <label for="payment_frequency" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Default Payment Frequency') }}
                        </label>
                        <select
                            id="payment_frequency"
                            name="payment_frequency"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >
                            <option value="monthly" selected>{{ __('Monthly') }}</option>
                            <option value="bi-weekly">{{ __('Bi-weekly') }}</option>
                            <option value="weekly">{{ __('Weekly') }}</option>
                            <option value="daily">{{ __('Daily') }}</option>
                        </select>
                    </div>

                    {{-- Payment Method --}}
                    <div>
                        <label for="payment_method" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Default Payment Method') }}
                        </label>
                        <select
                            id="payment_method"
                            name="payment_method"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >
                            <option value="bank_transfer" selected>{{ __('Bank Transfer') }}</option>
                            <option value="cash">{{ __('Cash') }}</option>
                            <option value="check">{{ __('Check') }}</option>
                            <option value="mobile_money">{{ __('Mobile Money') }}</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Notification Settings Section --}}
            <div class="rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800 p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">{{ __('Notification Settings') }}</h2>
                
                <div class="space-y-4">
                    {{-- Email Notifications --}}
                    <div class="flex items-center">
                        <input
                            type="checkbox"
                            id="email_notifications"
                            name="email_notifications"
                            checked
                            class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                        />
                        <label for="email_notifications" class="ml-3 text-sm text-gray-700 dark:text-gray-300">
                            {{ __('Send email notifications for payroll events') }}
                        </label>
                    </div>

                    {{-- Payslip Notifications --}}
                    <div class="flex items-center">
                        <input
                            type="checkbox"
                            id="payslip_notifications"
                            name="payslip_notifications"
                            checked
                            class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                        />
                        <label for="payslip_notifications" class="ml-3 text-sm text-gray-700 dark:text-gray-300">
                            {{ __('Notify employees when payslips are ready') }}
                        </label>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center justify-end gap-3">
                <a
                    href="{{ route('companies.company.admin.dashboard.path', ['company' => currentCompany()?->slug]) }}"
                    class="rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700"
                >
                    {{ __('Cancel') }}
                </a>
                <button
                    type="submit"
                    class="rounded-lg bg-indigo-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
                >
                    {{ __('Save Changes') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
