@extends('layouts.layout')

@section('title', 'Change Subscription Plan')

@section('content')
<div class="flex-1">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-8">
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                {{ $isUpgrade ? 'Upgrade' : ($isDowngrade ? 'Downgrade' : 'Change') }} Subscription Plan
            </h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Review your plan change before confirming</p>
        </div>

        {{-- Comparison --}}
        <div class="mb-8 grid gap-6 md:grid-cols-2">
            {{-- Current Plan --}}
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-950">
                <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-gray-100">Current Plan</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Plan Name</p>
                        <p class="mt-1 text-xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $currentSubscription->plan->name ?? $currentSubscription->plan_code }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Price</p>
                        <p class="mt-1 text-2xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $currentSubscription->currency }} {{ number_format($currentSubscription->base_price, 2) }}
                            <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                /{{ $currentSubscription->billing_cycle ?? 'month' }}
                            </span>
                        </p>
                    </div>
                    @if($currentSubscription->per_employee_price > 0)
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Per Employee</p>
                        <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">
                            {{ $currentSubscription->currency }} {{ number_format($currentSubscription->per_employee_price, 2) }}
                        </p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- New Plan --}}
            <div class="rounded-xl border-2 border-indigo-500 bg-indigo-50 p-6 shadow-sm dark:border-indigo-600 dark:bg-indigo-900/20">
                <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-gray-100">New Plan</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Plan Name</p>
                        <p class="mt-1 text-xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $newPlan->name }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Price</p>
                        <p class="mt-1 text-2xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $newPlan->currency ?? 'USD' }} {{ number_format($newPlan->base_price, 2) }}
                            <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                /{{ $newPlan->billing_model === 'monthly' ? 'month' : 'year' }}
                            </span>
                        </p>
                    </div>
                    @if($newPlan->price_per_employee > 0)
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Per Employee</p>
                        <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">
                            {{ $newPlan->currency ?? 'USD' }} {{ number_format($newPlan->price_per_employee, 2) }}
                        </p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Price Difference --}}
        @php
            $priceDiff = $newPlan->base_price - $currentSubscription->base_price;
        @endphp
        <div class="mb-8 rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-950">
            <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-gray-100">Price Change</h3>
            <div class="flex items-center gap-2">
                @if($priceDiff > 0)
                <span class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">
                    +{{ $currentSubscription->currency }} {{ number_format(abs($priceDiff), 2) }}
                </span>
                <span class="text-sm text-gray-500 dark:text-gray-400">per billing cycle</span>
                @elseif($priceDiff < 0)
                <span class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">
                    -{{ $currentSubscription->currency }} {{ number_format(abs($priceDiff), 2) }}
                </span>
                <span class="text-sm text-gray-500 dark:text-gray-400">per billing cycle</span>
                @else
                <span class="text-2xl font-bold text-gray-600 dark:text-gray-400">No price change</span>
                @endif
            </div>
        </div>

        {{-- Features Comparison --}}
        @if($newPlan->features && is_array($newPlan->features))
        <div class="mb-8 rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-950">
            <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-gray-100">Plan Features</h3>
            <ul class="space-y-2">
                @foreach($newPlan->features as $feature)
                <li class="flex items-start">
                    <svg class="mr-2 h-5 w-5 flex-shrink-0 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="text-sm text-gray-700 dark:text-gray-300">{{ $feature }}</span>
                </li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Important Notes --}}
        <div class="mb-8 rounded-xl border border-amber-200 bg-amber-50 p-6 dark:border-amber-800 dark:bg-amber-900/20">
            <h3 class="mb-2 text-sm font-semibold text-amber-900 dark:text-amber-100">Important Information</h3>
            <ul class="space-y-1 text-sm text-amber-800 dark:text-amber-200">
                <li>• Your current subscription will be canceled immediately</li>
                <li>• The new plan will be activated right away</li>
                <li>• You'll be billed for the new plan on your next billing cycle</li>
                @if($isDowngrade)
                <li>• Downgrading may result in loss of access to some features</li>
                @endif
            </ul>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-end gap-4">
            <a href="{{ route('companies.subscriptions.index', ['company' => currentCompany()?->slug]) }}" 
               class="rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:hover:bg-gray-800">
                Cancel
            </a>
            <form method="POST" action="{{ route('companies.subscriptions.change-plan.store', ['company' => currentCompany()?->slug, 'plan' => $newPlan]) }}">
                @csrf
                <input type="hidden" name="confirm" value="1">
                <button type="submit" 
                        class="rounded-lg bg-indigo-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Confirm {{ $isUpgrade ? 'Upgrade' : ($isDowngrade ? 'Downgrade' : 'Change') }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
