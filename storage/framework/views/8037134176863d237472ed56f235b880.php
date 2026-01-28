

<?php $__env->startSection('title', config('app.name') . ' – Payroll Management System'); ?>

<?php $__env->startSection('content'); ?>
    <!-- Hero -->
    <section class="relative bg-gradient-to-br from-white via-indigo-50/30 to-white overflow-hidden">
        <!-- Subtle background pattern -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, rgb(99 102 241) 1px, transparent 0); background-size: 40px 40px;"></div>
        </div>
        
        <div class="relative w-full px-4 sm:px-6 lg:px-8 xl:px-12 2xl:px-16 pt-20 pb-24 lg:pt-28 lg:pb-32">
            <div class="lg:grid lg:grid-cols-12 lg:gap-12 xl:gap-16 items-center max-w-7xl mx-auto">
                <div class="lg:col-span-7">
                    <div class="inline-flex items-center px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 text-xs font-semibold mb-6">
                        Trusted by 500+ companies
                    </div>
                    
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold tracking-tight text-gray-900 leading-tight">
                        Run payroll in minutes, <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">not days</span>.
                    </h1>
                    <p class="mt-6 text-xl text-gray-600 max-w-2xl leading-relaxed">
                        <?php echo e(config('app.name')); ?> automates payroll calculations, taxes, and compliance so your team
                        gets paid accurately, every time.
                    </p>

                    <div class="mt-8 flex flex-col sm:flex-row sm:items-center sm:space-x-4 space-y-3 sm:space-y-0">
                        <?php if(Route::has('company.signup')): ?>
                            <a href="<?php echo e(route('company.signup')); ?>"
                               class="group inline-flex items-center justify-center px-8 py-4 rounded-lg text-base font-semibold text-white bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 shadow-lg shadow-indigo-500/25 hover:shadow-xl hover:shadow-indigo-500/30 transition-all duration-200 transform hover:-translate-y-0.5">
                                Start 14-day free trial
                                <svg class="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                        <?php endif; ?>
                        <a href="<?php echo e(route('pricing')); ?>"
                           class="inline-flex items-center justify-center px-8 py-4 rounded-lg text-base font-semibold text-indigo-700 bg-white border-2 border-indigo-200 hover:border-indigo-300 hover:bg-indigo-50 transition-all duration-200 shadow-sm">
                            View pricing
                        </a>
                    </div>

                    <div class="mt-10 flex items-center space-x-4 text-sm text-gray-600">
                        <div class="flex -space-x-3">
                            <span class="inline-flex h-10 w-10 rounded-full bg-gradient-to-br from-indigo-400 to-indigo-600 border-2 border-white shadow-sm"></span>
                            <span class="inline-flex h-10 w-10 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 border-2 border-white shadow-sm"></span>
                            <span class="inline-flex h-10 w-10 rounded-full bg-gradient-to-br from-pink-400 to-pink-600 border-2 border-white shadow-sm"></span>
                        </div>
                        <p class="text-gray-700"><span class="font-semibold">500+ companies</span> run payroll with <?php echo e(config('app.name')); ?>.</p>
                    </div>
                </div>

                <div class="mt-12 lg:mt-0 lg:col-span-5">
                    <div class="relative bg-white rounded-2xl shadow-2xl border border-gray-100 p-8 transform hover:scale-[1.02] transition-transform duration-300">
                        <!-- Decorative gradient -->
                        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-full blur-3xl opacity-50 -z-10"></div>
                        
                        <div class="flex items-center justify-between mb-6">
                            <p class="text-sm font-semibold text-gray-800">Upcoming payroll – Jan 31</p>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5 animate-pulse"></span>
                                On track
                            </span>
                        </div>

                        <div class="space-y-6">
                            <div class="grid grid-cols-2 gap-6">
                                <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-4 border border-gray-100">
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Total employees</p>
                                    <p class="text-3xl font-bold text-gray-900">72</p>
                                </div>
                                <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-4 border border-gray-100">
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Total payroll</p>
                                    <p class="text-3xl font-bold text-gray-900">$214,560</p>
                                </div>
                            </div>

                            <div class="bg-gray-50 rounded-xl p-5 border border-gray-100">
                                <div class="flex items-center justify-between mb-3">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-600">Status</p>
                                    <span class="text-xs font-medium text-gray-500">67%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
                                    <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 h-2.5 rounded-full w-2/3 shadow-sm transition-all duration-500"></div>
                                </div>
                                <p class="mt-2 text-xs text-gray-500">48 of 72 payslips reviewed</p>
                            </div>

                            <button
                                class="w-full mt-2 inline-flex items-center justify-center px-6 py-3.5 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 shadow-lg shadow-indigo-500/25 hover:shadow-xl transition-all duration-200">
                                Review and run payroll
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Trust / Logos -->
    <section class="bg-white border-y border-gray-100">
        <div class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 2xl:px-16 py-12">
            <div class="max-w-7xl mx-auto">
            <p class="text-center text-xs font-bold tracking-wider text-gray-400 uppercase mb-8">
                Trusted by fast-growing businesses
            </p>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-8 items-center">
                    <div class="text-center group">
                        <div class="text-gray-400 group-hover:text-gray-600 font-semibold text-sm transition-colors duration-200">BluePeak HR</div>
                    </div>
                    <div class="text-center group">
                        <div class="text-gray-400 group-hover:text-gray-600 font-semibold text-sm transition-colors duration-200">Northwind Retail</div>
                    </div>
                    <div class="text-center group">
                        <div class="text-gray-400 group-hover:text-gray-600 font-semibold text-sm transition-colors duration-200">Summit Labs</div>
                    </div>
                    <div class="text-center group">
                        <div class="text-gray-400 group-hover:text-gray-600 font-semibold text-sm transition-colors duration-200">Brightline Legal</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Key features summary -->
    <section class="bg-gradient-to-b from-gray-50 to-white">
        <div class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 2xl:px-16 py-20">
            <div class="max-w-7xl mx-auto">
                <div class="max-w-3xl mb-16">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 leading-tight">Everything you need to run payroll with confidence.</h2>
                <p class="mt-4 text-lg text-gray-600 leading-relaxed">
                    Automate recurring tasks, stay compliant, and give employees a transparent payslip experience.
                </p>
            </div>

                <div class="grid gap-8 md:grid-cols-3">
                    <div class="group bg-white rounded-2xl shadow-lg border border-gray-100 p-8 hover:shadow-xl hover:border-indigo-200 transition-all duration-300 transform hover:-translate-y-1">
                        <div class="inline-flex items-center justify-center w-14 h-14 rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-600 text-white mb-6 shadow-lg shadow-indigo-500/25 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Automated calculations</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Handle overtime, benefits, bonuses, and deductions automatically with configurable rules.
                        </p>
                    </div>

                    <div class="group bg-white rounded-2xl shadow-lg border border-gray-100 p-8 hover:shadow-xl hover:border-indigo-200 transition-all duration-300 transform hover:-translate-y-1">
                        <div class="inline-flex items-center justify-center w-14 h-14 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 text-white mb-6 shadow-lg shadow-purple-500/25 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Built-in compliance</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Stay compliant with tax rules and local regulations with automatic updates.
                        </p>
                    </div>

                    <div class="group bg-white rounded-2xl shadow-lg border border-gray-100 p-8 hover:shadow-xl hover:border-indigo-200 transition-all duration-300 transform hover:-translate-y-1">
                        <div class="inline-flex items-center justify-center w-14 h-14 rounded-xl bg-gradient-to-br from-pink-500 to-pink-600 text-white mb-6 shadow-lg shadow-pink-500/25 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Employee self-service</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Let employees securely access their payslips and tax documents from any device.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="relative bg-gradient-to-r from-indigo-600 via-indigo-700 to-purple-700 overflow-hidden">
        <!-- Decorative elements -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-purple-300 rounded-full blur-3xl"></div>
        </div>
        
        <div class="relative w-full px-4 sm:px-6 lg:px-8 xl:px-12 2xl:px-16 py-16">
            <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
            <div class="text-center md:text-left">
                <h2 class="text-3xl sm:text-4xl font-bold text-white leading-tight">Ready to simplify your payroll?</h2>
                <p class="mt-3 text-indigo-100 text-lg">
                    Start your free trial in minutes—no credit card required.
                </p>
            </div>
            <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-4 space-y-3 sm:space-y-0">
                <?php if(Route::has('company.signup')): ?>
                    <a href="<?php echo e(route('company.signup')); ?>"
                       class="group inline-flex items-center justify-center px-8 py-4 rounded-xl text-base font-semibold text-indigo-700 bg-white hover:bg-gray-50 shadow-xl hover:shadow-2xl transition-all duration-200 transform hover:-translate-y-0.5">
                        Start free trial
                        <svg class="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                <?php endif; ?>
                <a href="<?php echo e(route('contact')); ?>"
                   class="inline-flex items-center justify-center px-8 py-4 rounded-xl text-base font-semibold text-white border-2 border-indigo-300 hover:bg-indigo-500/20 hover:border-indigo-200 transition-all duration-200">
                    Talk to sales
                </a>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.marketing', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\payroll-system\resources\views/landing.blade.php ENDPATH**/ ?>