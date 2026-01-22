<!DOCTYPE html>
<html
    lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>"
    x-data="{
        sidebarOpen: false,
        sidebarCollapsed: localStorage.getItem('sidebarCollapsed') === 'true',
        darkMode: localStorage.getItem('theme') === 'dark' ||
                  (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
        toggleDarkMode() {
            this.darkMode = !this.darkMode;
            localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
            document.documentElement.classList.toggle('dark', this.darkMode);
        },
        toggleSidebar() {
            this.sidebarCollapsed = !this.sidebarCollapsed;
            localStorage.setItem('sidebarCollapsed', this.sidebarCollapsed);
        }
    }"
    x-init="
        if (sidebarCollapsed) {
            document.documentElement.classList.add('sidebar-collapsed');
        }
    "
    x-init="document.documentElement.classList.toggle('dark', darkMode)"
    class="h-full antialiased"
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $__env->yieldContent('title', config('app.name', 'MatechPay')); ?></title>

    
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    
    <style>
        [x-cloak] { display: none !important; }
        
        /* Custom Scrollbar Styles */
        .scrollbar-thin {
            scrollbar-width: thin;
        }
        
        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        
        .scrollbar-thin::-webkit-scrollbar-track {
            background: rgb(243 244 246);
        }
        
        .dark .scrollbar-thin::-webkit-scrollbar-track {
            background: rgb(17 24 39);
        }
        
        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: rgb(209 213 219);
            border-radius: 3px;
        }
        
        .dark .scrollbar-thin::-webkit-scrollbar-thumb {
            background: rgb(55 65 81);
        }
        
        .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background: rgb(156 163 175);
        }
        
        .dark .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background: rgb(75 85 99);
        }
        
        /* Ensure body and html take full height */
        html, body {
            height: 100%;
            overflow: hidden;
        }
    </style>
</head>
<body class="h-full bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100 overflow-hidden">

    <div class="h-full flex flex-col">

        
        <header class="sticky top-0 z-30 w-full border-b border-gray-200 bg-white/80 backdrop-blur dark:bg-gray-900/80">
            <div class="w-full px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">

                    
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

                        <a href="<?php echo e(url('/')); ?>" class="flex items-center space-x-2">
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-600 text-white font-semibold">
                                PS
                            </span>
                            <span class="text-base font-semibold tracking-tight">
                                <?php echo e(config('app.name', 'MatechPay')); ?>

                            </span>
                        </a>
                    </div>

                    
                    <div class="hidden md:flex items-center space-x-2">
                        <?php if (isset($component)) { $__componentOriginal0dce543ca6aeb9571f6d10a1fd3ed6d0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0dce543ca6aeb9571f6d10a1fd3ed6d0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.company-switcher','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('company-switcher'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0dce543ca6aeb9571f6d10a1fd3ed6d0)): ?>
<?php $attributes = $__attributesOriginal0dce543ca6aeb9571f6d10a1fd3ed6d0; ?>
<?php unset($__attributesOriginal0dce543ca6aeb9571f6d10a1fd3ed6d0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0dce543ca6aeb9571f6d10a1fd3ed6d0)): ?>
<?php $component = $__componentOriginal0dce543ca6aeb9571f6d10a1fd3ed6d0; ?>
<?php unset($__componentOriginal0dce543ca6aeb9571f6d10a1fd3ed6d0); ?>
<?php endif; ?>
                    </div>
                    
                    
                    <div class="md:hidden">
                        <?php if (isset($component)) { $__componentOriginal0dce543ca6aeb9571f6d10a1fd3ed6d0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0dce543ca6aeb9571f6d10a1fd3ed6d0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.company-switcher','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('company-switcher'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0dce543ca6aeb9571f6d10a1fd3ed6d0)): ?>
<?php $attributes = $__attributesOriginal0dce543ca6aeb9571f6d10a1fd3ed6d0; ?>
<?php unset($__attributesOriginal0dce543ca6aeb9571f6d10a1fd3ed6d0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0dce543ca6aeb9571f6d10a1fd3ed6d0)): ?>
<?php $component = $__componentOriginal0dce543ca6aeb9571f6d10a1fd3ed6d0; ?>
<?php unset($__componentOriginal0dce543ca6aeb9571f6d10a1fd3ed6d0); ?>
<?php endif; ?>
                    </div>

                    
                    <div class="flex items-center space-x-4">
                        <?php if(auth()->guard()->check()): ?>
                            <?php if (isset($component)) { $__componentOriginal6541145ad4a57bfb6e6f221ba77eb386 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6541145ad4a57bfb6e6f221ba77eb386 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.notification-bell','data' => ['notifications' => [
                                [
                                    'id' => 1,
                                    'title' => 'Payroll Run Completed',
                                    'message' => 'Your monthly payroll run for December 2024 has been successfully processed.',
                                    'read' => false,
                                    'time' => '2 minutes ago',
                                    'action_url' => '#'
                                ],
                                [
                                    'id' => 2,
                                    'title' => 'New Employee Added',
                                    'message' => 'John Doe has been added to your employee list.',
                                    'read' => false,
                                    'time' => '1 hour ago',
                                    'action_url' => '#'
                                ],
                                [
                                    'id' => 3,
                                    'title' => 'Report Generated',
                                    'message' => 'Your annual tax report is ready for download.',
                                    'read' => true,
                                    'time' => '3 hours ago',
                                    'action_url' => '#'
                                ],
                            ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('notification-bell'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['notifications' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                                [
                                    'id' => 1,
                                    'title' => 'Payroll Run Completed',
                                    'message' => 'Your monthly payroll run for December 2024 has been successfully processed.',
                                    'read' => false,
                                    'time' => '2 minutes ago',
                                    'action_url' => '#'
                                ],
                                [
                                    'id' => 2,
                                    'title' => 'New Employee Added',
                                    'message' => 'John Doe has been added to your employee list.',
                                    'read' => false,
                                    'time' => '1 hour ago',
                                    'action_url' => '#'
                                ],
                                [
                                    'id' => 3,
                                    'title' => 'Report Generated',
                                    'message' => 'Your annual tax report is ready for download.',
                                    'read' => true,
                                    'time' => '3 hours ago',
                                    'action_url' => '#'
                                ],
                            ])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6541145ad4a57bfb6e6f221ba77eb386)): ?>
<?php $attributes = $__attributesOriginal6541145ad4a57bfb6e6f221ba77eb386; ?>
<?php unset($__attributesOriginal6541145ad4a57bfb6e6f221ba77eb386); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6541145ad4a57bfb6e6f221ba77eb386)): ?>
<?php $component = $__componentOriginal6541145ad4a57bfb6e6f221ba77eb386; ?>
<?php unset($__componentOriginal6541145ad4a57bfb6e6f221ba77eb386); ?>
<?php endif; ?>
                        <?php endif; ?>
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

                        <?php if(auth()->guard()->check()): ?>
                            <div class="flex items-center space-x-2" x-data="{ open: false }">
                                <span class="hidden text-sm font-medium text-gray-700 dark:text-gray-200 sm:inline">
                                    <?php echo e(Auth::user()->name ?? 'User'); ?>

                                </span>
                                <button
                                    type="button"
                                    @click="open = !open"
                                    class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-600 text-sm font-semibold text-white hover:bg-indigo-700"
                                >
                                    <?php echo e(strtoupper(substr(Auth::user()->name ?? 'U', 0, 1))); ?>

                                </button>

                                
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
                                        <?php if(Route::has('logout')): ?>
                                            <form method="POST" action="<?php echo e(route('logout')); ?>">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
                                                    Logout
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
                                                Logout
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <?php if(Route::has('login')): ?>
                                <a href="<?php echo e(route('login')); ?>" class="text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-200 dark:hover:text-white">
                                    Login
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </header>

        <div class="flex flex-1 overflow-hidden">

            
            <aside 
                class="hidden fixed left-0 top-16 bottom-0 w-64 shrink-0 border-r border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-950 lg:flex lg:flex-col transition-all duration-300 z-20"
                :class="sidebarCollapsed ? 'lg:w-16' : 'lg:w-64'"
            >
                
                <div class="flex items-center justify-between border-b border-gray-200 px-4 py-4 dark:border-gray-800 flex-shrink-0">
                    <a href="<?php echo e(url('/')); ?>" class="flex items-center space-x-2 flex-shrink-0" :class="sidebarCollapsed ? 'justify-center w-full' : ''">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-600 text-white font-semibold flex-shrink-0">
                            PS
                        </span>
                        <span class="text-sm font-semibold tracking-tight whitespace-nowrap transition-opacity duration-300" 
                              :class="sidebarCollapsed ? 'opacity-0 w-0 overflow-hidden' : 'opacity-100'">
                            <?php echo e(config('app.name', 'MatechPay')); ?>

                        </span>
                    </a>
                    <button
                        type="button"
                        @click="toggleSidebar()"
                        class="hidden lg:flex items-center justify-center rounded-md p-1.5 text-gray-400 hover:bg-gray-100 hover:text-gray-500 dark:hover:bg-gray-800 dark:hover:text-gray-300 transition-all duration-300"
                        :class="sidebarCollapsed ? 'mx-auto' : ''"
                        title="Toggle sidebar"
                    >
                        <svg x-show="!sidebarCollapsed" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
                        </svg>
                        <svg x-show="sidebarCollapsed" x-cloak class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>

                
                <div class="flex-1 overflow-y-auto overflow-x-hidden py-4 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100 dark:scrollbar-thumb-gray-700 dark:scrollbar-track-gray-900">
                    <nav class="space-y-1 px-3 text-sm">
                        <?php if(auth()->guard()->check()): ?>
                            <?php
                                $company = currentCompany();
                                $currentCompanySlug = $company?->slug;
                                $isEmployee = false;
                                $isAdmin = false;
                                
                                // Only check roles if we have a company context
                                if ($company && Auth::check()) {
                                    try {
                                        $isEmployee = Auth::user()?->hasRoleInCompany('employee', $company->id) ?? false;
                                        $isAdmin = (Auth::user()?->hasRoleInCompany('company_admin', $company->id) ?? false) || 
                                                  (Auth::user()?->hasRoleInCompany('payroll_officer', $company->id) ?? false);
                                    } catch (\Exception $e) {
                                        // If hasRoleInCompany method doesn't exist or fails, default to false
                                        $isEmployee = false;
                                        $isAdmin = false;
                                    }
                                }
                                
                                // Helper function to get route (prefers path-based)
                                $getRoute = function($pathRoute, $subdomainRoute, $params = []) use ($currentCompanySlug) {
                                    if ($currentCompanySlug) {
                                        $params['company'] = $currentCompanySlug;
                                        // Always use path-based route
                                        if (Route::has($pathRoute)) {
                                            return route($pathRoute, $params);
                                        } elseif (Route::has($subdomainRoute)) {
                                            return route($subdomainRoute, $params);
                                        }
                                    }
                                    return '#';
                                };
                            ?>

                            
                            <?php if(request()->routeIs('admin.*') && Route::has('admin.dashboard')): ?>
                                <a href="<?php echo e(route('admin.dashboard')); ?>"
                                   class="flex items-center rounded-md px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-300' : ''); ?>"
                                   :title="sidebarCollapsed ? 'Dashboard' : ''">
                                    <span class="inline-flex h-5 w-5 items-center justify-center flex-shrink-0" :class="sidebarCollapsed ? 'mr-0' : 'mr-2'">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                             viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M3.75 12l8.25-8.25L20.25 12M4.5 10.5v9.75H9.75V15h4.5v5.25H19.5V10.5" />
                                        </svg>
                                    </span>
                                    <span class="whitespace-nowrap transition-opacity duration-300" :class="sidebarCollapsed ? 'opacity-0 w-0 overflow-hidden' : 'opacity-100'">Dashboard</span>
                                </a>
                                
                                <?php if(Route::has('admin.companies.index')): ?>
                                    <a href="<?php echo e(route('admin.companies.index')); ?>"
                                       class="flex items-center rounded-md px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 <?php echo e(request()->routeIs('admin.companies.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-300' : ''); ?>"
                                       :title="sidebarCollapsed ? 'Companies' : ''">
                                        <span class="inline-flex h-5 w-5 items-center justify-center flex-shrink-0" :class="sidebarCollapsed ? 'mr-0' : 'mr-2'">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                 viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M3.75 21h16.5M4.5 3.75h15a.75.75 0 01.75.75v11.25H3.75V4.5a.75.75 0 01.75-.75z" />
                                            </svg>
                                        </span>
                                        <span class="whitespace-nowrap transition-opacity duration-300" :class="sidebarCollapsed ? 'opacity-0 w-0 overflow-hidden' : 'opacity-100'">Companies</span>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if(Route::has('admin.companies.create')): ?>
                                    <a href="<?php echo e(route('admin.companies.create')); ?>"
                                       class="flex items-center rounded-md px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800"
                                       :title="sidebarCollapsed ? 'New Company' : ''">
                                        <span class="inline-flex h-5 w-5 items-center justify-center flex-shrink-0" :class="sidebarCollapsed ? 'mr-0' : 'mr-2'">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                 viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M12 4.5v15m7.5-7.5h-15" />
                                            </svg>
                                        </span>
                                        <span class="whitespace-nowrap transition-opacity duration-300" :class="sidebarCollapsed ? 'opacity-0 w-0 overflow-hidden' : 'opacity-100'">New Company</span>
                                    </a>
                                <?php endif; ?>
                                
                                <div class="border-t border-gray-200 dark:border-gray-800 my-2"></div>
                                
                                <?php if(Route::has('admin.subscription-plans.index')): ?>
                                    <a href="<?php echo e(route('admin.subscription-plans.index')); ?>"
                                       class="flex items-center rounded-md px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 <?php echo e(request()->routeIs('admin.subscription-plans.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-300' : ''); ?>">
                                        <span class="mr-2 inline-flex h-5 w-5 items-center justify-center">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                 viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5z" />
                                            </svg>
                                        </span>
                                        <span>Subscription Plans</span>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if(Route::has('admin.users.index')): ?>
                                    <a href="<?php echo e(route('admin.users.index')); ?>"
                                       class="flex items-center rounded-md px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 <?php echo e(request()->routeIs('admin.users.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-300' : ''); ?>">
                                        <span class="mr-2 inline-flex h-5 w-5 items-center justify-center">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                 viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 19.5a7.5 7.5 0 0115 0" />
                                            </svg>
                                        </span>
                                        <span>Users</span>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if(Route::has('admin.settings.index')): ?>
                                    <a href="<?php echo e(route('admin.settings.index')); ?>"
                                       class="flex items-center rounded-md px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 <?php echo e(request()->routeIs('admin.settings.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-300' : ''); ?>">
                                        <span class="mr-2 inline-flex h-5 w-5 items-center justify-center">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                 viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </span>
                                        <span>Settings</span>
                                    </a>
                                <?php endif; ?>
                            <?php elseif($currentCompanySlug): ?>
                                <?php if($isEmployee): ?>
                                    
                                    <?php if(Route::has('employee.dashboard')): ?>
                                        <a href="<?php echo e(route('companies.employee.dashboard', ['company' => $currentCompanySlug])); ?>"
                                           @click="sidebarOpen = false"
                                           class="flex items-center rounded-md px-3 py-3 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 <?php echo e(request()->routeIs('employee.dashboard') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-300' : ''); ?>">
                                            <span class="mr-2 inline-flex h-5 w-5 items-center justify-center">
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12l8.25-8.25L20.25 12M4.5 10.5v9.75H9.75V15h4.5v5.25H19.5V10.5" />
                                                </svg>
                                            </span>
                                            <span><?php echo e(__('Dashboard')); ?></span>
                                        </a>
                                    <?php endif; ?>

                                    <?php if(Route::has('employee.payslips.index')): ?>
                                        <a href="<?php echo e(route('companies.employee.payslips.index', ['company' => $currentCompanySlug])); ?>"
                                           @click="sidebarOpen = false"
                                           class="flex items-center rounded-md px-3 py-3 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 <?php echo e(request()->routeIs('employee.payslips.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-300' : ''); ?>">
                                            <span class="mr-2 inline-flex h-5 w-5 items-center justify-center">
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-6.75A2.25 2.25 0 0017.25 5.25H6.75A2.25 2.25 0 004.5 7.5v9A2.25 2.25 0 006.75 18.75h6.75" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 17.25 18.75 19.5 21 16.5" />
                                                </svg>
                                            </span>
                                            <span><?php echo e(__('My Payslips')); ?></span>
                                        </a>
                                    <?php endif; ?>

                                    <?php if(Route::has('employee.profile.show')): ?>
                                        <a href="<?php echo e(route('companies.employee.profile.show', ['company' => $currentCompanySlug])); ?>"
                                           @click="sidebarOpen = false"
                                           class="flex items-center rounded-md px-3 py-3 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 <?php echo e(request()->routeIs('employee.profile.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-300' : ''); ?>">
                                            <span class="mr-2 inline-flex h-5 w-5 items-center justify-center">
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 19.5a7.5 7.5 0 0115 0" />
                                                </svg>
                                            </span>
                                            <span><?php echo e(__('My Profile')); ?></span>
                                        </a>
                                    <?php endif; ?>

                                    <?php if(Route::has('employee.notifications.index')): ?>
                                        <a href="<?php echo e(route('companies.employee.notifications.index', ['company' => $currentCompanySlug])); ?>"
                                           @click="sidebarOpen = false"
                                           class="flex items-center rounded-md px-3 py-3 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 <?php echo e(request()->routeIs('employee.notifications.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-300' : ''); ?>">
                                            <span class="mr-2 inline-flex h-5 w-5 items-center justify-center">
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                                                </svg>
                                            </span>
                                            <span><?php echo e(__('Notifications')); ?></span>
                                        </a>
                                    <?php endif; ?>

                                    <?php if(Route::has('employee.help.index')): ?>
                                        <a href="<?php echo e(route('companies.employee.help.index', ['company' => $currentCompanySlug])); ?>"
                                           @click="sidebarOpen = false"
                                           class="flex items-center rounded-md px-3 py-3 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 <?php echo e(request()->routeIs('employee.help.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-300' : ''); ?>">
                                            <span class="mr-2 inline-flex h-5 w-5 items-center justify-center">
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                                                </svg>
                                            </span>
                                            <span><?php echo e(__('Help / Support')); ?></span>
                                        </a>
                                    <?php endif; ?>
                                <?php elseif($isAdmin): ?>
                                    
                                
                                    
                                    <?php if($currentCompanySlug && (Route::has('companies.company.admin.dashboard.path') || Route::has('company.admin.dashboard'))): ?>
                                        <a href="<?php echo e($getRoute('companies.company.admin.dashboard.path', 'company.admin.dashboard')); ?>"
                                           class="flex items-center rounded-md px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 <?php echo e(request()->routeIs('company.admin.dashboard*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-300' : ''); ?>">
                                            <span class="mr-2 inline-flex h-5 w-5 items-center justify-center">
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12l8.25-8.25L20.25 12M4.5 10.5v9.75H9.75V15h4.5v5.25H19.5V10.5" />
                                            </svg>
                                        </span>
                                        <span>Dashboard</span>
                                    </a>
                                <?php endif; ?>

                                
                                <?php if($currentCompanySlug && (Route::has('companies.employees.index') || Route::has('employees.index'))): ?>
                                    <a href="<?php echo e($getRoute('companies.employees.index', 'employees.index')); ?>"
                                       class="flex items-center rounded-md px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 <?php echo e(request()->routeIs('employees.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-300' : ''); ?>">
                                        <span class="mr-2 inline-flex h-5 w-5 items-center justify-center">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 19.5a7.5 7.5 0 0115 0" />
                                            </svg>
                                        </span>
                                        <span>Employees</span>
                                    </a>
                                <?php endif; ?>

                                
                                <?php if($currentCompanySlug && (Route::has('companies.payroll.runs.path.wizard.create') || Route::has('payroll.runs.wizard.create'))): ?>
                                    <a href="<?php echo e($getRoute('companies.payroll.runs.path.wizard.create', 'payroll.runs.wizard.create')); ?>"
                                       class="flex items-center rounded-md px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 <?php echo e(request()->routeIs('payroll.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-300' : ''); ?>">
                                        <span class="mr-2 inline-flex h-5 w-5 items-center justify-center">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8.25v7.5m-3-4.5h6m5.25-3.75A2.25 2.25 0 0018 5.25H6A2.25 2.25 0 003.75 7.5v9A2.25 2.25 0 006 18.75h12a2.25 2.25 0 002.25-2.25v-9z" />
                                            </svg>
                                        </span>
                                        <span>Payroll</span>
                                    </a>
                                <?php endif; ?>

                                
                                <?php if($currentCompanySlug && (Route::has('companies.salary-structures.index') || Route::has('salary-structures.index'))): ?>
                                    <a href="<?php echo e($getRoute('companies.salary-structures.index', 'salary-structures.index')); ?>"
                                       class="flex items-center rounded-md px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 <?php echo e(request()->routeIs('salary-structures.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-300' : ''); ?>">
                                        <span class="mr-2 inline-flex h-5 w-5 items-center justify-center">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                            </svg>
                                        </span>
                                        <span>Salary Structures</span>
                                    </a>
                                <?php endif; ?>

                                
                                <?php if($currentCompanySlug && (Route::has('companies.company.admin.dashboard.path') || Route::has('company.admin.dashboard'))): ?>
                                    <a href="<?php echo e($getRoute('companies.company.admin.dashboard.path', 'company.admin.dashboard')); ?>#payroll-runs"
                                       class="flex items-center rounded-md px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 <?php echo e(request()->routeIs('payroll.runs.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-300' : ''); ?>">
                                        <span class="mr-2 inline-flex h-5 w-5 items-center justify-center">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.5h16.5M3.75 9.75h16.5m-11.25 5.25h11.25M3.75 19.5h4.5" />
                                            </svg>
                                        </span>
                                        <span>Payroll Runs</span>
                                    </a>
                                <?php endif; ?>

                                
                                <?php if($currentCompanySlug && (Route::has('companies.payslips.index') || Route::has('payslips.index'))): ?>
                                    <a href="<?php echo e($getRoute('companies.payslips.index', 'payslips.index')); ?>"
                                       class="flex items-center rounded-md px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 <?php echo e(request()->routeIs('payslips.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-300' : ''); ?>">
                                        <span class="mr-2 inline-flex h-5 w-5 items-center justify-center">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                            </svg>
                                        </span>
                                        <span>Payslips</span>
                                    </a>
                                <?php endif; ?>

                                
                                <?php if($currentCompanySlug && (Route::has('companies.reports.index') || Route::has('reports.index'))): ?>
                                    <a href="<?php echo e($getRoute('companies.reports.index', 'reports.index')); ?>"
                                       class="flex items-center rounded-md px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 <?php echo e(request()->routeIs('reports.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-300' : ''); ?>">
                                        <span class="mr-2 inline-flex h-5 w-5 items-center justify-center">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                                            </svg>
                                        </span>
                                        <span>Reports</span>
                                    </a>
                                <?php endif; ?>

                                
                                <?php if($currentCompanySlug && (Route::has('companies.reports.tax.index') || Route::has('reports.tax.index'))): ?>
                                    <a href="<?php echo e($getRoute('companies.reports.tax.index', 'reports.tax.index')); ?>"
                                       class="flex items-center rounded-md px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 <?php echo e(request()->routeIs('reports.tax.*') || request()->routeIs('reports.pension.*') || request()->routeIs('reports.annual.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-300' : ''); ?>">
                                        <span class="mr-2 inline-flex h-5 w-5 items-center justify-center">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                            </svg>
                                        </span>
                                        <span>Tax & Compliance</span>
                                    </a>
                                <?php endif; ?>

                                
                                <?php if($currentCompanySlug && (Route::has('companies.users-roles.index') || Route::has('users-roles.index'))): ?>
                                    <a href="<?php echo e($getRoute('companies.users-roles.index', 'users-roles.index')); ?>"
                                       class="flex items-center rounded-md px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 <?php echo e(request()->routeIs('users-roles.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-300' : ''); ?>">
                                        <span class="mr-2 inline-flex h-5 w-5 items-center justify-center">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                            </svg>
                                        </span>
                                        <span>Users & Roles</span>
                                    </a>
                                <?php endif; ?>

                                
                                <?php if($currentCompanySlug && (Route::has('companies.subscriptions.index') || Route::has('subscriptions.index'))): ?>
                                    <a href="<?php echo e($getRoute('companies.subscriptions.index', 'subscriptions.index')); ?>"
                                       class="flex items-center rounded-md px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 <?php echo e(request()->routeIs('subscriptions.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-300' : ''); ?>">
                                        <span class="mr-2 inline-flex h-5 w-5 items-center justify-center">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15.75m9.75-12v6.75m0 0v6.75m0-6.75h3.75m-3.75 0h-3.75" />
                                            </svg>
                                        </span>
                                        <span>Billing & Subscription</span>
                                    </a>
                                <?php endif; ?>

                                
                                <?php if($currentCompanySlug && (Route::has('companies.settings.index') || Route::has('settings.index'))): ?>
                                    <a href="<?php echo e($getRoute('companies.settings.index', 'settings.index')); ?>"
                                       class="flex items-center rounded-md px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 <?php echo e(request()->routeIs('settings.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-300' : ''); ?>">
                                        <span class="mr-2 inline-flex h-5 w-5 items-center justify-center">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93l.8.32a1.125 1.125 0 00.657.036l.85-.24a1.125 1.125 0 011.37.81l.273 1.087c.12.477-.09.978-.492 1.25l-.724.484a1.125 1.125 0 00-.45.868v.527c0 .323.152.628.41.832l.724.484c.402.272.612.773.492 1.25l-.273 1.087a1.125 1.125 0 01-1.37.81l-.85-.24a1.125 1.125 0 00-.657.036l-.8.32c-.396.166-.71.506-.78.93l-.149.894c-.09.542-.56.94-1.11.94h-1.093c-.55 0-1.02-.398-1.11-.94l-.149-.894a1.125 1.125 0 00-.78-.93l-.8-.32a1.125 1.125 0 00-.657-.036l-.85.24a1.125 1.125 0 01-1.37-.81l-.273-1.087c-.12-.477.09-.978.492-1.25l.724-.484a1.125 1.125 0 00.45-.868v-.527c0-.323-.152-.628-.41-.832l-.724-.484c-.402-.272-.612-.773-.492-1.25l.273-1.087a1.125 1.125 0 011.37-.81l.85.24c.214.06.443.044.657-.036l.8-.32c.396-.166.71-.506.78-.93l.149-.894z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </span>
                                        <span>Settings</span>
                                    </a>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </nav>
                </div>
            </aside>

            
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
                        <a href="<?php echo e(url('/')); ?>" class="flex items-center space-x-2">
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-600 text-white font-semibold">
                                PS
                            </span>
                            <span class="text-sm font-semibold">
                                <?php echo e(config('app.name', 'MatechPay')); ?>

                            </span>
                        </a>
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
                            <?php if(auth()->guard()->check()): ?>
                                <?php
                                    $company = currentCompany();
                                    $currentCompanySlug = $company?->slug;
                                ?>

                                
                                <?php if(request()->routeIs('admin.*') && Route::has('admin.dashboard')): ?>
                                    <a href="<?php echo e(route('admin.dashboard')); ?>"
                                       @click="sidebarOpen = false"
                                       class="flex items-center rounded-md px-3 py-3 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-300' : ''); ?>">
                                        <span class="mr-2 inline-flex h-5 w-5 items-center justify-center">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                 viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M3.75 12l8.25-8.25L20.25 12M4.5 10.5v9.75H9.75V15h4.5v5.25H19.5V10.5" />
                                            </svg>
                                        </span>
                                        <span>Dashboard</span>
                                    </a>
                                    
                                    <?php if(Route::has('admin.companies.index')): ?>
                                        <a href="<?php echo e(route('admin.companies.index')); ?>"
                                           @click="sidebarOpen = false"
                                           class="flex items-center rounded-md px-3 py-3 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 <?php echo e(request()->routeIs('admin.companies.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-300' : ''); ?>">
                                            <span class="mr-2 inline-flex h-5 w-5 items-center justify-center">
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                     viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M3.75 21h16.5M4.5 3.75h15a.75.75 0 01.75.75v11.25H3.75V4.5a.75.75 0 01.75-.75z" />
                                                </svg>
                                            </span>
                                            <span>Companies</span>
                                        </a>
                                    <?php endif; ?>
                                    
                                    <?php if(Route::has('admin.companies.create')): ?>
                                        <a href="<?php echo e(route('admin.companies.create')); ?>"
                                           @click="sidebarOpen = false"
                                           class="flex items-center rounded-md px-3 py-3 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800">
                                            <span class="mr-2 inline-flex h-5 w-5 items-center justify-center">
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                     viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M12 4.5v15m7.5-7.5h-15" />
                                                </svg>
                                            </span>
                                            <span>New Company</span>
                                        </a>
                                    <?php endif; ?>
                                    
                                    <div class="border-t border-gray-200 dark:border-gray-800 my-2"></div>
                                    
                                    <?php if(Route::has('admin.subscription-plans.index')): ?>
                                        <a href="<?php echo e(route('admin.subscription-plans.index')); ?>"
                                           @click="sidebarOpen = false"
                                           class="flex items-center rounded-md px-3 py-3 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 <?php echo e(request()->routeIs('admin.subscription-plans.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-300' : ''); ?>">
                                            <span class="mr-2 inline-flex h-5 w-5 items-center justify-center">
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                     viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5z" />
                                                </svg>
                                            </span>
                                            <span>Subscription Plans</span>
                                        </a>
                                    <?php endif; ?>
                                    
                                    <?php if(Route::has('admin.users.index')): ?>
                                        <a href="<?php echo e(route('admin.users.index')); ?>"
                                           @click="sidebarOpen = false"
                                           class="flex items-center rounded-md px-3 py-3 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 <?php echo e(request()->routeIs('admin.users.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-300' : ''); ?>">
                                            <span class="mr-2 inline-flex h-5 w-5 items-center justify-center">
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                     viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 19.5a7.5 7.5 0 0115 0" />
                                                </svg>
                                            </span>
                                            <span>Users</span>
                                        </a>
                                    <?php endif; ?>
                                    
                                    <?php if(Route::has('admin.settings.index')): ?>
                                        <a href="<?php echo e(route('admin.settings.index')); ?>"
                                           @click="sidebarOpen = false"
                                           class="flex items-center rounded-md px-3 py-3 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 <?php echo e(request()->routeIs('admin.settings.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-300' : ''); ?>">
                                            <span class="mr-2 inline-flex h-5 w-5 items-center justify-center">
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                     viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </span>
                                            <span>Settings</span>
                                        </a>
                                    <?php endif; ?>
                                <?php elseif($currentCompanySlug): ?>
                                    
                                    
                                    
                                    <?php if($currentCompanySlug && (Route::has('companies.company.admin.dashboard.path') || Route::has('company.admin.dashboard'))): ?>
                                        <a href="<?php echo e($getRoute('companies.company.admin.dashboard.path', 'company.admin.dashboard')); ?>"
                                           @click="sidebarOpen = false"
                                           class="flex items-center rounded-md px-3 py-3 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 <?php echo e(request()->routeIs('company.admin.dashboard*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-300' : ''); ?>">
                                            <span class="mr-2 inline-flex h-5 w-5 items-center justify-center">
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12l8.25-8.25L20.25 12M4.5 10.5v9.75H9.75V15h4.5v5.25H19.5V10.5" />
                                                </svg>
                                            </span>
                                            <span>Dashboard</span>
                                        </a>
                                    <?php endif; ?>

                                    
                                    <?php if($currentCompanySlug && (Route::has('companies.employees.index') || Route::has('employees.index'))): ?>
                                        <a href="<?php echo e($getRoute('companies.employees.index', 'employees.index')); ?>"
                                           @click="sidebarOpen = false"
                                           class="flex items-center rounded-md px-3 py-3 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 <?php echo e(request()->routeIs('employees.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-300' : ''); ?>">
                                            <span class="mr-2 inline-flex h-5 w-5 items-center justify-center">
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 19.5a7.5 7.5 0 0115 0" />
                                                </svg>
                                            </span>
                                            <span>Employees</span>
                                        </a>
                                    <?php endif; ?>

                                    
                                    <?php if($currentCompanySlug && (Route::has('companies.payroll.runs.path.wizard.create') || Route::has('payroll.runs.wizard.create'))): ?>
                                        <a href="<?php echo e($getRoute('companies.payroll.runs.path.wizard.create', 'payroll.runs.wizard.create')); ?>"
                                           @click="sidebarOpen = false"
                                           class="flex items-center rounded-md px-3 py-3 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 <?php echo e(request()->routeIs('payroll.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-300' : ''); ?>">
                                            <span class="mr-2 inline-flex h-5 w-5 items-center justify-center">
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8.25v7.5m-3-4.5h6m5.25-3.75A2.25 2.25 0 0018 5.25H6A2.25 2.25 0 003.75 7.5v9A2.25 2.25 0 006 18.75h12a2.25 2.25 0 002.25-2.25v-9z" />
                                                </svg>
                                            </span>
                                            <span>Payroll</span>
                                        </a>
                                    <?php endif; ?>

                                    
                                    <?php if($currentCompanySlug && (Route::has('companies.salary-structures.index') || Route::has('salary-structures.index'))): ?>
                                        <a href="<?php echo e($getRoute('companies.salary-structures.index', 'salary-structures.index')); ?>"
                                           @click="sidebarOpen = false"
                                           class="flex items-center rounded-md px-3 py-3 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 <?php echo e(request()->routeIs('salary-structures.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-300' : ''); ?>">
                                            <span class="mr-2 inline-flex h-5 w-5 items-center justify-center">
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                                </svg>
                                            </span>
                                            <span>Salary Structures</span>
                                        </a>
                                    <?php endif; ?>

                                    
                                    <?php if($currentCompanySlug && (Route::has('companies.company.admin.dashboard.path') || Route::has('company.admin.dashboard'))): ?>
                                        <a href="<?php echo e($getRoute('companies.company.admin.dashboard.path', 'company.admin.dashboard')); ?>#payroll-runs"
                                           @click="sidebarOpen = false"
                                           class="flex items-center rounded-md px-3 py-3 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 <?php echo e(request()->routeIs('payroll.runs.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-300' : ''); ?>">
                                            <span class="mr-2 inline-flex h-5 w-5 items-center justify-center">
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.5h16.5M3.75 9.75h16.5m-11.25 5.25h11.25M3.75 19.5h4.5" />
                                                </svg>
                                            </span>
                                            <span>Payroll Runs</span>
                                        </a>
                                    <?php endif; ?>

                                    
                                    <?php if($currentCompanySlug && (Route::has('companies.payslips.index') || Route::has('payslips.index'))): ?>
                                        <a href="<?php echo e($getRoute('companies.payslips.index', 'payslips.index')); ?>"
                                           @click="sidebarOpen = false"
                                           class="flex items-center rounded-md px-3 py-3 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 <?php echo e(request()->routeIs('payslips.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-300' : ''); ?>">
                                            <span class="mr-2 inline-flex h-5 w-5 items-center justify-center">
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-6.75A2.25 2.25 0 0017.25 5.25H6.75A2.25 2.25 0 004.5 7.5v9A2.25 2.25 0 006.75 18.75h6.75" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 17.25 18.75 19.5 21 16.5" />
                                                </svg>
                                            </span>
                                            <span>Payslips</span>
                                        </a>
                                    <?php endif; ?>

                                    
                                    <?php if($currentCompanySlug && (Route::has('companies.reports.index') || Route::has('reports.index'))): ?>
                                        <a href="<?php echo e($getRoute('companies.reports.index', 'reports.index')); ?>"
                                           @click="sidebarOpen = false"
                                           class="flex items-center rounded-md px-3 py-3 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 <?php echo e(request()->routeIs('reports.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-300' : ''); ?>">
                                            <span class="mr-2 inline-flex h-5 w-5 items-center justify-center">
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                                </svg>
                                            </span>
                                            <span>Reports</span>
                                        </a>
                                    <?php endif; ?>

                                    
                                    <?php if($currentCompanySlug && (Route::has('companies.reports.tax.index') || Route::has('reports.tax.index'))): ?>
                                        <a href="<?php echo e($getRoute('companies.reports.tax.index', 'reports.tax.index')); ?>"
                                           @click="sidebarOpen = false"
                                           class="flex items-center rounded-md px-3 py-3 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 <?php echo e(request()->routeIs('reports.tax.*') || request()->routeIs('reports.pension.*') || request()->routeIs('reports.annual.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-300' : ''); ?>">
                                            <span class="mr-2 inline-flex h-5 w-5 items-center justify-center">
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                                </svg>
                                            </span>
                                            <span>Tax & Compliance</span>
                                        </a>
                                    <?php endif; ?>

                                    
                                    <?php if($currentCompanySlug && (Route::has('companies.users-roles.index') || Route::has('users-roles.index'))): ?>
                                        <a href="<?php echo e($getRoute('companies.users-roles.index', 'users-roles.index')); ?>"
                                           @click="sidebarOpen = false"
                                           class="flex items-center rounded-md px-3 py-3 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 <?php echo e(request()->routeIs('users-roles.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-300' : ''); ?>">
                                        <span class="mr-2 inline-flex h-5 w-5 items-center justify-center">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                            </svg>
                                        </span>
                                        <span>Users & Roles</span>
                                    </a>

                                    
                                    <?php if($currentCompanySlug && (Route::has('companies.subscriptions.index') || Route::has('subscriptions.index'))): ?>
                                        <a href="<?php echo e($getRoute('companies.subscriptions.index', 'subscriptions.index')); ?>"
                                           @click="sidebarOpen = false"
                                           class="flex items-center rounded-md px-3 py-3 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 <?php echo e(request()->routeIs('subscriptions.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-300' : ''); ?>">
                                            <span class="mr-2 inline-flex h-5 w-5 items-center justify-center">
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5z" />
                                                </svg>
                                            </span>
                                            <span>Billing & Subscription</span>
                                        </a>
                                    <?php endif; ?>

                                    
                                    <a href="#"
                                       @click="sidebarOpen = false"
                                       class="flex items-center rounded-md px-3 py-3 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-800">
                                        <span class="mr-2 inline-flex h-5 w-5 items-center justify-center">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93l.8.32a1.125 1.125 0 00.657.036l.85-.24a1.125 1.125 0 011.37.81l.273 1.087c.12.477-.09.978-.492 1.25l-.724.484a1.125 1.125 0 00-.45.868v.527c0 .323.152.628.41.832l.724.484c.402.272.612.773.492 1.25l-.273 1.087a1.125 1.125 0 01-1.37.81l-.85-.24a1.125 1.125 0 00-.657.036l-.8.32c-.396.166-.71.506-.78.93l-.149.894c-.09.542-.56.94-1.11.94h-1.093c-.55 0-1.02-.398-1.11-.94l-.149-.894a1.125 1.125 0 00-.78-.93l-.8-.32a1.125 1.125 0 00-.657-.036l-.85.24a1.125 1.125 0 01-1.37-.81l-.273-1.087c-.12-.477.09-.978.492-1.25l.724-.484a1.125 1.125 0 00.45-.868v-.527c0-.323-.152-.628-.41-.832l-.724-.484c-.402-.272-.612-.773-.492-1.25l.273-1.087a1.125 1.125 0 011.37-.81l.85.24c.214.06.443.044.657-.036l.8-.32c.396-.166.71-.506.78-.93l.149-.894z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </span>
                                        <span>Settings</span>
                                    </a>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php endif; ?>
                        </nav>
                    </div>
                </div>
            </div>

            
            <main class="flex-1 overflow-y-auto transition-all duration-300" :class="sidebarCollapsed ? 'lg:ml-16' : 'lg:ml-64'">
                <div class="w-full px-4 py-6 sm:px-6 lg:px-8">
                    <?php if(isset($slot)): ?>
                        <?php echo e($slot); ?>

                    <?php else: ?>
                        <?php echo $__env->yieldContent('content'); ?>
                    <?php endif; ?>
                </div>
            </main>

        </div>

        <footer class="border-t border-gray-200 bg-white py-3 text-xs text-gray-500 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-400 transition-all duration-300" :class="sidebarCollapsed ? 'lg:ml-16' : 'lg:ml-64'">
            <div class="w-full flex items-center justify-between px-4 sm:px-6 lg:px-8">
                <span>
                    &copy; 2026 MatechPay. All rights reserved. 
                    <a 
                        href="https://mathiasodhiambo.netlify.app/" 
                        target="_blank" 
                        rel="noopener noreferrer"
                        class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors duration-200"
                        title="Visit developer portfolio"
                    >
                        Developed by Mathias Odhiambo
                    </a>
                </span>
                <span>v<?php echo e(config('app.version', '1.0.0')); ?></span>
            </div>
        </footer>

    </div>

    
    <?php if (isset($component)) { $__componentOriginalbcd757c7bb20b76cf9bcd607adaf8c39 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbcd757c7bb20b76cf9bcd607adaf8c39 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.toast-container','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('toast-container'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbcd757c7bb20b76cf9bcd607adaf8c39)): ?>
<?php $attributes = $__attributesOriginalbcd757c7bb20b76cf9bcd607adaf8c39; ?>
<?php unset($__attributesOriginalbcd757c7bb20b76cf9bcd607adaf8c39); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbcd757c7bb20b76cf9bcd607adaf8c39)): ?>
<?php $component = $__componentOriginalbcd757c7bb20b76cf9bcd607adaf8c39; ?>
<?php unset($__componentOriginalbcd757c7bb20b76cf9bcd607adaf8c39); ?>
<?php endif; ?>

</body>
</html>

<?php /**PATH C:\xampp\htdocs\payroll-system\resources\views/layouts/layout.blade.php ENDPATH**/ ?>