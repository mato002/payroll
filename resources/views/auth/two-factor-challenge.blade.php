@extends('layouts.marketing')

@section('title', 'Two-factor authentication – ' . config('app.name'))

@section('content')
    <section class="bg-gray-50">
        <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-20">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 text-center">Two-factor verification</h1>
            <p class="mt-2 text-sm text-gray-600 text-center">
                Enter the 6-digit code from your authenticator app to complete sign in.
            </p>

            <div class="mt-8 bg-white shadow-sm border rounded-xl p-6 sm:p-8">
                @if ($errors->any())
                    <div class="mb-4 rounded-md bg-red-50 p-3 text-sm text-red-700" role="alert">
                        <p class="font-medium">The code you entered was invalid.</p>
                    </div>
                @endif

                <form method="POST" action="{{ url('/two-factor-challenge') }}" class="space-y-4" x-data="twoFactorForm()" novalidate>
                    @csrf

                    <div>
                        <label for="code-1" class="block text-sm font-medium text-gray-700">Authentication code</label>
                        <div class="mt-2 flex justify-between gap-2" aria-label="Enter 6 digit authentication code">
                            <template x-for="(digit, index) in digits" :key="index">
                                <input
                                    :id="'code-' + (index + 1)"
                                    x-model="digits[index]"
                                    x-ref="'code' + index"
                                    type="text"
                                    inputmode="numeric"
                                    pattern="[0-9]*"
                                    maxlength="1"
                                    class="w-10 h-12 text-center rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-lg tracking-widest"
                                    @input="onInput(index, $event)"
                                    @keydown.backspace.prevent="onBackspace(index, $event)"
                                >
                            </template>
                        </div>
                        <input type="hidden" name="code" x-model="code">
                        <p class="mt-2 text-xs text-gray-500">We accept codes from your authenticator app or SMS.</p>
                    </div>

                    <div class="flex items-center justify-between text-xs text-gray-600">
                        <button
                            type="button"
                            class="text-indigo-600 hover:text-indigo-500"
                            @click="useRecovery = !useRecovery"
                            x-text="useRecovery ? 'Use authentication code instead' : 'Use a recovery code instead'">
                        </button>
                    </div>

                    <div x-show="useRecovery" class="pt-2">
                        <label for="recovery_code" class="block text-sm font-medium text-gray-700">Recovery code</label>
                        <input
                            id="recovery_code"
                            type="text"
                            name="recovery_code"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                            placeholder="example-recovery-code"
                        >
                        <p class="mt-1 text-xs text-gray-500">
                            Use this only if you don’t have access to your authenticator app.
                        </p>
                    </div>

                    <button
                        type="submit"
                        class="w-full mt-4 inline-flex items-center justify-center px-4 py-2.5 rounded-md text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Verify and continue
                    </button>
                </form>
            </div>
        </div>
    </section>

    <script>
        function twoFactorForm() {
            return {
                digits: ['', '', '', '', '', ''],
                useRecovery: false,
                get code() {
                    return this.digits.join('');
                },
                onInput(index, event) {
                    const value = event.target.value.replace(/[^0-9]/g, '');
                    this.digits[index] = value.slice(-1);
                    if (value && index < this.digits.length - 1) {
                        this.$refs['code' + (index + 1)].focus();
                    }
                },
                onBackspace(index, event) {
                    if (this.digits[index]) {
                        this.digits[index] = '';
                    } else if (index > 0) {
                        this.$refs['code' + (index - 1)].focus();
                        this.digits[index - 1] = '';
                    }
                }
            };
        }
    </script>
@endsection

