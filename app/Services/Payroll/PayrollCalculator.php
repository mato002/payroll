<?php

namespace App\Services\Payroll;

use App\Exceptions\Payroll\MissingSalaryDataException;
use App\Models\Employee;
use App\Models\PayrollItem;
use App\Models\PayrollItemDetail;
use App\Models\PayrollRun;
use App\Models\SalaryStructure;
use App\Models\SalaryStructureComponent;
use App\Services\Payroll\Dto\PayrollCalculationResult;
use App\Services\Payroll\Tax\TaxCalculator;
use Illuminate\Support\Facades\DB;

class PayrollCalculator
{
    public function __construct(
        protected TaxCalculator $taxCalculator
    ) {
    }

    /**
     * Calculate payroll for a single employee in a given run and create
     * the corresponding PayrollItem + PayrollItemDetails records.
     */
    public function calculateForEmployee(PayrollRun $run, Employee $employee): PayrollItem
    {
        return DB::transaction(function () use ($run, $employee) {
            // Resolve salary structure and components (simplified)
            /** @var SalaryStructure|null $salaryStructure */
            $salaryStructure = SalaryStructure::query()
                ->where('company_id', $employee->company_id)
                ->where('pay_frequency', $employee->pay_frequency)
                ->whereNull('deleted_at')
                ->orderByDesc('is_default')
                ->first();

            if (! $salaryStructure) {
                throw new MissingSalaryDataException(
                    $employee->id,
                    'No salary structure found for employee.'
                );
            }

            /** @var \Illuminate\Support\Collection<int,SalaryStructureComponent> $components */
            $components = SalaryStructureComponent::query()
                ->where('company_id', $employee->company_id)
                ->where('salary_structure_id', $salaryStructure->id)
                ->orderBy('sort_order')
                ->get();

            if ($components->isEmpty()) {
                throw new MissingSalaryDataException(
                    $employee->id,
                    'No salary structure components configured.'
                );
            }

            // Very simplified assumption: "basic" earning is the base salary
            $baseComponent = $components->firstWhere('code', 'basic');
            $baseSalary    = (float) ($baseComponent?->amount ?? 0);

            if (! $baseComponent || $baseSalary <= 0) {
                throw new MissingSalaryDataException(
                    $employee->id,
                    'Missing or zero base salary component (code: basic).'
                );
            }

            $totalEarnings     = 0.0;
            $totalDeductions   = 0.0;
            $totalContributions = 0.0;
            $taxableIncome     = 0.0;

            $detailsPayload = [];

            foreach ($components as $component) {
                $amount = $this->calculateComponentAmount($component, $baseSalary);

                $detail = [
                    'company_id'       => $run->company_id,
                    'component_type'   => $component->type,
                    'component_code'   => $component->code,
                    'component_name'   => $component->name,
                    'base_amount'      => $baseSalary,
                    'calculated_amount'=> $amount,
                    'taxable'          => $component->taxable,
                    'sort_order'       => $component->sort_order,
                ];

                $detailsPayload[] = $detail;

                if ($component->type === 'earning') {
                    $totalEarnings += $amount;
                    if ($component->taxable) {
                        $taxableIncome += $amount;
                    }
                } elseif ($component->type === 'deduction') {
                    $totalDeductions += $amount;
                    // Deductions usually reduce taxable income in some systems;
                    // for simplicity, we ignore that here or you can add logic per country.
                } elseif ($component->type === 'contribution') {
                    $totalContributions += $amount;
                }
            }

            // Fallback if there is no explicit "basic" component
            if ($baseSalary === 0.0) {
                $baseSalary = $totalEarnings;
            }

            // Determine country for tax – use company country, fallback to DEFAULT
            $companyCountry = $employee->company->country ?? 'DEFAULT';

            $taxAmount = $this->taxCalculator->calculate($taxableIncome, $companyCountry);

            $netSalary = $totalEarnings - $totalDeductions - $taxAmount;

            $result = new PayrollCalculationResult(
                baseSalary: $baseSalary,
                totalAllowances: $totalEarnings - $baseSalary,
                totalDeductions: $totalDeductions + $taxAmount,
                taxableIncome: $taxableIncome,
                taxAmount: $taxAmount,
                netSalary: $netSalary
            );

            // Persist PayrollItem
            $payrollItem = PayrollItem::updateOrCreate(
                [
                    'company_id'    => $run->company_id,
                    'payroll_run_id'=> $run->id,
                    'employee_id'   => $employee->id,
                ],
                [
                    'salary_structure_id' => $salaryStructure->id,
                    'gross_amount'        => $result->baseSalary + $result->totalAllowances,
                    'total_earnings'      => $totalEarnings,
                    'total_deductions'    => $totalDeductions + $taxAmount,
                    'total_contributions' => $totalContributions,
                    'net_amount'          => $result->netSalary,
                    'currency'            => $salaryStructure->currency ?? $employee->company->currency,
                    'status'              => 'calculated',
                ]
            );

            // Refresh details
            $payrollItem->details()->delete();
            foreach ($detailsPayload as $detail) {
                $detail['payroll_item_id'] = $payrollItem->id;
                PayrollItemDetail::create($detail);
            }

            return $payrollItem->fresh('details');
        });
    }

    /**
     * Simple component amount calculator.
     */
    protected function calculateComponentAmount(SalaryStructureComponent $component, float $baseSalary): float
    {
        return match ($component->calculation_type) {
            'fixed' => (float) $component->amount,
            'percentage_of_basic' => $baseSalary * ((float) $component->percentage / 100),
            'percentage_of_gross' => $baseSalary * ((float) $component->percentage / 100), // can be adjusted
            default => (float) $component->amount,
        };
    }
}

