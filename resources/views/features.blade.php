@extends('layouts.marketing')

@section('title', 'Features – ' . config('app.name'))

@section('content')
    <section class="bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-20">
            <div class="max-w-2xl">
                <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900">Built for modern HR and finance teams.</h1>
                <p class="mt-3 text-gray-600">
                    From onboarding to termination settlements, {{ config('app.name') }} streamlines the entire employee lifecycle.
                </p>
            </div>

            <!-- Feature grid -->
            <div class="mt-10 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                <div class="bg-white rounded-xl border shadow-sm p-6 flex flex-col">
                    <h3 class="text-base font-semibold text-gray-900">Smart payroll engine</h3>
                    <p class="mt-2 text-sm text-gray-600">
                        Configure salary structures, allowances, deductions, and taxes once. The engine handles the math
                        every cycle with full audit logs.
                    </p>
                </div>

                <div class="bg-white rounded-xl border shadow-sm p-6 flex flex-col">
                    <h3 class="text-base font-semibold text-gray-900">Employee lifecycle tracking</h3>
                    <p class="mt-2 text-sm text-gray-600">
                        Manage hiring, promotions, salary changes, and terminations with a complete historical record.
                    </p>
                </div>

                <div class="bg-white rounded-xl border shadow-sm p-6 flex flex-col">
                    <h3 class="text-base font-semibold text-gray-900">Payslip generation & delivery</h3>
                    <p class="mt-2 text-sm text-gray-600">
                        Generate secure, branded payslips in PDF format and deliver them via email or employee portal.
                    </p>
                </div>

                <div class="bg-white rounded-xl border shadow-sm p-6 flex flex-col">
                    <h3 class="text-base font-semibold text-gray-900">Multi-company support</h3>
                    <p class="mt-2 text-sm text-gray-600">
                        Run payroll for multiple entities with clean separation of data and configuration.
                    </p>
                </div>

                <div class="bg-white rounded-xl border shadow-sm p-6 flex flex-col">
                    <h3 class="text-base font-semibold text-gray-900">Reporting & analytics</h3>
                    <p class="mt-2 text-sm text-gray-600">
                        Get instant insight into payroll costs, overtime, benefits, and more with exportable reports.
                    </p>
                </div>

                <div class="bg-white rounded-xl border shadow-sm p-6 flex flex-col">
                    <h3 class="text-base font-semibold text-gray-900">Role-based permissions</h3>
                    <p class="mt-2 text-sm text-gray-600">
                        Control who can run payroll, approve changes, and access sensitive salary information.
                    </p>
                </div>
            </div>

            <!-- Workflow section -->
            <div class="mt-16 grid gap-10 lg:grid-cols-2 lg:items-center">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">A simple, guided payroll workflow.</h2>
                    <p class="mt-3 text-gray-600">
                        {{ config('app.name') }} walks you through each step, from importing timesheets to approving payouts, so
                        nothing slips through the cracks.
                    </p>
                    <ul class="mt-4 space-y-3 text-sm text-gray-700">
                        <li class="flex items-start">
                            <span class="mt-0.5 text-indigo-600">1.</span>
                            <span class="ml-2">
                                <span class="font-semibold">Review changes</span> – see salary updates, new hires, and terminations since last run.
                            </span>
                        </li>
                        <li class="flex items-start">
                            <span class="mt-0.5 text-indigo-600">2.</span>
                            <span class="ml-2">
                                <span class="font-semibold">Validate payroll</span> – catch anomalies automatically flagged by the system.
                            </span>
                        </li>
                        <li class="flex items-start">
                            <span class="mt-0.5 text-indigo-600">3.</span>
                            <span class="ml-2">
                                <span class="font-semibold">Run & export</span> – finalize payroll, generate payslips, and export data for accounting.
                            </span>
                        </li>
                    </ul>
                </div>

                <div class="bg-white rounded-2xl shadow-lg border p-6">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm font-medium text-gray-700">Payroll run – February</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-50 text-yellow-700">
                            In review
                        </span>
                    </div>
                    <ol class="space-y-4 text-sm">
                        <li class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <span class="w-6 h-6 rounded-full bg-indigo-600 text-white text-xs flex items-center justify-center">1</span>
                                <span>Import & validate data</span>
                            </div>
                            <span class="text-xs text-green-600">Completed</span>
                        </li>
                        <li class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <span class="w-6 h-6 rounded-full bg-indigo-600 text-white text-xs flex items-center justify-center">2</span>
                                <span>Review exceptions</span>
                            </div>
                            <span class="text-xs text-yellow-600">3 pending</span>
                        </li>
                        <li class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <span class="w-6 h-6 rounded-full bg-indigo-600 text-white text-xs flex items-center justify-center">3</span>
                                <span>Approve & run payroll</span>
                            </div>
                            <span class="text-xs text-gray-400">Not started</span>
                        </li>
                    </ol>
                    <button
                        class="mt-6 w-full inline-flex items-center justify-center px-4 py-2 rounded-md text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700">
                        Continue review
                    </button>
                </div>
            </div>

            <!-- Security & compliance -->
            <div class="mt-16 border-t pt-10">
                <div class="grid gap-8 md:grid-cols-3">
                    <div>
                        <h3 class="text-base font-semibold text-gray-900">Security-first architecture</h3>
                        <p class="mt-2 text-sm text-gray-600">
                            Data is encrypted at rest and in transit with strict access controls and audit trails.
                        </p>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-900">Compliance updates</h3>
                        <p class="mt-2 text-sm text-gray-600">
                            We continuously update rules to align with evolving payroll and tax regulations.
                        </p>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-900">Reliable availability</h3>
                        <p class="mt-2 text-sm text-gray-600">
                            Designed for high availability so you can run payroll on time, every time.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
            <div class="bg-indigo-600 rounded-2xl px-6 py-10 md:px-10 md:py-12 flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">
                <div>
                    <h2 class="text-2xl font-semibold text-white">See {{ config('app.name') }} in action.</h2>
                    <p class="mt-2 text-indigo-100 text-sm">
                        Book a live demo with our team and explore a real payroll run from end to end.
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-4 space-y-3 sm:space-y-0">
                    <a href="{{ route('contact') }}"
                       class="inline-flex items-center justify-center px-6 py-3 rounded-md text-base font-semibold text-indigo-700 bg-white hover:bg-indigo-50">
                        Book a demo
                    </a>
                    @if (Route::has('company.signup'))
                        <a href="{{ route('company.signup') }}"
                           class="inline-flex items-center justify-center px-6 py-3 rounded-md text-base font-semibold text-white border border-indigo-200 hover:bg-indigo-500">
                            Start free trial
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

