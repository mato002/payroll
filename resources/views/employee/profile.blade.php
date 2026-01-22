@extends('layouts.layout')

@section('title', __('My Profile'))

@section('content')
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                    {{ __('My Profile') }}
                </h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ __('Manage your personal information') }}
                </p>
            </div>
        </div>

        {{-- Profile Form --}}
        <div class="rounded-xl border border-gray-200 bg-white p-4 sm:p-6 shadow-sm dark:border-gray-800 dark:bg-gray-950">
            <form method="POST" action="{{ route('employee.profile.update', ['company' => currentCompany()?->slug]) }}">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <div>
                        <h2 class="text-sm font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            {{ __('Personal Information') }}
                        </h2>

                        <div class="grid gap-4 grid-cols-1 sm:grid-cols-2">
                            <label class="text-xs font-medium text-gray-700 dark:text-gray-300">
                                <span class="mb-1 block">{{ __('Full Name') }}</span>
                                <input
                                    type="text"
                                    name="name"
                                    value="{{ old('name', $user->name) }}"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 text-base sm:text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 py-2.5 sm:py-1.5"
                                >
                                @error('name')
                                    <p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                                @enderror
                            </label>

                            <label class="text-xs font-medium text-gray-700 dark:text-gray-300">
                                <span class="mb-1 block">{{ __('Email Address') }}</span>
                                <input
                                    type="email"
                                    name="email"
                                    value="{{ old('email', $user->email) }}"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 text-base sm:text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 py-2.5 sm:py-1.5"
                                >
                                @error('email')
                                    <p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                                @enderror
                            </label>

                            <label class="text-xs font-medium text-gray-700 dark:text-gray-300">
                                <span class="mb-1 block">{{ __('Phone Number') }}</span>
                                <input
                                    type="tel"
                                    name="phone"
                                    value="{{ old('phone', $user->phone) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 text-base sm:text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 py-2.5 sm:py-1.5"
                                >
                                @error('phone')
                                    <p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                                @enderror
                            </label>
                        </div>
                    </div>

                    <div>
                        <h2 class="text-sm font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            {{ __('Employee Information') }}
                        </h2>

                        <div class="grid gap-4 grid-cols-1 sm:grid-cols-2">
                            <div class="rounded-lg border border-gray-200 bg-gray-50 p-3 dark:border-gray-800 dark:bg-gray-900">
                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400">
                                    {{ __('Employee Code') }}
                                </p>
                                <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $employee->employee_code }}
                                </p>
                            </div>

                            <div class="rounded-lg border border-gray-200 bg-gray-50 p-3 dark:border-gray-800 dark:bg-gray-900">
                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400">
                                    {{ __('Job Title') }}
                                </p>
                                <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $employee->job_title ?? '—' }}
                                </p>
                            </div>

                            <div class="rounded-lg border border-gray-200 bg-gray-50 p-3 dark:border-gray-800 dark:bg-gray-900">
                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400">
                                    {{ __('Department') }}
                                </p>
                                <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $employee->department_id ? 'Department #' . $employee->department_id : '—' }}
                                </p>
                            </div>

                            <div class="rounded-lg border border-gray-200 bg-gray-50 p-3 dark:border-gray-800 dark:bg-gray-900">
                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400">
                                    {{ __('Employment Status') }}
                                </p>
                                <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-gray-100">
                                    {{ ucfirst($employee->employment_status ?? '—') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-800">
                        <button
                            type="submit"
                            class="inline-flex items-center justify-center rounded-md bg-indigo-600 px-6 py-3 sm:py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 min-h-[44px] w-full sm:w-auto"
                        >
                            {{ __('Save Changes') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
