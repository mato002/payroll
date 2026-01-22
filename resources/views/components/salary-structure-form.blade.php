@props(['structure' => null, 'currency' => 'USD'])

<div x-data="salaryStructureCalculator()" class="space-y-6">
    {{-- Base Salary Section --}}
    <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-950">
        <div class="mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Base Salary</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">The base salary amount before allowances and deductions</p>
        </div>
        
        <div class="flex items-center gap-3">
            <div class="flex-1">
                <label for="base_salary" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Base Salary
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400">{{ $currency }}</span>
                    <input
                        type="number"
                        id="base_salary"
                        name="base_salary"
                        x-model.number="baseSalary"
                        @input="calculateNetSalary()"
                        step="0.01"
                        min="0"
                        class="w-full rounded-md border-gray-300 pl-12 pr-4 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
                        placeholder="0.00"
                        required
                    >
                </div>
            </div>
        </div>
    </div>

    {{-- Allowances Section --}}
    <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-950">
        <div class="mb-4 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Allowances</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">Additional earnings and benefits</p>
            </div>
            <button
                type="button"
                @click="addAllowance()"
                class="inline-flex items-center gap-2 rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
            >
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Add Allowance
            </button>
        </div>

        <div class="space-y-4" x-show="allowances.length > 0">
            <template x-for="(allowance, index) in allowances" :key="index">
                <div class="rounded-md border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-900">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-12">
                        {{-- Name --}}
                        <div class="md:col-span-4">
                            <label :for="`allowance_name_${index}`" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Name
                            </label>
                            <input
                                type="text"
                                :id="`allowance_name_${index}`"
                                :name="`allowances[${index}][name]`"
                                x-model="allowance.name"
                                class="w-full rounded-md border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"
                                placeholder="e.g., Housing Allowance"
                                required
                            >
                        </div>

                        {{-- Calculation Type --}}
                        <div class="md:col-span-3">
                            <label :for="`allowance_calc_${index}`" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Type
                            </label>
                            <select
                                :id="`allowance_calc_${index}`"
                                :name="`allowances[${index}][calculation_type]`"
                                x-model="allowance.calculation_type"
                                @change="calculateNetSalary()"
                                class="w-full rounded-md border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"
                            >
                                <option value="fixed">Fixed Amount</option>
                                <option value="percentage_of_basic">% of Basic</option>
                            </select>
                        </div>

                        {{-- Amount/Percentage --}}
                        <div class="md:col-span-3">
                            <label :for="`allowance_amount_${index}`" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                <span x-text="allowance.calculation_type === 'fixed' ? 'Amount' : 'Percentage'"></span>
                            </label>
                            <div class="relative">
                                <span x-show="allowance.calculation_type === 'fixed'" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400">{{ $currency }}</span>
                                <span x-show="allowance.calculation_type !== 'fixed'" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400">%</span>
                                <input
                                    type="number"
                                    :id="`allowance_amount_${index}`"
                                    :name="`allowances[${index}][${allowance.calculation_type === 'fixed' ? 'amount' : 'percentage'}]`"
                                    x-model.number="allowance[allowance.calculation_type === 'fixed' ? 'amount' : 'percentage']"
                                    @input="calculateNetSalary()"
                                    step="0.01"
                                    min="0"
                                    :class="allowance.calculation_type === 'fixed' ? 'pl-12 pr-4' : 'px-4 pr-12'"
                                    class="w-full rounded-md border-gray-300 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"
                                    placeholder="0.00"
                                    required
                                >
                            </div>
                        </div>

                        {{-- Taxable Toggle --}}
                        <div class="md:col-span-1 flex items-end">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input
                                    type="checkbox"
                                    :name="`allowances[${index}][taxable]`"
                                    x-model="allowance.taxable"
                                    @change="calculateNetSalary()"
                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-800"
                                >
                                <span class="text-xs text-gray-600 dark:text-gray-400">Taxable</span>
                            </label>
                        </div>

                        {{-- Remove Button --}}
                        <div class="md:col-span-1 flex items-end">
                            <button
                                type="button"
                                @click="removeAllowance(index)"
                                class="inline-flex items-center justify-center rounded-md p-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20"
                            >
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Calculated Value Display --}}
                    <div class="mt-3 text-sm text-gray-600 dark:text-gray-400">
                        <span class="font-medium">Calculated:</span>
                        <span class="ml-2 font-semibold text-indigo-600 dark:text-indigo-400">
                            {{ $currency }} <span x-text="formatCurrency(calculateAllowanceValue(allowance))"></span>
                        </span>
                    </div>
                </div>
            </template>
        </div>

        <div x-show="allowances.length === 0" class="text-center py-8 text-sm text-gray-500 dark:text-gray-400">
            No allowances added yet. Click "Add Allowance" to get started.
        </div>
    </div>

    {{-- Deductions Section --}}
    <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-950">
        <div class="mb-4 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Deductions</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">Taxes, contributions, and other deductions</p>
            </div>
            <button
                type="button"
                @click="addDeduction()"
                class="inline-flex items-center gap-2 rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
            >
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Add Deduction
            </button>
        </div>

        <div class="space-y-4" x-show="deductions.length > 0">
            <template x-for="(deduction, index) in deductions" :key="index">
                <div class="rounded-md border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-900">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-12">
                        {{-- Name --}}
                        <div class="md:col-span-4">
                            <label :for="`deduction_name_${index}`" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Name
                            </label>
                            <input
                                type="text"
                                :id="`deduction_name_${index}`"
                                :name="`deductions[${index}][name]`"
                                x-model="deduction.name"
                                class="w-full rounded-md border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"
                                placeholder="e.g., Tax, Pension"
                                required
                            >
                        </div>

                        {{-- Calculation Type --}}
                        <div class="md:col-span-3">
                            <label :for="`deduction_calc_${index}`" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Type
                            </label>
                            <select
                                :id="`deduction_calc_${index}`"
                                :name="`deductions[${index}][calculation_type]`"
                                x-model="deduction.calculation_type"
                                @change="calculateNetSalary()"
                                class="w-full rounded-md border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"
                            >
                                <option value="fixed">Fixed Amount</option>
                                <option value="percentage_of_basic">% of Basic</option>
                                <option value="percentage_of_gross">% of Gross</option>
                            </select>
                        </div>

                        {{-- Amount/Percentage --}}
                        <div class="md:col-span-3">
                            <label :for="`deduction_amount_${index}`" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                <span x-text="deduction.calculation_type === 'fixed' ? 'Amount' : 'Percentage'"></span>
                            </label>
                            <div class="relative">
                                <span x-show="deduction.calculation_type === 'fixed'" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400">{{ $currency }}</span>
                                <span x-show="deduction.calculation_type !== 'fixed'" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400">%</span>
                                <input
                                    type="number"
                                    :id="`deduction_amount_${index}`"
                                    :name="`deductions[${index}][${deduction.calculation_type === 'fixed' ? 'amount' : 'percentage'}]`"
                                    x-model.number="deduction[deduction.calculation_type === 'fixed' ? 'amount' : 'percentage']"
                                    @input="calculateNetSalary()"
                                    step="0.01"
                                    min="0"
                                    :class="deduction.calculation_type === 'fixed' ? 'pl-12 pr-4' : 'px-4 pr-12'"
                                    class="w-full rounded-md border-gray-300 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"
                                    placeholder="0.00"
                                    required
                                >
                            </div>
                        </div>

                        {{-- Included in Gross Toggle --}}
                        <div class="md:col-span-1 flex items-end">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input
                                    type="checkbox"
                                    :name="`deductions[${index}][included_in_gross]`"
                                    x-model="deduction.included_in_gross"
                                    @change="calculateNetSalary()"
                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-800"
                                >
                                <span class="text-xs text-gray-600 dark:text-gray-400">In Gross</span>
                            </label>
                        </div>

                        {{-- Remove Button --}}
                        <div class="md:col-span-1 flex items-end">
                            <button
                                type="button"
                                @click="removeDeduction(index)"
                                class="inline-flex items-center justify-center rounded-md p-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20"
                            >
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Calculated Value Display --}}
                    <div class="mt-3 text-sm text-gray-600 dark:text-gray-400">
                        <span class="font-medium">Calculated:</span>
                        <span class="ml-2 font-semibold text-red-600 dark:text-red-400">
                            {{ $currency }} <span x-text="formatCurrency(calculateDeductionValue(deduction))"></span>
                        </span>
                    </div>
                </div>
            </template>
        </div>

        <div x-show="deductions.length === 0" class="text-center py-8 text-sm text-gray-500 dark:text-gray-400">
            No deductions added yet. Click "Add Deduction" to get started.
        </div>
    </div>

    {{-- Net Salary Preview --}}
    <div class="sticky bottom-0 rounded-lg border-2 border-indigo-500 bg-gradient-to-r from-indigo-50 to-blue-50 p-6 shadow-lg dark:from-indigo-900/20 dark:to-blue-900/20 dark:border-indigo-400">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Base Salary</p>
                <p class="mt-1 text-2xl font-bold text-gray-900 dark:text-gray-100">
                    {{ $currency }} <span x-text="formatCurrency(baseSalary)"></span>
                </p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Allowances</p>
                <p class="mt-1 text-2xl font-bold text-emerald-600 dark:text-emerald-400">
                    {{ $currency }} <span x-text="formatCurrency(totalAllowances)"></span>
                </p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Deductions</p>
                <p class="mt-1 text-2xl font-bold text-red-600 dark:text-red-400">
                    {{ $currency }} <span x-text="formatCurrency(totalDeductions)"></span>
                </p>
            </div>
            <div class="border-l-2 border-indigo-300 pl-4 dark:border-indigo-600">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Net Salary</p>
                <p class="mt-1 text-3xl font-bold text-indigo-600 dark:text-indigo-400">
                    {{ $currency }} <span x-text="formatCurrency(netSalary)"></span>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
function salaryStructureCalculator() {
    return {
        baseSalary: {{ ($structure && $structure->components) ? ($structure->components->where('type', 'earning')->where('code', 'basic_salary')->first()?->amount ?? 0) : 0 }},
        allowances: @json($structure && $structure->components ? $structure->components->where('type', 'earning')->where('code', '!=', 'basic_salary')->map(function($c) {
            return [
                'name' => $c->name,
                'code' => $c->code,
                'calculation_type' => $c->calculation_type,
                'amount' => (float)($c->amount ?? 0),
                'percentage' => (float)($c->percentage ?? 0),
                'taxable' => (bool)($c->taxable ?? true),
            ];
        })->values()->toArray() : []),
        deductions: @json($structure && $structure->components ? $structure->components->where('type', 'deduction')->map(function($c) {
            return [
                'name' => $c->name,
                'code' => $c->code,
                'calculation_type' => $c->calculation_type,
                'amount' => (float)($c->amount ?? 0),
                'percentage' => (float)($c->percentage ?? 0),
                'included_in_gross' => (bool)($c->included_in_gross ?? true),
            ];
        })->values()->toArray() : []),
        
        get totalAllowances() {
            return this.allowances.reduce((sum, allowance) => {
                return sum + this.calculateAllowanceValue(allowance);
            }, 0);
        },
        
        get totalDeductions() {
            return this.deductions.reduce((sum, deduction) => {
                return sum + this.calculateDeductionValue(deduction);
            }, 0);
        },
        
        get grossSalary() {
            return this.baseSalary + this.totalAllowances;
        },
        
        get netSalary() {
            return this.grossSalary - this.totalDeductions;
        },
        
        calculateAllowanceValue(allowance) {
            if (!allowance.amount && !allowance.percentage) return 0;
            
            if (allowance.calculation_type === 'fixed') {
                return allowance.amount || 0;
            } else if (allowance.calculation_type === 'percentage_of_basic') {
                return (this.baseSalary * (allowance.percentage || 0)) / 100;
            }
            return 0;
        },
        
        calculateDeductionValue(deduction) {
            if (!deduction.amount && !deduction.percentage) return 0;
            
            if (deduction.calculation_type === 'fixed') {
                return deduction.amount || 0;
            } else if (deduction.calculation_type === 'percentage_of_basic') {
                return (this.baseSalary * (deduction.percentage || 0)) / 100;
            } else if (deduction.calculation_type === 'percentage_of_gross') {
                return (this.grossSalary * (deduction.percentage || 0)) / 100;
            }
            return 0;
        },
        
        calculateNetSalary() {
            // Trigger reactivity by accessing computed properties
            this.totalAllowances;
            this.totalDeductions;
            this.netSalary;
        },
        
        addAllowance() {
            this.allowances.push({
                name: '',
                code: '',
                calculation_type: 'fixed',
                amount: 0,
                percentage: 0,
                taxable: true,
            });
        },
        
        removeAllowance(index) {
            this.allowances.splice(index, 1);
            this.calculateNetSalary();
        },
        
        addDeduction() {
            this.deductions.push({
                name: '',
                code: '',
                calculation_type: 'fixed',
                amount: 0,
                percentage: 0,
                included_in_gross: true,
            });
        },
        
        removeDeduction(index) {
            this.deductions.splice(index, 1);
            this.calculateNetSalary();
        },
        
        formatCurrency(value) {
            return new Intl.NumberFormat('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(value || 0);
        }
    }
}
</script>
