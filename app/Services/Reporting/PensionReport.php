<?php

namespace App\Services\Reporting;

use App\Models\Company;
use App\Models\PayrollItemDetail;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class PensionReport extends BaseReport
{
    /**
     * Build pension/NSSF contribution report data.
     */
    public function toCollection(): Collection
    {
        $query = PayrollItemDetail::query()
            ->where('company_id', $this->company->id)
            ->where('component_type', 'contribution')
            ->where(function ($q) {
                // Match common pension/NSSF component codes/names
                $q->whereIn('component_code', ['PENSION', 'NSSF', 'SSNIT', 'PENSION_EMPLOYEE', 'PENSION_EMPLOYER', 'NSSF_EMPLOYEE', 'NSSF_EMPLOYER'])
                    ->orWhere('component_name', 'like', '%pension%')
                    ->orWhere('component_name', 'like', '%NSSF%')
                    ->orWhere('component_name', 'like', '%SSNIT%')
                    ->orWhere('component_name', 'like', '%social security%');
            })
            ->with(['payrollItem.employee', 'payrollItem.payrollRun']);

        // Filter by period if provided
        if ($this->periodStart && $this->periodEnd) {
            $query->whereHas('payrollItem.payrollRun', function ($q) {
                $q->whereBetween('period_start_date', [$this->periodStart, $this->periodEnd])
                    ->orWhereBetween('period_end_date', [$this->periodStart, $this->periodEnd]);
            });
        }

        $details = $query->get();

        // Separate employee and employer contributions
        $employeeContributions = $details->filter(function ($detail) {
            $name = strtolower($detail->component_name ?? '');
            $code = strtoupper($detail->component_code ?? '');
            return str_contains($name, 'employee') || 
                   str_contains($code, 'EMPLOYEE') ||
                   (!str_contains($name, 'employer') && !str_contains($code, 'EMPLOYER'));
        });

        $employerContributions = $details->filter(function ($detail) {
            $name = strtolower($detail->component_name ?? '');
            $code = strtoupper($detail->component_code ?? '');
            return str_contains($name, 'employer') || str_contains($code, 'EMPLOYER');
        });

        // Group by employee
        $employeeGrouped = $employeeContributions->groupBy('payrollItem.employee_id');
        $employerGrouped = $employerContributions->groupBy('payrollItem.employee_id');

        $allEmployeeIds = $employeeGrouped->keys()->merge($employerGrouped->keys())->unique();

        $reportData = $allEmployeeIds->map(function ($employeeId) use ($employeeGrouped, $employerGrouped) {
            $employeeDetails = $employeeGrouped->get($employeeId) ?? collect();
            $employerDetails = $employerGrouped->get($employeeId) ?? collect();

            $employee = $employeeDetails->first()?->payrollItem->employee 
                     ?? $employerDetails->first()?->payrollItem->employee;

            if (!$employee) {
                return null;
            }

            $employeeContribution = $employeeDetails->sum('calculated_amount');
            $employerContribution = $employerDetails->sum('calculated_amount');
            $totalContribution = $employeeContribution + $employerContribution;

            $periods = $employeeDetails->merge($employerDetails)
                ->map(function ($detail) {
                    return $detail->payrollItem->payrollRun->period_start_date->format('M Y');
                })
                ->unique()
                ->values();

            return [
                'employee_id' => $employee->id,
                'employee_code' => $employee->employee_code,
                'employee_name' => trim($employee->first_name . ' ' . $employee->last_name),
                'social_security_number' => $employee->social_security_number ?? 'N/A',
                'employee_contribution' => $employeeContribution,
                'employer_contribution' => $employerContribution,
                'total_contribution' => $totalContribution,
                'periods' => $periods->implode(', '),
                'period_count' => $periods->count(),
            ];
        })->filter()->values();

        // Add summary totals
        $summary = [
            'total_employees' => $reportData->count(),
            'total_employee_contribution' => $reportData->sum('employee_contribution'),
            'total_employer_contribution' => $reportData->sum('employer_contribution'),
            'total_contribution' => $reportData->sum('total_contribution'),
        ];

        return collect([
            'summary' => $summary,
            'employees' => $reportData,
        ]);
    }

    public function getTitle(): string
    {
        return 'Pension / NSSF Contribution Report';
    }
}
