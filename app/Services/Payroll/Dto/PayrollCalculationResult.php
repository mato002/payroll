<?php

namespace App\Services\Payroll\Dto;

class PayrollCalculationResult
{
    public float $baseSalary;
    public float $totalAllowances;
    public float $totalDeductions;
    public float $taxableIncome;
    public float $taxAmount;
    public float $netSalary;

    public function __construct(
        float $baseSalary,
        float $totalAllowances,
        float $totalDeductions,
        float $taxableIncome,
        float $taxAmount,
        float $netSalary
    ) {
        $this->baseSalary      = $baseSalary;
        $this->totalAllowances = $totalAllowances;
        $this->totalDeductions = $totalDeductions;
        $this->taxableIncome   = $taxableIncome;
        $this->taxAmount       = $taxAmount;
        $this->netSalary       = $netSalary;
    }
}

