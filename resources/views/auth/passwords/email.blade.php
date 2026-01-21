@extends('layouts.marketing')

@section('title', 'Forgot password – ' . config('app.name'))

@section('content')
    <section class="bg-gray-50">
        <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-20">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 text-center">Reset your password</h1>
            <p class="mt-2 text-sm text-gray-600 text-center">
                Enter the email associated with your account and we’ll send you a reset link.
            </p>

            <div class="mt-8 bg-white shadow-sm border rounded-xl p-6 sm:p-8">
                @if (session('status'))
                    <div class="mb-4 rounded-md bg-green-50 p-3 text-sm text-green-700" role="status">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 rounded-md bg-red-50 p-3 text-sm text-red-700" role="alert">
                        <p class="font-medium">We couldn’t process your request.</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="space-y-4" novalidate>
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

                    <button
                        type="submit"
                        class="w-full mt-2 inline-flex items-center justify-center px-4 py-2.5 rounded-md text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Send reset link
                    </button>
                </form>

                @if (Route::has('login'))
                    <p class="mt-6 text-xs text-gray-600 text-center">
                        Remembered your password?
                        <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">Back to login</a>.
                    </p>
                @endif
            </div>
        </div>
    </section>
@endsection

