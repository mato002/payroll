@extends('layouts.layout')

@section('title', 'Onboarding – Company profile')

@section('content')
    <div
        x-data="onboardingWizard()"
        x-init="init(@js($company))"
        class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10"
    >
        <!-- Step indicator -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-4">Finish setting up your company</h1>
            <ol class="flex items-center text-xs sm:text-sm text-gray-500 space-x-2 sm:space-x-4">
                <template x-for="(step, index) in steps" :key="index">
                    <li class="flex items-center">
                        <div class="flex items-center">
                            <div
                                class="w-6 h-6 rounded-full border flex items-center justify-center mr-2"
                                :class="{
                                    'bg-indigo-600 border-indigo-600 text-white': currentStep === index + 1,
                                    'bg-indigo-50 border-indigo-600 text-indigo-600': index + 1 < currentStep,
                                    'border-gray-300 text-gray-500': index + 1 > currentStep
                                }"
                            >
                                <span x-text="index + 1"></span>
                            </div>
                            <span x-text="step.label" class="hidden sm:inline"></span>
                        </div>
                        <span x-show="index < steps.length - 1" class="mx-1 sm:mx-2 text-gray-300">—</span>
                    </li>
                </template>
            </ol>
        </div>

        <!-- Flash status -->
        @if (session('status'))
            <div class="mb-4 rounded-md bg-green-50 p-3 text-sm text-green-700" role="status">
                {{ session('status') }}
            </div>
        @endif

        <!-- Validation summary (server-side) -->
        @if ($errors->any())
            <div class="mb-4 rounded-md bg-red-50 p-3 text-sm text-red-700" role="alert">
                <p class="font-medium">Please review the highlighted fields in each step.</p>
            </div>
        @endif

        <form
            method="POST"
            action="{{ route('onboarding.company.profile.update') }}"
            enctype="multipart/form-data"
            @submit="return handleSubmit($event)"
            class="bg-white shadow-sm border rounded-2xl p-6 space-y-8"
        >
            @csrf

            <!-- Step 1: Company details -->
            <section x-show="currentStep === 1" x-cloak>
                <h2 class="text-lg font-semibold text-gray-900 mb-1">1. Company details</h2>
                <p class="text-xs text-gray-600 mb-4">
                    Confirm the basic details that will appear on payslips and invoices.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="legal_name" class="block text-xs font-medium text-gray-700">Legal name</label>
                        <input
                            id="legal_name"
                            type="text"
                            name="legal_name"
                            x-model="form.legal_name"
                            class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        >
                        @error('legal_name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tax_id" class="block text-xs font-medium text-gray-700">Tax ID</label>
                        <input
                            id="tax_id"
                            type="text"
                            name="tax_id"
                            x-model="form.tax_id"
                            class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        >
                        @error('tax_id')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="currency" class="block text-xs font-medium text-gray-700">
                            Currency <span class="text-[11px] text-gray-400">(e.g. KES, USD)</span>
                        </label>
                        <input
                            id="currency"
                            type="text"
                            name="currency"
                            x-model="form.currency"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            :class="stepErrors.currency ? 'border-red-500' : ''"
                        >
                        <p x-show="stepErrors.currency" class="mt-1 text-xs text-red-600" x-text="stepErrors.currency"></p>
                        @error('currency')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="billing_email" class="block text-xs font-medium text-gray-700">Billing email</label>
                        <input
                            id="billing_email"
                            type="email"
                            name="billing_email"
                            x-model="form.billing_email"
                            class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            :class="stepErrors.billing_email ? 'border-red-500' : ''"
                        >
                        <p x-show="stepErrors.billing_email" class="mt-1 text-xs text-red-600" x-text="stepErrors.billing_email"></p>
                        @error('billing_email')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="logo" class="block text-xs font-medium text-gray-700">Company logo</label>
                        <input
                            id="logo"
                            type="file"
                            name="logo"
                            accept="image/*"
                            class="mt-1 block w-full text-sm text-gray-700"
                        >
                        <p class="mt-1 text-[11px] text-gray-500">Optional. PNG or JPG, up to 2MB.</p>
                    </div>
                </div>
            </section>

            <!-- Step 2: Tax & payroll settings -->
            <section x-show="currentStep === 2" x-cloak>
                <h2 class="text-lg font-semibold text-gray-900 mb-1">2. Tax & payroll settings</h2>
                <p class="text-xs text-gray-600 mb-4">
                    Set the default country, timezone, and address for tax and payroll calculations.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="country" class="block text-xs font-medium text-gray-700">Country</label>
                        <input
                            id="country"
                            type="text"
                            name="country"
                            x-model="form.country"
                            class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        >
                    </div>
                    <div>
                        <label for="timezone" class="block text-xs font-medium text-gray-700">Timezone</label>
                        <input
                            id="timezone"
                            type="text"
                            name="timezone"
                            x-model="form.timezone"
                            class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        >
                    </div>

                    <div class="sm:col-span-2">
                        <label for="address_line1" class="block text-xs font-medium text-gray-700">Address line 1</label>
                        <input
                            id="address_line1"
                            type="text"
                            name="address_line1"
                            x-model="form.address_line1"
                            class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        >
                    </div>
                    <div class="sm:col-span-2">
                        <label for="address_line2" class="block text-xs font-medium text-gray-700">Address line 2</label>
                        <input
                            id="address_line2"
                            type="text"
                            name="address_line2"
                            x-model="form.address_line2"
                            class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        >
                    </div>

                    <div>
                        <label for="city" class="block text-xs font-medium text-gray-700">City</label>
                        <input
                            id="city"
                            type="text"
                            name="city"
                            x-model="form.city"
                            class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        >
                    </div>
                    <div>
                        <label for="state" class="block text-xs font-medium text-gray-700">State/Region</label>
                        <input
                            id="state"
                            type="text"
                            name="state"
                            x-model="form.state"
                            class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        >
                    </div>
                    <div>
                        <label for="postal_code" class="block text-xs font-medium text-gray-700">Postal code</label>
                        <input
                            id="postal_code"
                            type="text"
                            name="postal_code"
                            x-model="form.postal_code"
                            class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        >
                    </div>
                </div>
            </section>

            <!-- Step 3: Admin user confirmation -->
            <section x-show="currentStep === 3" x-cloak>
                <h2 class="text-lg font-semibold text-gray-900 mb-1">3. Admin user confirmation</h2>
                <p class="text-xs text-gray-600 mb-4">
                    Confirm who should receive critical payroll notifications and approvals.
                </p>

                <div class="space-y-4">
                    <div class="flex items-center space-x-3 p-3 border rounded-lg bg-gray-50">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">
                                {{ auth()->user()->name ?? 'Admin user' }}
                            </p>
                            <p class="text-xs text-gray-600">
                                {{ auth()->user()->email ?? '' }}
                            </p>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-indigo-50 text-indigo-700">
                            Company admin
                        </span>
                    </div>

                    <label class="flex items-start space-x-2 text-xs text-gray-700">
                        <input
                            type="checkbox"
                            x-model="form.notify_admin_for_payroll"
                            name="notify_admin_for_payroll"
                            class="mt-1 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                        >
                        <span>
                            Send payroll run notifications and approvals to this admin.
                        </span>
                    </label>
                </div>
            </section>

            <!-- Step 4: Subscription plan selection (informational) -->
            <section x-show="currentStep === 4" x-cloak>
                <h2 class="text-lg font-semibold text-gray-900 mb-1">4. Subscription plan selection</h2>
                <p class="text-xs text-gray-600 mb-4">
                    Your current subscription plan is managed at the platform level. You can change it anytime from the billing section.
                </p>

                <div class="border rounded-xl p-4 bg-indigo-50 border-indigo-100 text-sm text-gray-800">
                    <p class="font-medium text-indigo-900">Current plan</p>
                    <p class="mt-1 text-xs text-indigo-900">
                        This company is subscribed via the main platform billing configuration.
                    </p>
                </div>
            </section>

            <!-- Actions -->
            <div class="pt-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 border-t">
                <div class="flex items-center space-x-3 text-xs text-gray-500">
                    <button
                        type="button"
                        class="inline-flex items-center px-3 py-1.5 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50"
                        @click="saveDraft"
                        :disabled="saving"
                    >
                        <span x-show="!saving">Save draft</span>
                        <span x-show="saving">Saving…</span>
                    </button>
                    <p x-show="lastSavedAt" x-text="'Last saved ' + lastSavedAt"></p>
                </div>

                <div class="flex items-center justify-end space-x-2">
                    <button
                        type="button"
                        class="px-4 py-2 rounded-md border border-gray-300 text-xs font-medium text-gray-700 hover:bg-gray-50"
                        @click="prevStep"
                        x-show="currentStep > 1"
                    >
                        Back
                    </button>
                    <button
                        type="button"
                        class="px-4 py-2 rounded-md bg-indigo-600 text-white text-xs font-semibold hover:bg-indigo-700"
                        @click="nextStep"
                        x-show="currentStep < steps.length"
                    >
                        Continue
                    </button>
                    <button
                        type="submit"
                        class="px-4 py-2 rounded-md bg-indigo-600 text-white text-xs font-semibold hover:bg-indigo-700"
                        x-show="currentStep === steps.length"
                    >
                        Finish setup
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        function onboardingWizard() {
            return {
                steps: [
                    { key: 'company', label: 'Company details' },
                    { key: 'tax', label: 'Tax & payroll settings' },
                    { key: 'admin', label: 'Admin user' },
                    { key: 'plan', label: 'Subscription' },
                ],
                currentStep: 1,
                form: {
                    legal_name: '',
                    tax_id: '',
                    currency: '',
                    billing_email: '',
                    country: '',
                    timezone: '',
                    address_line1: '',
                    address_line2: '',
                    city: '',
                    state: '',
                    postal_code: '',
                    notify_admin_for_payroll: true,
                },
                stepErrors: {},
                saving: false,
                lastSavedAt: null,

                init(company) {
                    if (company) {
                        this.form.legal_name = company.legal_name || '';
                        this.form.tax_id = company.tax_id || '';
                        this.form.currency = company.currency || '';
                        this.form.billing_email = company.billing_email || '';
                        this.form.country = company.country || '';
                        this.form.timezone = company.timezone || '';
                        this.form.address_line1 = company.address_line1 || '';
                        this.form.address_line2 = company.address_line2 || '';
                        this.form.city = company.city || '';
                        this.form.state = company.state || '';
                        this.form.postal_code = company.postal_code || '';
                    }

                    const draft = window.localStorage.getItem('onboarding_company_profile');
                    if (draft) {
                        try {
                            const parsed = JSON.parse(draft);
                            this.form = { ...this.form, ...parsed.form };
                            this.currentStep = parsed.currentStep || 1;
                            this.lastSavedAt = parsed.lastSavedAt || null;
                        } catch (e) {
                            console.warn('Failed to parse onboarding draft', e);
                        }
                    }
                },

                validateStep() {
                    this.stepErrors = {};

                    if (this.currentStep === 1) {
                        if (!this.form.currency) {
                            this.stepErrors.currency = 'Currency is required.';
                        }
                        if (this.form.billing_email && !this.form.billing_email.includes('@')) {
                            this.stepErrors.billing_email = 'Enter a valid email address.';
                        }
                    }

                    return Object.keys(this.stepErrors).length === 0;
                },

                nextStep() {
                    if (!this.validateStep()) return;
                    if (this.currentStep < this.steps.length) {
                        this.currentStep++;
                        this.persistDraft();
                    }
                },

                prevStep() {
                    if (this.currentStep > 1) {
                        this.currentStep--;
                        this.persistDraft();
                    }
                },

                handleSubmit(event) {
                    if (!this.validateStep()) {
                        event.preventDefault();
                        return false;
                    }
                    this.persistDraft();
                    return true;
                },

                saveDraft() {
                    this.saving = true;
                    this.persistDraft();
                    setTimeout(() => {
                        this.saving = false;
                    }, 600);
                },

                persistDraft() {
                    const payload = {
                        form: this.form,
                        currentStep: this.currentStep,
                        lastSavedAt: new Date().toLocaleTimeString(),
                    };
                    window.localStorage.setItem('onboarding_company_profile', JSON.stringify(payload));
                    this.lastSavedAt = payload.lastSavedAt;
                },
            };
        }
    </script>
@endsection

