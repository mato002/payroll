<?php

namespace App\Services\Reporting;

use App\Models\Company;
use App\Models\PayrollItemDetail;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TaxSummaryReport extends BaseReport
{
    /**
     * Build tax summary report data.
     */
    public function toCollection(): Collection
    {
        $query = PayrollItemDetail::query()
            ->where('company_id', $this->company->id)
            ->where('component_type', 'deduction')
            ->where(function ($q) {
                // Match common tax component codes/names
                $q->whereIn('component_code', ['TAX', 'INCOME_TAX', 'PAYE', 'WITHHOLDING_TAX'])
                    ->orWhere('component_name', 'like', '%tax%')
                    ->orWhere('component_name', 'like', '%PAYE%')
                    ->orWhere('component_name', 'like', '%withholding%');
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

        // Group by employee and aggregate
        $grouped = $details->groupBy('payrollItem.employee_id');

        $reportData = $grouped->map(function ($employeeDetails, $employeeId) {
            $employee = $employeeDetails->first()->payrollItem->employee;
            $totalTax = $employeeDetails->sum('calculated_amount');
            $totalGross = $employeeDetails->sum(function ($detail) {
                return $detail->payrollItem->gross_amount ?? 0;
            });
            $periods = $employeeDetails->map(function ($detail) {
                return $detail->payrollItem->payrollRun->period_start_date->format('M Y');
            })->unique()->values();

            return [
                'employee_id' => $employee->id,
                'employee_code' => $employee->employee_code,
                'employee_name' => trim($employee->first_name . ' ' . $employee->last_name),
                'tax_number' => $employee->tax_number ?? 'N/A',
                'total_gross' => $totalGross,
                'total_tax' => $totalTax,
                'periods' => $periods->implode(', '),
                'period_count' => $periods->count(),
            ];
        })->values();

        // Add summary totals
        $summary = [
            'total_employees' => $reportData->count(),
            'total_gross' => $reportData->sum('total_gross'),
            'total_tax' => $reportData->sum('total_tax'),
        ];

        return collect([
            'summary' => $summary,
            'employees' => $reportData,
        ]);
    }

    public function getTitle(): string
    {
        return 'Tax Summary Report';
    }
}
