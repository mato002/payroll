@extends('layouts.layout')

@section('title', __('Run payroll'))

@section('content')
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                    {{ __('Run payroll') }}
                </h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ currentCompany()?->name }} · {{ __('Step :step of 4', ['step' => $step]) }}
                </p>
            </div>
        </div>

        {{-- Stepper --}}
        <ol class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-2 text-xs font-medium text-gray-600 dark:text-gray-300">
            @php
                $steps = [
                    1 => __('Select period'),
                    2 => __('Review employees'),
                    3 => __('Review calculations'),
                    4 => __('Confirm & submit'),
                ];
            @endphp

            @foreach($steps as $index => $label)
                @php
                    $state = $index < $step ? 'complete' : ($index === $step ? 'current' : 'upcoming');
                @endphp
                <li class="flex-1 flex items-center w-full sm:w-auto">
                    <div class="flex items-center gap-2 sm:gap-2 w-full sm:w-auto">
                        <div
                            class="flex h-10 w-10 sm:h-8 sm:w-8 items-center justify-center rounded-full border text-xs shrink-0
                                @if($state === 'complete')
                                    border-emerald-500 bg-emerald-500 text-white
                                @elseif($state === 'current')
                                    border-indigo-600 bg-indigo-600 text-white
                                @else
                                    border-gray-300 bg-white text-gray-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400
                                @endif"
                        >
                            {{ $index }}
                        </div>
                        <span
                            class="text-sm sm:text-xs @if($state === 'current') text-indigo-600 dark:text-indigo-300 font-semibold @elseif($state === 'complete') text-emerald-600 dark:text-emerald-300 @else text-gray-500 dark:text-gray-400 @endif"
                        >
                            {{ $label }}
                        </span>
                    </div>
                    @if($index < count($steps))
                        <div class="hidden sm:block mx-2 h-px flex-1 bg-gray-200 dark:bg-gray-700"></div>
                    @endif
                </li>
            @endforeach
        </ol>

        {{-- Errors --}}
        @if ($errors->any())
            <div class="rounded-md border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700 dark:border-rose-900/50 dark:bg-rose-950 dark:text-rose-200">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Wizard content --}}
        <div class="rounded-xl border border-gray-200 bg-white p-4 sm:p-6 shadow-sm dark:border-gray-800 dark:bg-gray-950">
            @php
                $wizardStoreRoute = Route::has('companies.payroll.runs.path.wizard.store') 
                    ? 'companies.payroll.runs.path.wizard.store' 
                    : 'payroll.runs.wizard.store';
                $wizardCreateRoute = Route::has('companies.payroll.runs.path.wizard.create') 
                    ? 'companies.payroll.runs.path.wizard.create' 
                    : 'payroll.runs.wizard.create';
            @endphp
            <form method="POST" action="{{ route($wizardStoreRoute, ['company' => currentCompany()?->slug]) }}">
                @csrf
                <input type="hidden" name="step" value="{{ $step }}">

                @if ($step === 1)
                    {{-- Step 1: Select period --}}
                    <div class="space-y-4">
                        <h2 class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                            {{ __('1. Select payroll period') }}
                        </h2>

                        <div class="grid gap-4 grid-cols-1 sm:grid-cols-3">
                            <label class="text-xs font-medium text-gray-700 dark:text-gray-300">
                                <span class="mb-1 block">{{ __('Period start date') }}</span>
                                <input
                                    type="date"
                                    name="period_start_date"
                                    value="{{ old('period_start_date', $wizard['period_start_date'] ?? '') }}"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 text-base sm:text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 py-2.5 sm:py-1.5"
                                >
                            </label>

                            <label class="text-xs font-medium text-gray-700 dark:text-gray-300">
                                <span class="mb-1 block">{{ __('Period end date') }}</span>
                                <input
                                    type="date"
                                    name="period_end_date"
                                    value="{{ old('period_end_date', $wizard['period_end_date'] ?? '') }}"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 text-base sm:text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 py-2.5 sm:py-1.5"
                                >
                            </label>

                            <label class="text-xs font-medium text-gray-700 dark:text-gray-300">
                                <span class="mb-1 block">{{ __('Pay date') }}</span>
                                <input
                                    type="date"
                                    name="pay_date"
                                    value="{{ old('pay_date', $wizard['pay_date'] ?? '') }}"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 text-base sm:text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 py-2.5 sm:py-1.5"
                                >
                            </label>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            <label class="text-xs font-medium text-gray-700 dark:text-gray-300">
                                <span class="mb-1 block">{{ __('Run name (optional)') }}</span>
                                <input
                                    type="text"
                                    name="name"
                                    value="{{ old('name', $wizard['name'] ?? '') }}"
                                    placeholder="{{ __('Monthly payroll :period', ['period' => now()->format('F Y')]) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
                                >
                            </label>

                            <label class="text-xs font-medium text-gray-700 dark:text-gray-300">
                                <span class="mb-1 block">{{ __('Description (optional)') }}</span>
                                <textarea
                                    name="description"
                                    rows="2"
                                    class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
                                >{{ old('description', $wizard['description'] ?? '') }}</textarea>
                            </label>
                        </div>
                    </div>
                @elseif ($step === 2)
                    {{-- Step 2: Review employees --}}
                    <div class="space-y-4">
                        <h2 class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                            {{ __('2. Review employees in this run') }}
                        </h2>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ __('The following active employees will be included in this payroll run.') }}
                        </p>

                        <div class="overflow-x-auto -mx-4 sm:mx-0 rounded-lg border border-gray-200 dark:border-gray-800">
                            <div class="inline-block min-w-full align-middle px-4 sm:px-0">
                                <table class="min-w-full divide-y divide-gray-200 text-xs dark:divide-gray-800">
                                <thead class="bg-gray-50 dark:bg-gray-900/40">
                                <tr>
                                    <th class="px-3 py-2 text-left font-semibold text-gray-500 dark:text-gray-400">{{ __('Code') }}</th>
                                    <th class="px-3 py-2 text-left font-semibold text-gray-500 dark:text-gray-400">{{ __('Name') }}</th>
                                    <th class="px-3 py-2 text-left font-semibold text-gray-500 dark:text-gray-400">{{ __('Job title') }}</th>
                                    <th class="px-3 py-2 text-left font-semibold text-gray-500 dark:text-gray-400">{{ __('Status') }}</th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 bg-white dark:divide-gray-800 dark:bg-gray-950">
                                @forelse($employees as $employee)
                                    <tr>
                                        <td class="px-3 py-1.5 whitespace-nowrap">{{ $employee->employee_code }}</td>
                                        <td class="px-3 py-1.5 whitespace-nowrap">
                                            {{ $employee->first_name }} {{ $employee->last_name }}
                                        </td>
                                        <td class="px-3 py-1.5 whitespace-nowrap text-gray-600 dark:text-gray-300">
                                            {{ $employee->job_title ?? '—' }}
                                        </td>
                                        <td class="px-3 py-1.5 whitespace-nowrap text-xs">
                                            <span class="inline-flex items-center rounded-full bg-emerald-50 px-2 py-0.5 text-[11px] font-medium text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300">
                                                {{ __('Active') }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-3 py-3 text-center text-xs text-gray-500 dark:text-gray-400">
                                            {{ __('No active employees found for this company.') }}
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                @elseif ($step === 3)
                    {{-- Step 3: Review calculations (summary) --}}
                    <div class="space-y-4">
                        <h2 class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                            {{ __('3. Review calculations (preview)') }}
                        </h2>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ __('A detailed breakdown will be available after processing. Below is a summary preview based on current employees and salary structures.') }}
                        </p>

                        <div class="grid gap-4 grid-cols-1 sm:grid-cols-3">
                            <div class="rounded-lg border border-gray-200 bg-gray-50 p-4 sm:p-3 text-xs dark:border-gray-800 dark:bg-gray-900">
                                <p class="font-medium text-gray-700 dark:text-gray-200">
                                    {{ __('Employees in run') }}
                                </p>
                                <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $employees->count() }}
                                </p>
                            </div>
                            <div class="rounded-lg border border-gray-200 bg-gray-50 p-3 text-xs dark:border-gray-800 dark:bg-gray-900">
                                <p class="font-medium text-gray-700 dark:text-gray-200">
                                    {{ __('Estimated total earnings') }}
                                </p>
                                <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    {{ __('Will be calculated') }}
                                </p>
                            </div>
                            <div class="rounded-lg border border-gray-200 bg-gray-50 p-3 text-xs dark:border-gray-800 dark:bg-gray-900">
                                <p class="font-medium text-gray-700 dark:text-gray-200">
                                    {{ __('Estimated total net pay') }}
                                </p>
                                <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    {{ __('Will be calculated') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @elseif ($step === 4)
                    {{-- Step 4: Confirm & submit --}}
                    <div class="space-y-4">
                        <h2 class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                            {{ __('4. Confirm and submit for approval') }}
                        </h2>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ __('Review the details below and confirm to create this payroll run. The system will calculate all employee payrolls and automatically submit it for approval.') }}
                        </p>

                        <dl class="grid gap-4 grid-cols-1 sm:grid-cols-2 text-xs">
                            <div class="rounded-lg border border-gray-200 bg-gray-50 p-4 sm:p-3 dark:border-gray-800 dark:bg-gray-900">
                                <dt class="font-medium text-gray-700 dark:text-gray-200">{{ __('Period') }}</dt>
                                <dd class="mt-1 text-gray-900 dark:text-gray-100">
                                    {{ $wizard['period_start_date'] ?? '—' }} → {{ $wizard['period_end_date'] ?? '—' }}
                                </dd>
                            </div>
                            <div class="rounded-lg border border-gray-200 bg-gray-50 p-3 dark:border-gray-800 dark:bg-gray-900">
                                <dt class="font-medium text-gray-700 dark:text-gray-200">{{ __('Pay date') }}</dt>
                                <dd class="mt-1 text-gray-900 dark:text-gray-100">
                                    {{ $wizard['pay_date'] ?? '—' }}
                                </dd>
                            </div>
                            <div class="rounded-lg border border-gray-200 bg-gray-50 p-3 dark:border-gray-800 dark:bg-gray-900">
                                <dt class="font-medium text-gray-700 dark:text-gray-200">{{ __('Run name') }}</dt>
                                <dd class="mt-1 text-gray-900 dark:text-gray-100">
                                    {{ $wizard['name'] ?? __('Monthly payroll') }}
                                </dd>
                            </div>
                            <div class="rounded-lg border border-gray-200 bg-gray-50 p-3 dark:border-gray-800 dark:bg-gray-900">
                                <dt class="font-medium text-gray-700 dark:text-gray-200">{{ __('Employees in run') }}</dt>
                                <dd class="mt-1 text-gray-900 dark:text-gray-100">
                                    {{ $employees->count() }}
                                </dd>
                            </div>
                        </dl>

                        <div class="rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-xs text-amber-800 dark:border-amber-900/60 dark:bg-amber-950 dark:text-amber-200">
                            <p class="font-medium mb-1">{{ __('Important:') }}</p>
                            <p>{{ __('By confirming, the system will calculate payroll for all active employees in the selected period and automatically submit the run for approval. Any configuration errors (missing salary data, etc.) will be reported. Once submitted, authorized approvers can review and approve the payroll run.') }}</p>
                        </div>
                    </div>
                @endif

                {{-- Navigation buttons --}}
                <div class="mt-6 flex flex-col-reverse sm:flex-row items-stretch sm:items-center justify-between gap-3 sm:gap-0">
                    <div>
                        @if($step > 1)
                            <a
                                href="{{ route($wizardCreateRoute, ['company' => currentCompany()?->slug, 'step' => $step - 1]) }}"
                                class="inline-flex items-center justify-center rounded-md border border-gray-200 bg-white px-4 py-3 sm:py-2 text-sm sm:text-xs font-medium text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:hover:bg-gray-800 min-h-[44px] w-full sm:w-auto"
                            >
                                {{ __('Back') }}
                            </a>
                        @endif
                    </div>

                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        @if($step < 4)
                            <button
                                type="submit"
                                class="inline-flex items-center justify-center rounded-md bg-indigo-600 px-6 py-3 sm:py-2 text-sm sm:text-xs font-medium text-white shadow-sm hover:bg-indigo-700 min-h-[44px] w-full sm:w-auto"
                            >
                                {{ __('Next') }}
                            </button>
                        @else
                            <button
                                type="submit"
                                class="inline-flex items-center justify-center rounded-md bg-emerald-600 px-6 py-3 sm:py-2 text-sm sm:text-xs font-medium text-white shadow-sm hover:bg-emerald-700 min-h-[44px] w-full sm:w-auto"
                            >
                                {{ __('Confirm & run payroll') }}
                            </button>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

