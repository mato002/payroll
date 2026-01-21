@extends('layouts.marketing')

@section('title', 'Log in – ' . config('app.name'))

@section('content')
    <section class="bg-gray-50">
        <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-20">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 text-center">Welcome back</h1>
            <p class="mt-2 text-sm text-gray-600 text-center">
                Log in to manage payroll, employees, and payslips.
            </p>

            <div class="mt-8 bg-white shadow-sm border rounded-xl p-6 sm:p-8">
                @if (session('status'))
                    <div class="mb-4 rounded-md bg-green-50 p-3 text-sm text-green-700" role="status">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 rounded-md bg-red-50 p-3 text-sm text-red-700" role="alert">
                        <p class="font-medium">There were some problems with your input.</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-4" x-data="{ showPassword: false }" novalidate>
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Work email</label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="email"
                            class="mt-1 block w-full rounded-md border-gray-300 @error('email') border-red-500 @enderror shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                            @error('email') aria-invalid="true" aria-describedby="email-error" @enderror
                        >
                        @error('email')
                            <p id="email-error" class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <div class="mt-1 relative">
                            <input
                                :type="showPassword ? 'text' : 'password'"
                                id="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                class="block w-full rounded-md border-gray-300 @error('password') border-red-500 @enderror shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm pr-10"
                                @error('password') aria-invalid="true" aria-describedby="password-error" @enderror
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
                        @error('password')
                            <p id="password-error" class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center text-xs text-gray-600">
                            <input id="remember_me" type="checkbox" name="remember"
                                   class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <span class="ml-2">Remember me</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                               class="text-xs font-medium text-indigo-600 hover:text-indigo-500">
                                Forgot your password?
                            </a>
                        @endif
                    </div>

                    <button
                        type="submit"
                        class="w-full mt-2 inline-flex items-center justify-center px-4 py-2.5 rounded-md text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Log in
                    </button>
                </form>

                @if (Route::has('company.signup'))
                    <p class="mt-6 text-xs text-gray-600 text-center">
                        New company? <a href="{{ route('company.signup') }}" class="font-medium text-indigo-600 hover:text-indigo-500">Start your free trial</a>.
                    </p>
                @endif
            </div>
        </div>
    </section>
@endsection

