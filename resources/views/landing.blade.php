@extends('layouts.marketing')

@section('title', config('app.name') . ' – Modern SaaS Payroll for Growing Businesses')

@section('content')
    <!-- Hero -->
    <section class="bg-gradient-to-b from-white to-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-20 lg:pt-24 lg:pb-28">
            <div class="lg:grid lg:grid-cols-12 lg:gap-12 items-center">
                <div class="lg:col-span-7">
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-gray-900">
                        Run payroll in minutes, <span class="text-indigo-600">not days</span>.
                    </h1>
                    <p class="mt-4 text-lg text-gray-600 max-w-xl">
                        {{ config('app.name') }} automates payroll calculations, taxes, and compliance so your team
                        gets paid accurately, every time.
                    </p>

                    <div class="mt-6 flex flex-col sm:flex-row sm:items-center sm:space-x-4 space-y-3 sm:space-y-0">
                        @if (Route::has('company.signup'))
                            <a href="{{ route('company.signup') }}"
                               class="inline-flex items-center justify-center px-6 py-3 rounded-md text-base font-semibold text-white bg-indigo-600 hover:bg-indigo-700 shadow-md">
                                Start 14-day free trial
                            </a>
                        @endif
                        <a href="{{ route('pricing') }}"
                           class="inline-flex items-center justify-center px-6 py-3 rounded-md text-base font-semibold text-indigo-700 bg-indigo-50 hover:bg-indigo-100">
                            View pricing
                        </a>
                    </div>

                    <div class="mt-6 flex items-center space-x-4 text-sm text-gray-500">
                        <div class="flex -space-x-2">
                            <span class="inline-flex h-8 w-8 rounded-full bg-indigo-100 border border-white"></span>
                            <span class="inline-flex h-8 w-8 rounded-full bg-indigo-200 border border-white"></span>
                            <span class="inline-flex h-8 w-8 rounded-full bg-indigo-300 border border-white"></span>
                        </div>
                        <p><span class="font-semibold text-gray-700">500+ companies</span> run payroll with {{ config('app.name') }}.</p>
                    </div>
                </div>

                <div class="mt-10 lg:mt-0 lg:col-span-5">
                    <div class="bg-white rounded-xl shadow-xl border border-gray-100 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <p class="text-sm font-semibold text-gray-700">Upcoming payroll – Jan 31</p>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700">
                                On track
                            </span>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Total employees</p>
                                    <p class="text-xl font-semibold text-gray-900">72</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Total payroll</p>
                                    <p class="text-xl font-semibold text-gray-900">$214,560</p>
                                </div>
                            </div>

                            <div class="border-t pt-4">
                                <p class="text-xs uppercase tracking-wide text-gray-500 mb-2">Status</p>
                                <div class="w-full bg-gray-100 rounded-full h-2">
                                    <div class="bg-indigo-600 h-2 rounded-full w-2/3"></div>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">48 of 72 payslips reviewed</p>
                            </div>

                            <button
                                class="w-full mt-4 inline-flex items-center justify-center px-4 py-2 rounded-md text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700">
                                Review and run payroll
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Trust / Logos -->
    <section class="bg-white border-y">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <p class="text-center text-xs font-semibold tracking-wide text-gray-500 uppercase">
                Trusted by fast-growing businesses
            </p>
            <div class="mt-6 grid grid-cols-2 sm:grid-cols-4 gap-6 items-center text-gray-400 text-xs sm:text-sm">
                <div class="text-center font-semibold">BluePeak HR</div>
                <div class="text-center font-semibold">Northwind Retail</div>
                <div class="text-center font-semibold">Summit Labs</div>
                <div class="text-center font-semibold">Brightline Legal</div>
            </div>
        </div>
    </section>

    <!-- Key features summary -->
    <section class="bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="max-w-2xl">
                <h2 class="text-2xl font-bold text-gray-900">Everything you need to run payroll with confidence.</h2>
                <p class="mt-3 text-gray-600">
                    Automate recurring tasks, stay compliant, and give employees a transparent payslip experience.
                </p>
            </div>

            <div class="mt-8 grid gap-8 md:grid-cols-3">
                <div class="bg-white rounded-lg shadow-sm border p-6">
                    <div class="inline-flex items-center justify-center w-10 h-10 rounded-md bg-indigo-50 text-indigo-600 mb-4">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M12 8v8m4-4H8m4-9a9 9 0 100 18 9 9 0 000-18z"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900">Automated calculations</h3>
                    <p class="mt-2 text-sm text-gray-600">
                        Handle overtime, benefits, bonuses, and deductions automatically with configurable rules.
                    </p>
                </div>

                <div class="bg-white rounded-lg shadow-sm border p-6">
                    <div class="inline-flex items-center justify-center w-10 h-10 rounded-md bg-indigo-50 text-indigo-600 mb-4">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900">Built-in compliance</h3>
                    <p class="mt-2 text-sm text-gray-600">
                        Stay compliant with tax rules and local regulations with automatic updates.
                    </p>
                </div>

                <div class="bg-white rounded-lg shadow-sm border p-6">
                    <div class="inline-flex items-center justify-center w-10 h-10 rounded-md bg-indigo-50 text-indigo-600 mb-4">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M9 12l2 2 4-4m-9 8h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v9a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900">Employee self-service</h3>
                    <p class="mt-2 text-sm text-gray-600">
                        Let employees securely access their payslips and tax documents from any device.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="bg-indigo-600">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">
            <div>
                <h2 class="text-2xl font-semibold text-white">Ready to simplify your payroll?</h2>
                <p class="mt-2 text-indigo-100 text-sm">
                    Start your free trial in minutes—no credit card required.
                </p>
            </div>
            <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-4 space-y-3 sm:space-y-0">
                @if (Route::has('company.signup'))
                    <a href="{{ route('company.signup') }}"
                       class="inline-flex items-center justify-center px-6 py-3 rounded-md text-base font-semibold text-indigo-700 bg-white hover:bg-indigo-50">
                        Start free trial
                    </a>
                @endif
                <a href="{{ route('contact') }}"
                   class="inline-flex items-center justify-center px-6 py-3 rounded-md text-base font-semibold text-white border border-indigo-300 hover:bg-indigo-500">
                    Talk to sales
                </a>
            </div>
        </div>
    </section>
@endsection

