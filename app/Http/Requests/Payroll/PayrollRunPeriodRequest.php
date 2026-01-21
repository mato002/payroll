<?php

namespace App\Http\Requests\Payroll;

use Illuminate\Foundation\Http\FormRequest;

class PayrollRunPeriodRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'step'              => ['required', 'integer'],
            'period_start_date' => ['required_if:step,1', 'date'],
            'period_end_date'   => ['required_if:step,1', 'date', 'after_or_equal:period_start_date'],
            'pay_date'          => ['required_if:step,1', 'date', 'after_or_equal:period_end_date'],
            'name'              => ['nullable', 'string', 'max:150'],
            'description'       => ['nullable', 'string', 'max:500'],
        ];
    }
}

