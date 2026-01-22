@extends('layouts.layout')

@section('title', 'Platform Settings')

@section('content')
    <main class="flex-1">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 space-y-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Platform Settings</h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Configure platform-wide settings and preferences.
                </p>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <!-- General Settings -->
                <div class="bg-white dark:bg-gray-950 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">General Settings</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Platform Name
                            </label>
                            <input type="text" value="{{ config('app.name') }}" disabled
                                   class="block w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 px-4 py-2 text-sm">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Configured in environment file</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Default Timezone
                            </label>
                            <input type="text" value="{{ config('app.timezone') }}" disabled
                                   class="block w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 px-4 py-2 text-sm">
                        </div>
                    </div>
                </div>

                <!-- Billing Settings -->
                <div class="bg-white dark:bg-gray-950 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Billing Settings</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Default Currency
                            </label>
                            <input type="text" value="USD" disabled
                                   class="block w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 px-4 py-2 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Trial Period (days)
                            </label>
                            <input type="number" value="14" disabled
                                   class="block w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 px-4 py-2 text-sm">
                        </div>
                    </div>
                </div>

                <!-- Security Settings -->
                <div class="bg-white dark:bg-gray-950 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Security Settings</h2>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Two-Factor Authentication
                                </label>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Require 2FA for admin users</p>
                            </div>
                            <input type="checkbox" disabled class="h-4 w-4 text-indigo-600">
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Password Policy
                                </label>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Enforce strong passwords</p>
                            </div>
                            <input type="checkbox" checked disabled class="h-4 w-4 text-indigo-600">
                        </div>
                    </div>
                </div>

                <!-- System Information -->
                <div class="bg-white dark:bg-gray-950 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">System Information</h2>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Laravel Version</span>
                            <span class="font-medium text-gray-900 dark:text-gray-100">{{ app()->version() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">PHP Version</span>
                            <span class="font-medium text-gray-900 dark:text-gray-100">{{ PHP_VERSION }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Environment</span>
                            <span class="font-medium text-gray-900 dark:text-gray-100">{{ config('app.env') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
