<?php

namespace App\Http\Requests\Reports;

use Illuminate\Foundation\Http\FormRequest;

class GenerateAnnualReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && in_array($this->user()->role, ['super_admin', 'company_admin', 'payroll_officer'], true);
    }

    public function rules(): array
    {
        $currentYear = now()->year;
        
        return [
            'year' => ['required', 'integer', 'min:2000', 'max:' . ($currentYear + 1)],
            'format' => ['nullable', 'in:pdf,excel'],
        ];
    }
}
