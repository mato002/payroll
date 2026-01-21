<?php

namespace App\Services\Employee;

use App\Models\Employee;
use App\Models\EmployeeLifecycleEvent;
use App\Models\PayrollRun;
use App\Models\TerminationSettlement;
use App\Services\Payroll\PayrollCalculator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TerminationService
{
    public function __construct(
        protected PayrollCalculator $payrollCalculator,
        protected EmployeeLifecycleService $lifecycleService
    ) {
    }

    /**
     * Terminate an employee and create a termination settlement.
     */
    public function terminateEmployee(
        Employee $employee,
        Carbon $terminationDate,
        string $terminationType,
        ?string $terminationReason = null,
        ?string $terminationNotes = null,
        ?Carbon $finalPeriodStart = null,
        ?Carbon $finalPeriodEnd = null,
        ?Carbon $settlementPayDate = null,
        array $settlementOptions = []
    ): TerminationSettlement {
        return DB::transaction(function () use (
            $employee,
            $terminationDate,
            $terminationType,
            $terminationReason,
            $terminationNotes,
            $finalPeriodStart,
            $finalPeriodEnd,
            $settlementPayDate,
            $settlementOptions
        ) {
            // Validate employee is not already terminated
            if ($employee->employment_status === 'terminated') {
                throw new \RuntimeException('Employee is already terminated.');
            }

            // Set default dates if not provided
            $finalPeriodStart = $finalPeriodStart ?? $this->calculateFinalPeriodStart($employee, $terminationDate);
            $finalPeriodEnd = $finalPeriodEnd ?? $terminationDate;
            $settlementPayDate = $settlementPayDate ?? $terminationDate->copy()->addDays(7);

            // Create termination settlement
            $settlement = TerminationSettlement::create([
                'company_id' => $employee->company_id,
                'employee_id' => $employee->id,
                'created_by' => Auth::id(),
                'termination_date' => $terminationDate,
                'termination_type' => $terminationType,
                'termination_reason' => $terminationReason,
                'termination_notes' => $terminationNotes,
                'settlement_status' => 'draft',
                'final_period_start' => $finalPeriodStart,
                'final_period_end' => $finalPeriodEnd,
                'settlement_pay_date' => $settlementPayDate,
                'currency' => $employee->company->currency ?? 'USD',
            ]);

            // Calculate settlement amounts
            $this->calculateSettlement($settlement, $employee, $settlementOptions);

            // Update employee status
            $employee->update([
                'employment_status' => 'terminated',
                'is_active' => false,
                'termination_date' => $terminationDate,
            ]);

            // Record lifecycle event
            $this->lifecycleService->recordTermination(
                $employee,
                $terminationDate,
                $terminationType,
                $terminationReason,
                $terminationNotes,
                $settlement->id
            );

            return $settlement->fresh();
        });
    }

    /**
     * Calculate termination settlement amounts.
     */
    public function calculateSettlement(
        TerminationSettlement $settlement,
        Employee $employee,
        array $options = []
    ): TerminationSettlement {
        return DB::transaction(function () use ($settlement, $employee, $options) {
            // Calculate accrued salary for final period
            $accruedSalary = $this->calculateAccruedSalary(
                $employee,
                $settlement->final_period_start,
                $settlement->final_period_end
            );

            // Get settlement options with defaults
            $unusedLeaveDays = $options['unused_leave_days'] ?? 0;
            $leavePayoutRate = $options['leave_payout_rate'] ?? 1.0; // Daily rate multiplier
            $unusedLeavePayout = $this->calculateUnusedLeavePayout($employee, $unusedLeaveDays, $leavePayoutRate);

            $severancePay = $options['severance_pay'] ?? 0.0;
            $noticePay = $options['notice_pay'] ?? 0.0;
            $bonusPayout = $options['bonus_payout'] ?? 0.0;
            $otherAllowances = $options['other_allowances'] ?? 0.0;

            // Deductions
            $outstandingLoans = $options['outstanding_loans'] ?? 0.0;
            $advanceDeductions = $options['advance_deductions'] ?? 0.0;
            $otherDeductions = $options['other_deductions'] ?? 0.0;

            // Calculate totals
            $totalEarnings = $accruedSalary
                + $unusedLeavePayout
                + $severancePay
                + $noticePay
                + $bonusPayout
                + $otherAllowances;

            $totalDeductions = $outstandingLoans
                + $advanceDeductions
                + $otherDeductions;

            $netSettlement = $totalEarnings - $totalDeductions;

            // Update settlement
            $settlement->update([
                'accrued_salary' => $accruedSalary,
                'unused_leave_payout' => $unusedLeavePayout,
                'severance_pay' => $severancePay,
                'notice_pay' => $noticePay,
                'bonus_payout' => $bonusPayout,
                'other_allowances' => $otherAllowances,
                'outstanding_loans' => $outstandingLoans,
                'advance_deductions' => $advanceDeductions,
                'other_deductions' => $otherDeductions,
                'total_earnings' => $totalEarnings,
                'total_deductions' => $totalDeductions,
                'net_settlement_amount' => $netSettlement,
                'settlement_status' => 'calculated',
            ]);

            return $settlement->fresh();
        });
    }

    /**
     * Approve a termination settlement.
     */
    public function approveSettlement(
        TerminationSettlement $settlement,
        ?string $approvalNotes = null
    ): TerminationSettlement {
        if ($settlement->settlement_status !== 'calculated') {
            throw new \RuntimeException('Settlement must be in calculated status to approve.');
        }

        return DB::transaction(function () use ($settlement, $approvalNotes) {
            $settlement->update([
                'settlement_status' => 'approved',
                'approved_by' => Auth::id(),
                'approved_at' => now(),
                'approval_notes' => $approvalNotes,
            ]);

            return $settlement->fresh();
        });
    }

    /**
     * Process final payroll for terminated employee and link to settlement.
     */
    public function processFinalPayroll(
        TerminationSettlement $settlement,
        ?PayrollRun $payrollRun = null
    ): TerminationSettlement {
        if ($settlement->settlement_status !== 'approved') {
            throw new \RuntimeException('Settlement must be approved before processing final payroll.');
        }

        return DB::transaction(function () use ($settlement, $payrollRun) {
            $employee = $settlement->employee;

            // If no payroll run provided, create an off-cycle run for final settlement
            if ($payrollRun === null) {
                $payrollRun = PayrollRun::create([
                    'company_id' => $employee->company_id,
                    'name' => sprintf('Final Payroll - %s %s', $employee->first_name, $employee->last_name),
                    'period_start_date' => $settlement->final_period_start,
                    'period_end_date' => $settlement->final_period_end,
                    'pay_date' => $settlement->settlement_pay_date,
                    'status' => 'completed',
                    'pay_frequency' => 'off_cycle',
                    'description' => sprintf('Final payroll settlement for terminated employee'),
                    'created_by' => Auth::id(),
                ]);

                // Calculate payroll for the employee
                $payrollItem = $this->payrollCalculator->calculateForEmployee($payrollRun, $employee);

                // Update payroll item with settlement amounts
                $payrollItem->update([
                    'gross_amount' => $settlement->total_earnings,
                    'total_earnings' => $settlement->total_earnings,
                    'total_deductions' => $settlement->total_deductions,
                    'net_amount' => $settlement->net_settlement_amount,
                ]);
            }

            // Link settlement to payroll run
            $settlement->update([
                'final_payroll_run_id' => $payrollRun->id,
            ]);

            return $settlement->fresh(['finalPayrollRun']);
        });
    }

    /**
     * Mark settlement as paid.
     */
    public function markSettlementAsPaid(
        TerminationSettlement $settlement,
        ?string $paymentReference = null,
        ?string $paymentNotes = null
    ): TerminationSettlement {
        if (!in_array($settlement->settlement_status, ['approved', 'paid'], true)) {
            throw new \RuntimeException('Settlement must be approved before marking as paid.');
        }

        return DB::transaction(function () use ($settlement, $paymentReference, $paymentNotes) {
            $settlement->update([
                'settlement_status' => 'paid',
                'paid_at' => now(),
                'payment_reference' => $paymentReference,
                'payment_notes' => $paymentNotes,
            ]);

            return $settlement->fresh();
        });
    }

    /**
     * Calculate accrued salary for final period.
     */
    protected function calculateAccruedSalary(
        Employee $employee,
        Carbon $periodStart,
        Carbon $periodEnd
    ): float {
        // Get employee's current salary structure
        $salaryChangeService = app(SalaryChangeService::class);
        $currentSalaryStructure = $salaryChangeService->getCurrentSalaryStructure($employee);

        if (!$currentSalaryStructure) {
            throw new \RuntimeException('Employee has no active salary structure.');
        }

        // Calculate days in period
        $totalDays = $periodStart->diffInDays($periodEnd) + 1;

        // Get monthly salary (assuming monthly pay frequency)
        $structure = $currentSalaryStructure->salaryStructure;
        if (!$structure) {
            throw new \RuntimeException('Employee salary structure has no associated structure.');
        }

        // Load components if not already loaded
        if (!$structure->relationLoaded('components')) {
            $structure->load('components');
        }

        $components = $structure->components ?? collect();
        $monthlyGross = 0;

        foreach ($components as $component) {
            if ($component->type === 'earning' && $component->included_in_gross) {
                $amount = (float) ($component->amount ?? 0);
                $monthlyGross += $amount;
            }
        }

        // Calculate prorated salary
        $daysInMonth = $periodStart->daysInMonth;
        $dailyRate = $monthlyGross / $daysInMonth;
        $accruedSalary = $dailyRate * $totalDays;

        return round($accruedSalary, 2);
    }

    /**
     * Calculate unused leave payout.
     */
    protected function calculateUnusedLeavePayout(
        Employee $employee,
        int $unusedLeaveDays,
        float $payoutRate = 1.0
    ): float {
        if ($unusedLeaveDays <= 0) {
            return 0.0;
        }

        // Get daily rate from current salary
        $salaryChangeService = app(SalaryChangeService::class);
        $currentSalaryStructure = $salaryChangeService->getCurrentSalaryStructure($employee);

        if (!$currentSalaryStructure) {
            return 0.0;
        }

        $structure = $currentSalaryStructure->salaryStructure;
        if (!$structure) {
            return 0.0;
        }

        // Load components if not already loaded
        if (!$structure->relationLoaded('components')) {
            $structure->load('components');
        }

        $components = $structure->components ?? collect();
        $monthlyGross = 0;

        foreach ($components as $component) {
            if ($component->type === 'earning' && $component->included_in_gross) {
                $amount = (float) ($component->amount ?? 0);
                $monthlyGross += $amount;
            }
        }

        $daysInMonth = now()->daysInMonth;
        $dailyRate = $monthlyGross / $daysInMonth;

        return round($dailyRate * $unusedLeaveDays * $payoutRate, 2);
    }

    /**
     * Calculate final period start date.
     */
    protected function calculateFinalPeriodStart(Employee $employee, Carbon $terminationDate): Carbon
    {
        // For monthly employees, start from beginning of month
        if ($employee->pay_frequency === 'monthly') {
            return $terminationDate->copy()->startOfMonth();
        }

        // For bi-weekly, calculate from last pay period
        if ($employee->pay_frequency === 'bi_weekly') {
            // Simple calculation: go back 14 days
            return $terminationDate->copy()->subDays(14);
        }

        // For weekly, go back 7 days
        if ($employee->pay_frequency === 'weekly') {
            return $terminationDate->copy()->subDays(7);
        }

        // Default: start of month
        return $terminationDate->copy()->startOfMonth();
    }
}
