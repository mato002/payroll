@extends('layouts.marketing')

@section('title', 'Contact – ' . config('app.name'))

@section('content')
    <section class="bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-20">
            <div class="text-center">
                <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900">Talk to our team.</h1>
                <p class="mt-3 text-gray-600 max-w-xl mx-auto">
                    Have questions about pricing, implementation, or security? Send us a message and we’ll respond within one business day.
                </p>
            </div>

            <div class="mt-10 grid gap-10 md:grid-cols-3">
                <!-- Contact info -->
                <div class="md:col-span-1 space-y-6 text-sm text-gray-700">
                    <div>
                        <h2 class="text-base font-semibold text-gray-900">Sales</h2>
                        <p class="mt-1 text-gray-600">
                            For demos, pricing, and custom requirements.
                        </p>
                        <p class="mt-1 text-indigo-600">sales@example.com</p>
                    </div>
                    <div>
                        <h2 class="text-base font-semibold text-gray-900">Support</h2>
                        <p class="mt-1 text-gray-600">
                            For technical issues and product questions.
                        </p>
                        <p class="mt-1 text-indigo-600">support@example.com</p>
                    </div>
                    <div>
                        <h2 class="text-base font-semibold text-gray-900">Office</h2>
                        <p class="mt-1 text-gray-600">
                            123 Payroll Street<br>
                            Suite 400<br>
                            Example City, Country
                        </p>
                    </div>
                </div>

                <!-- Contact form -->
                <div class="md:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm border p-6 sm:p-8">
                        @if (session('status'))
                            <div class="mb-4 rounded-md bg-green-50 p-3 text-sm text-green-700">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('contact.submit') }}" class="space-y-4">
                            @csrf
                            <div class="grid gap-4 sm:grid-cols-2">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Full name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                    @error('name')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="company" class="block text-sm font-medium text-gray-700">Company</label>
                                    <input type="text" name="company" id="company" value="{{ old('company') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                    @error('company')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid gap-4 sm:grid-cols-2">
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Work email</label>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                    @error('email')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="employees" class="block text-sm font-medium text-gray-700">Employees</label>
                                    <select id="employees" name="employees"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                        <option value="">Select</option>
                                        <option value="1-15" @selected(old('employees') === '1-15')>1–15</option>
                                        <option value="16-50" @selected(old('employees') === '16-50')>16–50</option>
                                        <option value="51-200" @selected(old('employees') === '51-200')>51–200</option>
                                        <option value="200+" @selected(old('employees') === '200+')>200+</option>
                                    </select>
                                    @error('employees')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="topic" class="block text-sm font-medium text-gray-700">Topic</label>
                                <select id="topic" name="topic"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                    <option value="demo" @selected(old('topic') === 'demo')>Product demo</option>
                                    <option value="pricing" @selected(old('topic') === 'pricing')>Pricing</option>
                                    <option value="implementation" @selected(old('topic') === 'implementation')>Implementation</option>
                                    <option value="support" @selected(old('topic') === 'support')>Support</option>
                                    <option value="other" @selected(old('topic') === 'other')>Other</option>
                                </select>
                                @error('topic')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700">How can we help?</label>
                                <textarea id="message" name="message" rows="4" required
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">{{ old('message') }}</textarea>
                                @error('message')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-start space-x-2 text-xs text-gray-500">
                                <input id="consent" name="consent" type="checkbox"
                                       class="mt-1 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500"
                                       {{ old('consent') ? 'checked' : '' }}>
                                <label for="consent">
                                    I agree to receive communications. You can unsubscribe at any time.
                                </label>
                            </div>

                            <button type="submit"
                                    class="w-full inline-flex items-center justify-center px-4 py-2 rounded-md text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700">
                                Submit
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="mt-12 text-center text-sm text-gray-500">
                Prefer email? Reach us directly at <span class="text-indigo-600">sales@example.com</span>.
            </div>
        </div>
    </section>
@endsection

