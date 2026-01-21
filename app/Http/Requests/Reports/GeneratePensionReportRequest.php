<?php

namespace App\Http\Requests\Reports;

use Illuminate\Foundation\Http\FormRequest;

class GeneratePensionReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && in_array($this->user()->role, ['super_admin', 'company_admin', 'payroll_officer'], true);
    }

    public function rules(): array
    {
        return [
            'period_start' => ['nullable', 'date'],
            'period_end' => ['nullable', 'date', 'after_or_equal:period_start'],
            'format' => ['nullable', 'in:pdf,excel'],
        ];
    }
}
