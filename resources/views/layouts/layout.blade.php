<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    x-data="{
        sidebarOpen: false,
        darkMode: localStorage.getItem('theme') === 'dark' ||
                  (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
        toggleDarkMode() {
            this.darkMode = !this.darkMode;
            localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
            document.documentElement.classList.toggle('dark', this.darkMode);
        }
    }"
    x-init="document.documentElement.classList.toggle('dark', darkMode)"
    class="h-full antialiased"
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@isset($title){{ $title }}@else@yield('title', config('app.name', 'Payroll SaaS'))@endisset</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    {{-- Tailwind / App assets (adjust if needed) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Alpine.js (if not already bundled via Vite) --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Alpine.js x-cloak styles --}}
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="h-full bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100">

    <div class="min-h-screen flex flex-col">

        {{-- Top Navigation Bar (fixed) --}}
        <header class="sticky top-0 z-30 border-b border-gray-200 bg-white/80 backdrop-blur dark:bg-gray-900/80">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">

                    {{-- Left: Brand + Mobile sidebar toggle --}}
                    <div class="flex items-center space-x-3">
                        <button
                            type="button"
                            class="inline-flex items-center justify-center rounded-md p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:hover:bg-gray-800 dark:hover:text-white lg:hidden"
                            @click="sidebarOpen = true"
                        >
                            <span class="sr-only">Open sidebar</span>
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                        </button>

                        <a href="{{ url('/') }}" class="flex items-center space-x-2">
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-600 text-white font-semibold">
                                PS
                            </span>
                            <span class="text-base font-semibold tracking-tight">
                                {{ config('app.name', 'Payroll SaaS') }}
                            </span>
                        </a>
                    </div>

                    {{-- Middle: Company switcher --}}
                    <div class="hidden md:flex items-center space-x-2">
                        <x-company-switcher />
                    </div>

                    {{-- Right: Dark mode toggle + User --}}
                    <div class="flex items-center space-x-4">
                        <button
                            type="button"
                            @click="toggleDarkMode()"
                            class="inline-flex items-center justify-center rounded-full border border-gray-200 bg-white p-2 text-gray-500 shadow-sm hover:bg-gray-50 hover:text-gray-900 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
                        >
                            <span class="sr-only">Toggle dark mode</span>
                            <svg x-show="!darkMode" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M12 3.75v.75m0 15v.75m8.25-8.25h-.75m-15 0H3.75M18.364 5.636l-.53.53M6.166 17.834l-.53.53M18.364 18.364l-.53-.53M6.166 6.166l-.53-.53M12 7.5a4.5 4.5 0 100 9 4.5 4.5 0 000-9z" />
                            </svg>
                            <svg x-show="darkMode" x-cloak class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                 fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M21.752 15.002A9.718 9.718 0 0112 21.75 9.75 9.75 0 1118.748 3a7.5 7.5 0 003.004 12.002z" />
                            </svg>
                        </button>

                        @auth
                            <div class="flex items-center space-x-2" x-data="{ open: false }">
                                <span class="hidden text-sm font-medium text-gray-700 dark:text-gray-200 sm:inline">
                                    {{ Auth::user()->name ?? 'User' }}
                                </span>
                                <button
                                    type="button"
                                    @click="open = !open"
                                    class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-600 text-sm font-semibold text-white hover:bg-indigo-700"
                                >
                                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                                </button>

                                {{-- User dropdown menu --}}
                                <div
                                    x-show="open"
                                    @click.away="open = false"
                                    x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-95"
                                    class="absolute right-4 mt-2 w-48 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none dark:bg-gray-800 dark:ring-gray-700 z-50"
                                    style="display: none;"
                                >
                                    <div class="py-1">
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
                                            Profile
                                        </a>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
                                            Settings
                                        </a>
                                        @if(Route::has('logout'))
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
                                                    Logout
                                                </button>
                                            </form>
                                        @else
                                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
                                                Logout
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @else
                            @if(Route::has('login'))
                                <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-200 dark:hover:text-white">
                                    Login
                                </a>
                            @endif
                        @endauth
                    </div>

                </div>
            </div>
        </header>

        <div class="flex flex-1">

            {{-- Sidebar (desktop) --}}
            <aside class="hidden w-64 shrink-0 border-r border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-950 lg:flex lg:flex-col">
                <div class="flex-1 overflow-y-auto py-4">
                    <nav class="space-y-1 px-3 text-sm">
                        @auth
                            @php($currentCompanySlug = request()->route('company'))

                            {{-- Platform (super admin) navigation --}}
                            @if(request()->routeIs('admin.*') && Route::has('admin.dashboard'))
                                <a href="{{ route('admin.dashboard') }}"
                                   class="flex items-center rounded-md px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-300' : '' }}">
                                    <span class="mr-2 inline-flex h-5 w-5 items-center justify-center">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                             viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M3.75 12l8.25-8.25L20.25 12M4.5 10.5v9.75H9.75V15h4.5v5.25H19.5V10.5" />
                                        </svg>
                                    </span>
                                    <span>Dashboard</span>
                                </a>
                            @elseif($currentCompanySlug)
                                {{-- Tenant (company) navigation --}}
                                @if(Route::has('company.admin.dashboard'))
                                    <a href="{{ route('company.admin.dashboard', ['company' => $currentCompanySlug]) }}"
                                       class="flex items-center rounded-md px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 {{ request()->routeIs('company.admin.dashboard') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-300' : '' }}">
                                        <span class="mr-2 inline-flex h-5 w-5 items-center justify-center">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                 viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M3.75 12l8.25-8.25L20.25 12M4.5 10.5v9.75H9.75V15h4.5v5.25H19.5V10.5" />
                                            </svg>
                                        </span>
                                        <span>Dashboard</span>
                                    </a>
                                @endif

                                @if(Route::has('employees.import.create'))
                                    <a href="{{ route('employees.import.create', ['company' => $currentCompanySlug]) }}"
                                       class="flex items-center rounded-md px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 {{ request()->routeIs('employees.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-300' : '' }}">
                                        <span class="mr-2 inline-flex h-5 w-5 items-center justify-center">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                 viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 19.5a7.5 7.5 0 0115 0" />
                                            </svg>
                                        </span>
                                        <span>Employees</span>
                                    </a>
                                @endif

                                @if(Route::has('reports.index'))
                                    <a href="{{ route('reports.index', ['company' => $currentCompanySlug]) }}"
                                       class="flex items-center rounded-md px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 {{ request()->routeIs('reports.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-300' : '' }}">
                                        <span class="mr-2 inline-flex h-5 w-5 items-center justify-center">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                 viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M3.75 4.5h16.5M3.75 9.75h16.5m-11.25 5.25h11.25M3.75 19.5h4.5" />
                                            </svg>
                                        </span>
                                        <span>Reports</span>
                                    </a>
                                @endif

                                @if(Route::has('employee.payslips.index'))
                                    <a href="{{ route('employee.payslips.index', ['company' => $currentCompanySlug]) }}"
                                       class="flex items-center rounded-md px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 {{ request()->routeIs('employee.payslips.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-300' : '' }}">
                                        <span class="mr-2 inline-flex h-5 w-5 items-center justify-center">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                 viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M19.5 14.25v-6.75A2.25 2.25 0 0017.25 5.25H6.75A2.25 2.25 0 004.5 7.5v9A2.25 2.25 0 006.75 18.75h6.75" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M16.5 17.25 18.75 19.5 21 16.5" />
                                            </svg>
                                        </span>
                                        <span>Payslips</span>
                                    </a>
                                @endif
                            @endif
                        @endauth
                    </nav>
                </div>
            </aside>

            {{-- Sidebar (mobile) --}}
            <div
                class="relative z-40 lg:hidden"
                x-show="sidebarOpen"
                x-transition.opacity
                x-cloak
            >
                <div
                    class="fixed inset-0 bg-gray-900/60"
                    @click="sidebarOpen = false"
                    aria-hidden="true"
                ></div>

                <div
                    class="fixed inset-y-0 left-0 flex w-64 flex-col border-r border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-950"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="-translate-x-full"
                    x-transition:enter-end="translate-x-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="translate-x-0"
                    x-transition:leave-end="-translate-x-full"
                >
                    <div class="flex h-16 items-center justify-between px-4 border-b border-gray-200 dark:border-gray-800">
                        <span class="text-sm font-semibold">
                            {{ config('app.name', 'Payroll SaaS') }}
                        </span>
                        <button
                            type="button"
                            class="rounded-md p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:hover:bg-gray-800 dark:hover:text-white"
                            @click="sidebarOpen = false"
                        >
                            <span class="sr-only">Close sidebar</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="flex-1 overflow-y-auto py-4">
                        <nav class="space-y-1 px-3 text-sm">
                            @auth
                                @php($currentCompanySlug = request()->route('company'))

                                {{-- Platform (super admin) navigation --}}
                                @if(request()->routeIs('admin.*') && Route::has('admin.dashboard'))
                                    <a href="{{ route('admin.dashboard') }}"
                                       class="flex items-center rounded-md px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-300' : '' }}">
                                        <span class="mr-2 inline-flex h-5 w-5 items-center justify-center">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                 viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M3.75 12l8.25-8.25L20.25 12M4.5 10.5v9.75H9.75V15h4.5v5.25H19.5V10.5" />
                                            </svg>
                                        </span>
                                        <span>Dashboard</span>
                                    </a>
                                @elseif($currentCompanySlug)
                                    {{-- Tenant (company) navigation --}}
                                    @if(Route::has('company.admin.dashboard'))
                                        <a href="{{ route('company.admin.dashboard', ['company' => $currentCompanySlug]) }}"
                                       class="flex items-center rounded-md px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 {{ request()->routeIs('company.admin.dashboard') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-300' : '' }}">
                                        <span class="mr-2 inline-flex h-5 w-5 items-center justify-center">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                 viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M3.75 12l8.25-8.25L20.25 12M4.5 10.5v9.75H9.75V15h4.5v5.25H19.5V10.5" />
                                            </svg>
                                        </span>
                                        <span>Dashboard</span>
                                    </a>
                                    @endif

                                    @if(Route::has('employees.import.create'))
                                        <a href="{{ route('employees.import.create', ['company' => $currentCompanySlug]) }}"
                                       class="flex items-center rounded-md px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 {{ request()->routeIs('employees.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-300' : '' }}">
                                        <span class="mr-2 inline-flex h-5 w-5 items-center justify-center">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                 viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 19.5a7.5 7.5 0 0115 0" />
                                            </svg>
                                        </span>
                                        <span>Employees</span>
                                    </a>
                                    @endif

                                    @if(Route::has('reports.index'))
                                        <a href="{{ route('reports.index', ['company' => $currentCompanySlug]) }}"
                                       class="flex items-center rounded-md px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 {{ request()->routeIs('reports.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-300' : '' }}">
                                        <span class="mr-2 inline-flex h-5 w-5 items-center justify-center">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                 viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M3.75 4.5h16.5M3.75 9.75h16.5m-11.25 5.25h11.25M3.75 19.5h4.5" />
                                            </svg>
                                        </span>
                                        <span>Reports</span>
                                    </a>
                                    @endif

                                    @if(Route::has('employee.payslips.index'))
                                        <a href="{{ route('employee.payslips.index', ['company' => $currentCompanySlug]) }}"
                                       class="flex items-center rounded-md px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 {{ request()->routeIs('employee.payslips.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-300' : '' }}">
                                        <span class="mr-2 inline-flex h-5 w-5 items-center justify-center">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                 viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M19.5 14.25v-6.75A2.25 2.25 0 0017.25 5.25H6.75A2.25 2.25 0 004.5 7.5v9A2.25 2.25 0 006.75 18.75h6.75" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M16.5 17.25 18.75 19.5 21 16.5" />
                                            </svg>
                                        </span>
                                        <span>Payslips</span>
                                    </a>
                                    @endif
                                @endif
                            @endauth
                        </nav>
                    </div>
                </div>
            </div>

            {{-- Main Content --}}
            <main class="flex-1">
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    @isset($slot)
                        {{ $slot }}
                    @else
                        @yield('content')
                    @endisset
                </div>
            </main>

        </div>

        <footer class="border-t border-gray-200 bg-white py-3 text-xs text-gray-500 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-400">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
                <span>&copy; {{ now()->year }} {{ config('app.name', 'Payroll SaaS') }}. All rights reserved.</span>
                <span>v{{ config('app.version', '1.0.0') }}</span>
            </div>
        </footer>

    </div>

</body>
</html>

