<?php

namespace App\Services\Payroll;

use App\Exceptions\Payroll\InvalidTaxConfigurationException;
use App\Exceptions\Payroll\MissingSalaryDataException;
use App\Exceptions\Payroll\PayrollRunException;
use App\Models\AuditLog;
use App\Models\Company;
use App\Models\Employee;
use App\Models\PayrollRun;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PayrollRunService
{
    public function __construct(
        protected PayrollCalculator $calculator,
        protected PayslipService $payslipService
    ) {
    }

    /**
     * Create a new monthly payroll run and calculate all employees.
     */
    public function createAndCalculateMonthlyRun(
        Company $company,
        Carbon $periodStart,
        Carbon $periodEnd,
        Carbon $payDate,
        ?string $name = null,
        ?string $description = null
    ): PayrollRun {
        $run = null;

        try {
            return DB::transaction(function () use (&$run, $company, $periodStart, $periodEnd, $payDate, $name, $description) {
                $run = PayrollRun::create([
                    'company_id'        => $company->id,
                    'name'              => $name ?? sprintf('Monthly payroll %s', $periodEnd->format('F Y')),
                    'period_start_date' => $periodStart,
                    'period_end_date'   => $periodEnd,
                    'pay_date'          => $payDate,
                    'status'            => 'processing',
                    'pay_frequency'     => 'monthly',
                    'description'       => $description,
                    'created_by'        => Auth::id(),
                ]);

                $totalGross = 0.0;
                $totalNet   = 0.0;

                /** @var \Illuminate\Support\Collection<int,Employee> $employees */
                $employees = Employee::query()
                    ->where('company_id', $company->id)
                    ->where('employment_status', 'active')
                    ->where('is_active', true)
                    ->get();

                foreach ($employees as $employee) {
                    $item = $this->calculator->calculateForEmployee($run, $employee);
                    $totalGross += (float) $item->gross_amount;
                    $totalNet   += (float) $item->net_amount;
                }

                $run->update([
                    'total_gross_amount' => $totalGross,
                    'total_net_amount'   => $totalNet,
                    'status'             => 'completed',
                ]);

                return $run->fresh('items.details');
            });
        } catch (MissingSalaryDataException|InvalidTaxConfigurationException $e) {
            Log::channel('payroll')->warning('Payroll run failed due to configuration issue', [
                'run_id'     => $run?->id,
                'company_id' => $company->id,
                'error'      => $e->getMessage(),
            ]);

            throw new PayrollRunException('Payroll run failed due to configuration errors.');
        } catch (\Throwable $e) {
            Log::channel('payroll')->error('Unexpected error during payroll run', [
                'run_id'     => $run?->id,
                'company_id' => $company->id,
                'exception'  => $e,
            ]);

            throw new PayrollRunException('Unexpected payroll processing error.');
        }
    }

    /**
     * Lock a payroll run after approval. Once locked, it cannot be recalculated.
     */
    public function approveAndLock(PayrollRun $run): PayrollRun
    {
        if (in_array($run->status, ['closed', 'canceled'], true)) {
            throw new \RuntimeException('Cannot approve a closed or canceled payroll run.');
        }

        return DB::transaction(function () use ($run) {
            $run->update([
                'status'      => 'closed',
                'approved_by' => Auth::id(),
                'approved_at' => now(),
            ]);

            // Lock individual payroll items as well
            $run->items()->update(['status' => 'locked']);

            // Log the approval for audit trail
            AuditLog::create([
                'company_id'  => $run->company_id,
                'user_id'     => Auth::id(),
                'event_type'  => 'payroll_approved',
                'description' => sprintf('Payroll run "%s" (ID: %s) approved and locked', $run->name, $run->id),
                'ip_address'  => request()?->ip(),
                'user_agent'  => request()?->userAgent(),
                'entity_type' => PayrollRun::class,
                'entity_id'   => $run->id,
                'new_values'  => json_encode([
                    'status'      => 'closed',
                    'approved_by' => Auth::id(),
                    'approved_at' => now()->toDateTimeString(),
                ]),
            ]);

            // Generate payslips and email them after approval
            $this->payslipService->generateForRun($run);
            $this->payslipService->emailForRun($run);

            return $run->fresh('items');
        });
    }

    /**
     * Guard to prevent modifications when run is locked.
     */
    public function ensureNotLocked(PayrollRun $run): void
    {
        if ($run->status === 'closed') {
            throw new \RuntimeException('This payroll run is locked and cannot be modified.');
        }
    }
}

