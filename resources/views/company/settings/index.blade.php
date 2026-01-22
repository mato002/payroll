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
