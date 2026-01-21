<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', config('app.name') . ' – Modern SaaS Payroll')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50 text-gray-900">
    <header class="border-b bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
            <a href="{{ route('landing') }}" class="flex items-center space-x-2">
                <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-indigo-600 text-white font-bold">
                    P
                </span>
                <span class="text-lg font-semibold tracking-tight">{{ config('app.name', 'PayrollPro') }}</span>
            </a>

            <nav class="hidden md:flex items-center space-x-8 text-sm font-medium">
                <a href="{{ route('landing') }}" class="hover:text-indigo-600">Home</a>
                <a href="{{ route('features') }}" class="hover:text-indigo-600">Features</a>
                <a href="{{ route('pricing') }}" class="hover:text-indigo-600">Pricing</a>
                <a href="{{ route('contact') }}" class="hover:text-indigo-600">Contact</a>
            </nav>

            <div class="hidden md:flex items-center space-x-3">
                @if (Route::has('login'))
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-indigo-600">
                        Log in
                    </a>
                @endif
                @if (Route::has('company.signup'))
                    <a href="{{ route('company.signup') }}"
                       class="inline-flex items-center px-4 py-2 rounded-md text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm">
                        Start free trial
                    </a>
                @endif
            </div>
        </div>

        <!-- Simple mobile nav (always visible on small screens) -->
        <div class="md:hidden border-t bg-white">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-indigo-600 text-white text-sm font-bold">
                        P
                    </span>
                    <span class="text-sm font-semibold tracking-tight">{{ config('app.name', 'PayrollPro') }}</span>
                </div>
                <div class="flex items-center space-x-2">
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="text-xs font-medium text-gray-700 hover:text-indigo-600">
                            Log in
                        </a>
                    @endif
                    @if (Route::has('company.signup'))
                        <a href="{{ route('company.signup') }}"
                           class="inline-flex items-center px-3 py-1.5 rounded-md text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700">
                            Free trial
                        </a>
                    @endif
                </div>
            </div>
            <nav class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pb-3 text-sm">
                <div class="flex flex-wrap gap-3 text-gray-700">
                    <a href="{{ route('landing') }}" class="hover:text-indigo-600">Home</a>
                    <a href="{{ route('features') }}" class="hover:text-indigo-600">Features</a>
                    <a href="{{ route('pricing') }}" class="hover:text-indigo-600">Pricing</a>
                    <a href="{{ route('contact') }}" class="hover:text-indigo-600">Contact</a>
                </div>
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="border-t bg-white mt-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0 text-sm text-gray-500">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'PayrollPro') }}. All rights reserved.</p>
            <div class="flex items-center space-x-4">
                <a href="#" class="hover:text-indigo-600">Security</a>
                <a href="#" class="hover:text-indigo-600">Privacy</a>
                <a href="#" class="hover:text-indigo-600">Terms</a>
            </div>
        </div>
    </footer>
</body>
</html>

