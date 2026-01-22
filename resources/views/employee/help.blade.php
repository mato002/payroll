@extends('layouts.layout')

@section('title', __('Help & Support'))

@section('content')
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                    {{ __('Help & Support') }}
                </h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ __('Get help with using the payroll system') }}
                </p>
            </div>
        </div>

        {{-- Help Content --}}
        <div class="grid gap-6 grid-cols-1 lg:grid-cols-3">
            {{-- Quick Links --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="rounded-xl border border-gray-200 bg-white p-4 sm:p-6 shadow-sm dark:border-gray-800 dark:bg-gray-950">
                    <h2 class="text-sm font-semibold text-gray-900 dark:text-gray-100 mb-4">
                        {{ __('Frequently Asked Questions') }}
                    </h2>

                    <div class="space-y-4">
                        <div>
                            <h3 class="text-xs font-medium text-gray-900 dark:text-gray-100 mb-2">
                                {{ __('How do I view my payslips?') }}
                            </h3>
                            <p class="text-xs text-gray-600 dark:text-gray-300">
                                {{ __('Go to "My Payslips" in the navigation menu to view all your payslips. You can download them as PDF files.') }}
                            </p>
                        </div>

                        <div>
                            <h3 class="text-xs font-medium text-gray-900 dark:text-gray-100 mb-2">
                                {{ __('How do I update my profile?') }}
                            </h3>
                            <p class="text-xs text-gray-600 dark:text-gray-300">
                                {{ __('Click on "My Profile" in the navigation menu to update your personal information such as name, email, and phone number.') }}
                            </p>
                        </div>

                        <div>
                            <h3 class="text-xs font-medium text-gray-900 dark:text-gray-100 mb-2">
                                {{ __('What should I do if I notice an error in my payslip?') }}
                            </h3>
                            <p class="text-xs text-gray-600 dark:text-gray-300">
                                {{ __('Please contact your HR department or payroll administrator immediately. They can review and correct any discrepancies.') }}
                            </p>
                        </div>

                        <div>
                            <h3 class="text-xs font-medium text-gray-900 dark:text-gray-100 mb-2">
                                {{ __('How do I receive notifications?') }}
                            </h3>
                            <p class="text-xs text-gray-600 dark:text-gray-300">
                                {{ __('You will receive email notifications when your payslip is ready. You can also view all notifications in the "Notifications" section.') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="rounded-xl border border-gray-200 bg-white p-4 sm:p-6 shadow-sm dark:border-gray-800 dark:bg-gray-950">
                    <h2 class="text-sm font-semibold text-gray-900 dark:text-gray-100 mb-4">
                        {{ __('Contact Support') }}
                    </h2>
                    <p class="text-xs text-gray-600 dark:text-gray-300 mb-4">
                        {{ __('If you need additional assistance, please contact your company\'s HR department or payroll administrator.') }}
                    </p>
                    <div class="space-y-2">
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            <strong>{{ __('Company:') }}</strong> {{ currentCompany()?->name }}
                        </p>
                        @if(currentCompany()?->billing_email)
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                <strong>{{ __('Support Email:') }}</strong>
                                <a href="mailto:{{ currentCompany()?->billing_email }}" class="text-indigo-600 hover:text-indigo-700 dark:text-indigo-400">
                                    {{ currentCompany()?->billing_email }}
                                </a>
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="space-y-4">
                <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-800 dark:bg-gray-950">
                    <h3 class="text-xs font-semibold text-gray-900 dark:text-gray-100 mb-3">
                        {{ __('Quick Actions') }}
                    </h3>
                    <div class="space-y-2">
                        <a
                            href="{{ route('companies.employee.dashboard', ['company' => currentCompany()?->slug]) }}"
                            class="block rounded-md border border-gray-200 bg-white px-3 py-2 text-xs font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:hover:bg-gray-800"
                        >
                            {{ __('Go to Dashboard') }}
                        </a>
                        <a
                            href="{{ route('companies.employee.payslips.index', ['company' => currentCompany()?->slug]) }}"
                            class="block rounded-md border border-gray-200 bg-white px-3 py-2 text-xs font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:hover:bg-gray-800"
                        >
                            {{ __('View Payslips') }}
                        </a>
                        <a
                            href="{{ route('companies.employee.profile.show', ['company' => currentCompany()?->slug]) }}"
                            class="block rounded-md border border-gray-200 bg-white px-3 py-2 text-xs font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:hover:bg-gray-800"
                        >
                            {{ __('Update Profile') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
