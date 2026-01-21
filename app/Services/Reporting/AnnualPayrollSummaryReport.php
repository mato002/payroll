<?php

namespace App\Services\Reporting;

use App\Models\Company;
use App\Models\Payslip;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class AnnualPayrollSummaryReport extends BaseReport
{
    protected int $year;

    public function __construct(Company $company, int $year)
    {
        parent::__construct($company);
        $this->year = $year;
        $this->periodStart = Carbon::create($year, 1, 1)->startOfYear();
        $this->periodEnd = Carbon::create($year, 12, 31)->endOfYear();
    }

    /**
     * Build annual payroll summary report data.
     */
    public function toCollection(): Collection
    {
        $payslips = Payslip::query()
            ->where('company_id', $this->company->id)
            ->whereYear('issue_date', $this->year)
            ->with(['employee', 'payrollItem.details'])
            ->get();

        // Group by employee
        $grouped = $payslips->groupBy('employee_id');

        $reportData = $grouped->map(function ($employeePayslips, $employeeId) {
            $employee = $employeePayslips->first()->employee;

            // Aggregate totals for the year
            $totalGross = $employeePayslips->sum('gross_amount');
            $totalEarnings = $employeePayslips->sum('total_earnings');
            $totalDeductions = $employeePayslips->sum('total_deductions');
            $totalNet = $employeePayslips->sum('net_amount');

            // Extract tax and pension from payroll item details
            $allDetails = $employeePayslips->flatMap(function ($payslip) {
                return $payslip->payrollItem->details ?? collect();
            });

            $totalTax = $allDetails
                ->where('component_type', 'deduction')
                ->filter(function ($detail) {
                    $name = strtolower($detail->component_name ?? '');
                    $code = strtoupper($detail->component_code ?? '');
                    return str_contains($name, 'tax') || 
                           str_contains($name, 'paye') ||
                           in_array($code, ['TAX', 'INCOME_TAX', 'PAYE', 'WITHHOLDING_TAX']);
                })
                ->sum('calculated_amount');

            $totalPension = $allDetails
                ->where('component_type', 'contribution')
                ->filter(function ($detail) {
                    $name = strtolower($detail->component_name ?? '');
                    $code = strtoupper($detail->component_code ?? '');
                    return str_contains($name, 'pension') || 
                           str_contains($name, 'nssf') ||
                           in_array($code, ['PENSION', 'NSSF', 'SSNIT']);
                })
                ->sum('calculated_amount');

            $otherDeductions = $totalDeductions - $totalTax - $totalPension;

            return [
                'employee_id' => $employee->id,
                'employee_code' => $employee->employee_code,
                'employee_name' => trim($employee->first_name . ' ' . $employee->last_name),
                'tax_number' => $employee->tax_number ?? 'N/A',
                'social_security_number' => $employee->social_security_number ?? 'N/A',
                'total_gross' => $totalGross,
                'total_earnings' => $totalEarnings,
                'total_tax' => $totalTax,
                'total_pension' => $totalPension,
                'other_deductions' => $otherDeductions,
                'total_deductions' => $totalDeductions,
                'total_net' => $totalNet,
                'payslip_count' => $employeePayslips->count(),
            ];
        })->values();

        // Add company-wide summary
        $summary = [
            'year' => $this->year,
            'total_employees' => $reportData->count(),
            'total_gross' => $reportData->sum('total_gross'),
            'total_earnings' => $reportData->sum('total_earnings'),
            'total_tax' => $reportData->sum('total_tax'),
            'total_pension' => $reportData->sum('total_pension'),
            'total_other_deductions' => $reportData->sum('other_deductions'),
            'total_deductions' => $reportData->sum('total_deductions'),
            'total_net' => $reportData->sum('total_net'),
            'total_payslips' => $payslips->count(),
        ];

        return collect([
            'summary' => $summary,
            'employees' => $reportData,
        ]);
    }

    public function getTitle(): string
    {
        return sprintf('Annual Payroll Summary Report - %d', $this->year);
    }

    public function getDescription(): string
    {
        return sprintf('%s for %s (Year %d)', $this->getTitle(), $this->company->name, $this->year);
    }
}
