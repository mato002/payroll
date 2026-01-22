<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', config('app.name') . ' – Payroll Management System')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50 text-gray-900">
    <header class="sticky top-0 z-50 border-b border-gray-200 bg-white/95 backdrop-blur-sm shadow-sm">
        <div class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 2xl:px-16 flex items-center justify-between h-16">
            <a href="{{ route('landing') }}" class="flex items-center space-x-3 group">
                <span class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-600 to-indigo-700 text-white font-bold shadow-lg shadow-indigo-500/25 group-hover:shadow-xl group-hover:scale-105 transition-all duration-200">
                    MP
                </span>
                <span class="text-lg font-bold tracking-tight text-gray-900 group-hover:text-indigo-600 transition-colors">{{ config('app.name', 'MatechPay') }}</span>
            </a>

            <nav class="hidden md:flex items-center space-x-1">
                <a href="{{ route('landing') }}" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors duration-200">Home</a>
                <a href="{{ route('features') }}" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors duration-200">Features</a>
                <a href="{{ route('pricing') }}" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors duration-200">Pricing</a>
                <a href="{{ route('contact') }}" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors duration-200">Contact</a>
            </nav>

            <div class="hidden md:flex items-center space-x-4">
                @if (Route::has('login'))
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-700 hover:text-indigo-600 transition-colors duration-200">
                        Log in
                    </a>
                @endif
                @if (Route::has('company.signup'))
                    <a href="{{ route('company.signup') }}"
                       class="inline-flex items-center px-5 py-2.5 rounded-lg text-sm font-semibold text-white bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 shadow-md shadow-indigo-500/25 hover:shadow-lg hover:shadow-indigo-500/30 transition-all duration-200 transform hover:-translate-y-0.5">
                        Start free trial
                    </a>
                @endif
            </div>
        </div>

        <!-- Simple mobile nav (always visible on small screens) -->
        <div class="md:hidden border-t border-gray-200 bg-white">
            <div class="w-full px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-gradient-to-br from-indigo-600 to-indigo-700 text-white text-xs font-bold shadow-md">
                        MP
                    </span>
                    <span class="text-sm font-bold tracking-tight text-gray-900">{{ config('app.name', 'MatechPay') }}</span>
                </div>
                <div class="flex items-center space-x-3">
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="text-xs font-semibold text-gray-700 hover:text-indigo-600 transition-colors">
                            Log in
                        </a>
                    @endif
                    @if (Route::has('company.signup'))
                        <a href="{{ route('company.signup') }}"
                           class="inline-flex items-center px-4 py-2 rounded-lg text-xs font-semibold text-white bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 shadow-md">
                            Free trial
                        </a>
                    @endif
                </div>
            </div>
            <nav class="w-full px-4 sm:px-6 lg:px-8 pb-3">
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('landing') }}" class="px-3 py-1.5 text-xs font-medium text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 rounded-md transition-colors">Home</a>
                    <a href="{{ route('features') }}" class="px-3 py-1.5 text-xs font-medium text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 rounded-md transition-colors">Features</a>
                    <a href="{{ route('pricing') }}" class="px-3 py-1.5 text-xs font-medium text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 rounded-md transition-colors">Pricing</a>
                    <a href="{{ route('contact') }}" class="px-3 py-1.5 text-xs font-medium text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 rounded-md transition-colors">Contact</a>
                </div>
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="border-t bg-gray-50 mt-16">
        <div class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 2xl:px-16 py-12 lg:py-16">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12 mb-8">
                    <!-- Company Info -->
                    <div class="lg:col-span-1">
                        <a href="{{ route('landing') }}" class="flex items-center space-x-3 mb-4">
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-600 to-indigo-700 text-white font-bold shadow-lg shadow-indigo-500/25">
                                MP
                            </span>
                            <span class="text-lg font-bold tracking-tight text-gray-900">{{ config('app.name', 'MatechPay') }}</span>
                        </a>
                        <p class="text-sm text-gray-600 mb-4 leading-relaxed">
                            Automate payroll calculations, taxes, and compliance so your team gets paid accurately, every time.
                        </p>
                        <div class="flex items-center space-x-2 text-xs text-gray-500">
                            <span>Made with</span>
                            <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                            </svg>
                            <span>by</span>
                            <a 
                                href="https://mathiasodhiambo.netlify.app/" 
                                target="_blank" 
                                rel="noopener noreferrer"
                                class="hover:text-indigo-600 transition-colors duration-200 font-medium"
                            >
                                Mathias Odhiambo
                            </a>
                        </div>
                    </div>

                    <!-- Product -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Product</h3>
                        <ul class="space-y-3">
                            <li>
                                <a href="{{ route('features') }}" class="text-sm text-gray-600 hover:text-indigo-600 transition-colors duration-200">
                                    Features
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('pricing') }}" class="text-sm text-gray-600 hover:text-indigo-600 transition-colors duration-200">
                                    Pricing
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('contact') }}" class="text-sm text-gray-600 hover:text-indigo-600 transition-colors duration-200">
                                    Contact
                                </a>
                            </li>
                            @if (Route::has('company.signup'))
                                <li>
                                    <a href="{{ route('company.signup') }}" class="text-sm text-gray-600 hover:text-indigo-600 transition-colors duration-200">
                                        Start Free Trial
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>

                    <!-- Resources -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Resources</h3>
                        <ul class="space-y-3">
                            <li>
                                <a href="#" class="text-sm text-gray-600 hover:text-indigo-600 transition-colors duration-200">
                                    Documentation
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-sm text-gray-600 hover:text-indigo-600 transition-colors duration-200">
                                    Help Center
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-sm text-gray-600 hover:text-indigo-600 transition-colors duration-200">
                                    API Reference
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-sm text-gray-600 hover:text-indigo-600 transition-colors duration-200">
                                    Status
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Legal -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Legal</h3>
                        <ul class="space-y-3">
                            <li>
                                <a href="{{ route('security') }}" class="text-sm text-gray-600 hover:text-indigo-600 transition-colors duration-200">
                                    Security
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('privacy') }}" class="text-sm text-gray-600 hover:text-indigo-600 transition-colors duration-200">
                                    Privacy Policy
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('terms') }}" class="text-sm text-gray-600 hover:text-indigo-600 transition-colors duration-200">
                                    Terms of Service
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-sm text-gray-600 hover:text-indigo-600 transition-colors duration-200">
                                    Cookie Policy
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Bottom Bar -->
                <div class="border-t border-gray-200 pt-8 mt-8 flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">
                    <p class="text-sm text-gray-500">
                        &copy; {{ date('Y') }} {{ config('app.name', 'MatechPay') }}. All rights reserved.
                    </p>
                    <div class="flex items-center space-x-6 text-sm text-gray-500">
                        <a href="{{ route('security') }}" class="hover:text-indigo-600 transition-colors duration-200">Security</a>
                        <a href="{{ route('privacy') }}" class="hover:text-indigo-600 transition-colors duration-200">Privacy</a>
                        <a href="{{ route('terms') }}" class="hover:text-indigo-600 transition-colors duration-200">Terms</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>

