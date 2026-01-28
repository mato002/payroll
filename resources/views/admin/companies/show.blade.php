@extends('layouts.layout')

@section('title', 'Company Details')

@section('content')
    <main class="flex-1">
        <div class="mx-auto max-w-5xl px-4 py-6 sm:px-6 lg:px-8 space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                        {{ $company->name }}
                    </h1>
                    @if($company->legal_name)
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            {{ $company->legal_name }}
                        </p>
                    @endif
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Created {{ $company->created_at->format('M d, Y') }}
                    </p>
                </div>

                <div class="flex items-center gap-2">
                    @if(Route::has('companies.company.admin.dashboard.path'))
                        <a href="{{ route('companies.company.admin.dashboard.path', ['company' => $company->slug]) }}"
                           class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-xs font-medium text-white hover:bg-indigo-700">
                            Go to company dashboard
                        </a>
                    @endif
                    <a href="{{ route('admin.companies.index') }}"
                       class="inline-flex items-center rounded-md border border-gray-200 bg-white px-3 py-2 text-xs font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:hover:bg-gray-800">
                        Back to list
                    </a>
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-800 dark:bg-gray-950">
                    <h2 class="text-sm font-semibold text-gray-900 dark:text-gray-100 mb-3">Company Info</h2>
                    <dl class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                        <div class="flex justify-between">
                            <dt class="text-gray-500 dark:text-gray-400">Registration No.</dt>
                            <dd>{{ $company->registration_number ?: '—' }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500 dark:text-gray-400">Tax ID</dt>
                            <dd>{{ $company->tax_id ?: '—' }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500 dark:text-gray-400">Billing email</dt>
                            <dd>{{ $company->billing_email ?: '—' }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500 dark:text-gray-400">Country</dt>
                            <dd>{{ $company->country ?: '—' }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500 dark:text-gray-400">Currency</dt>
                            <dd>{{ $company->currency ?: '—' }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500 dark:text-gray-400">Status</dt>
                            <dd>
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $company->is_active ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300' : 'bg-gray-100 text-gray-700 dark:bg-gray-900/40 dark:text-gray-300' }}">
                                    {{ $company->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </dd>
                        </div>
                    </dl>
                </div>

                <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-800 dark:bg-gray-950">
                    <h2 class="text-sm font-semibold text-gray-900 dark:text-gray-100 mb-3">Subscription</h2>
                    @php
                        $sub = $company->subscriptions->first();
                    @endphp
                    @if($sub)
                        <dl class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                            <div class="flex justify-between">
                                <dt class="text-gray-500 dark:text-gray-400">Plan</dt>
                                <dd>{{ optional($sub->plan)->name ?? $sub->plan_code }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-500 dark:text-gray-400">Status</dt>
                                <dd>
                                    @php
                                        $subColor = match($sub->status) {
                                            'active' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300',
                                            'trial' => 'bg-sky-100 text-sky-700 dark:bg-sky-900/30 dark:text-sky-300',
                                            'past_due' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300',
                                            default => 'bg-gray-100 text-gray-700 dark:bg-gray-900/40 dark:text-gray-300',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $subColor }}">
                                        {{ strtoupper($sub->status) }}
                                    </span>
                                </dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-500 dark:text-gray-400">Next billing</dt>
                                <dd>{{ optional($sub->next_billing_date)->format('M d, Y') ?: '—' }}</dd>
                            </div>
                        </dl>
                    @else
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            No subscription found for this company.
                        </p>
                    @endif
                </div>
            </div>

            <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-800 dark:bg-gray-950">
                <h2 class="text-sm font-semibold text-gray-900 dark:text-gray-100 mb-3">Members (first 10)</h2>
                @if($company->members->isEmpty())
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        No members found for this company.
                    </p>
                @else
                    <ul class="divide-y divide-gray-200 text-sm dark:divide-gray-800">
                        @foreach($company->members->take(10) as $member)
                            <li class="flex items-center justify-between py-2">
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-gray-100">
                                        {{ $member->name }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $member->email }}
                                    </p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </main>
@endsection

