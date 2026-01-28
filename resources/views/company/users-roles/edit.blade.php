@extends('layouts.layout')

@section('title', __('Edit user'))

@section('content')
    <div class="mx-auto max-w-xl space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                {{ __('Edit user') }}
            </h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Update details and role for :user in :company.', ['user' => $user->name ?? $user->email, 'company' => $company->name]) }}
            </p>
        </div>

        @if ($errors->any())
            <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800 dark:border-rose-900/50 dark:bg-rose-950 dark:text-rose-200">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('companies.users-roles.update', ['company' => $company->slug, 'user' => $user->id]) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="space-y-4 rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-950">
                <div class="space-y-4">
                    <div>
                        <x-label for="name" :required="true">
                            {{ __('Full name') }}
                        </x-label>
                        <x-input
                            id="name"
                            name="name"
                            type="text"
                            class="mt-1 block w-full"
                            :value="old('name', $user->name)"
                            required
                        />
                    </div>

                    <div>
                        <x-label for="email" :required="true">
                            {{ __('Email address') }}
                        </x-label>
                        <x-input
                            id="email"
                            name="email"
                            type="email"
                            class="mt-1 block w-full"
                            :value="old('email', $user->email)"
                            required
                        />
                    </div>

                    <div>
                        <x-label for="role_id" :required="true">
                            {{ __('Role') }}
                        </x-label>
                        <select
                            id="role_id"
                            name="role_id"
                            class="mt-1 block w-full rounded-md border-gray-300 bg-white text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
                            required
                        >
                            <option value="">{{ __('Select role') }}</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" @selected(old('role_id', $currentRoleId) == $role->id)>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3">
                <a
                    href="{{ route('companies.users-roles.index', ['company' => $company->slug]) }}"
                    class="inline-flex items-center justify-center rounded-md border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:hover:bg-gray-800"
                >
                    {{ __('Cancel') }}
                </a>

                <x-button type="submit" variant="primary">
                    {{ __('Save changes') }}
                </x-button>
            </div>
        </form>
    </div>
@endsection

@extends('layouts.layout')

@section('title', __('Edit User'))

@section('content')
<div class="flex-1">
    <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8 py-8">
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('Edit User') }}</h1>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                {{ __('Update user information and permissions') }}
            </p>
        </div>

        <form action="{{ route('companies.users-roles.update', ['company' => currentCompany()?->slug, 'user' => $user]) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            {{-- User Information Section --}}
            <div class="rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800 p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">{{ __('User Information') }}</h2>
                
                <div class="space-y-6">
                    {{-- Full Name --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Full Name') }} <span class="text-red-600">*</span>
                        </label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            required
                            placeholder="{{ __('John Doe') }}"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-900 placeholder-gray-400 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm focus:border-indigo-500 focus:ring-indigo-500"
                        />
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Email Address') }} <span class="text-red-600">*</span>
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            required
                            placeholder="{{ __('john@example.com') }}"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-900 placeholder-gray-400 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm focus:border-indigo-500 focus:ring-indigo-500"
                        />
                        @error('email')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Account Status --}}
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Account Status') }}
                        </label>
                        <select
                            id="status"
                            name="status"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >
                            <option value="active" selected>{{ __('Active') }}</option>
                            <option value="inactive">{{ __('Inactive') }}</option>
                            <option value="suspended">{{ __('Suspended') }}</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Role Assignment Section --}}
            <div class="rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800 p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">{{ __('Assign Role') }}</h2>
                
                <div class="space-y-4">
                    {{-- Admin Role --}}
                    <label class="flex items-start gap-3 p-4 rounded-lg border-2 border-transparent hover:border-indigo-200 hover:bg-indigo-50 dark:hover:border-indigo-900 dark:hover:bg-indigo-900/20 cursor-pointer transition">
                        <input
                            type="radio"
                            name="role"
                            value="company_admin"
                            class="mt-1 h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500"
                        />
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900 dark:text-white">{{ __('Admin') }}</h3>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Full access to payroll management, employee records, and reports.') }}
                            </p>
                        </div>
                    </label>

                    {{-- HR Role --}}
                    <label class="flex items-start gap-3 p-4 rounded-lg border-2 border-transparent hover:border-blue-200 hover:bg-blue-50 dark:hover:border-blue-900 dark:hover:bg-blue-900/20 cursor-pointer transition">
                        <input
                            type="radio"
                            name="role"
                            value="hr"
                            class="mt-1 h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500"
                        />
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900 dark:text-white">{{ __('HR Manager') }}</h3>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Manage employees, payroll runs, and view reports.') }}
                            </p>
                        </div>
                    </label>

                    {{-- Finance Role --}}
                    <label class="flex items-start gap-3 p-4 rounded-lg border-2 border-transparent hover:border-green-200 hover:bg-green-50 dark:hover:border-green-900 dark:hover:bg-green-900/20 cursor-pointer transition">
                        <input
                            type="radio"
                            name="role"
                            value="finance"
                            class="mt-1 h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500"
                        />
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900 dark:text-white">{{ __('Finance Officer') }}</h3>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Approve payroll runs and view financial reports.') }}
                            </p>
                        </div>
                    </label>

                    {{-- Employee Role --}}
                    <label class="flex items-start gap-3 p-4 rounded-lg border-2 border-transparent hover:border-purple-200 hover:bg-purple-50 dark:hover:border-purple-900 dark:hover:bg-purple-900/20 cursor-pointer transition">
                        <input
                            type="radio"
                            name="role"
                            value="employee"
                            class="mt-1 h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500"
                        />
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900 dark:text-white">{{ __('Employee') }}</h3>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('View own payslips and profile information.') }}
                            </p>
                        </div>
                    </label>

                    @error('role')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Permissions Summary --}}
            <div class="rounded-lg border border-amber-200 bg-amber-50 p-6 dark:border-amber-900/30 dark:bg-amber-900/20">
                <h3 class="font-semibold text-amber-900 dark:text-amber-100 mb-3">
                    {{ __('Permissions Overview') }}
                </h3>
                <div class="text-sm text-amber-800 dark:text-amber-200 space-y-2">
                    <p><strong>{{ __('Admin:') }}</strong> {{ __('Full system access') }}</p>
                    <p><strong>{{ __('HR Manager:') }}</strong> {{ __('Employee and payroll management') }}</p>
                    <p><strong>{{ __('Finance Officer:') }}</strong> {{ __('Payroll approval and reporting') }}</p>
                    <p><strong>{{ __('Employee:') }}</strong> {{ __('Self-service access only') }}</p>
                </div>
            </div>

            {{-- Danger Zone --}}
            <div class="rounded-lg border border-red-200 bg-red-50 p-6 dark:border-red-900/30 dark:bg-red-900/20">
                <h3 class="font-semibold text-red-900 dark:text-red-100 mb-4">{{ __('Danger Zone') }}</h3>
                <p class="text-sm text-red-800 dark:text-red-200 mb-4">
                    {{ __('Remove this user from your company. This action cannot be undone.') }}
                </p>
                <button
                    type="button"
                    onclick="if(confirm('{{ __('Are you sure you want to remove this user?') }}')) { document.getElementById('deleteForm').submit(); }"
                    class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700"
                >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    {{ __('Remove User') }}
                </button>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center justify-end gap-3">
                <a
                    href="{{ route('companies.users-roles.index', ['company' => currentCompany()?->slug]) }}"
                    class="rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700"
                >
                    {{ __('Cancel') }}
                </a>
                <button
                    type="submit"
                    class="rounded-lg bg-indigo-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900"
                >
                    {{ __('Save Changes') }}
                </button>
            </div>
        </form>

        {{-- Hidden Delete Form --}}
        <form id="deleteForm" action="{{ route('companies.users-roles.destroy', ['company' => currentCompany()?->slug, 'user' => $user]) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>
@endsection
