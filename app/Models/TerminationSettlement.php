<?php

namespace App\Models;

use App\Models\Traits\Auditable;
use App\Models\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TerminationSettlement extends Model
{
    use HasFactory;
    use BelongsToCompany;
    use Auditable;

    protected $fillable = [
        'company_id',
        'employee_id',
        'created_by',
        'approved_by',
        'termination_date',
        'termination_type',
        'termination_reason',
        'termination_notes',
        'settlement_status',
        'final_period_start',
        'final_period_end',
        'settlement_pay_date',
        'accrued_salary',
        'unused_leave_payout',
        'severance_pay',
        'notice_pay',
        'bonus_payout',
        'other_allowances',
        'outstanding_loans',
        'advance_deductions',
        'other_deductions',
        'total_earnings',
        'total_deductions',
        'net_settlement_amount',
        'currency',
        'final_payroll_run_id',
        'settlement_payslip_id',
        'approved_at',
        'approval_notes',
        'paid_at',
        'payment_reference',
        'payment_notes',
    ];

    protected $casts = [
        'termination_date' => 'date',
        'final_period_start' => 'date',
        'final_period_end' => 'date',
        'settlement_pay_date' => 'date',
        'accrued_salary' => 'decimal:2',
        'unused_leave_payout' => 'decimal:2',
        'severance_pay' => 'decimal:2',
        'notice_pay' => 'decimal:2',
        'bonus_payout' => 'decimal:2',
        'other_allowances' => 'decimal:2',
        'outstanding_loans' => 'decimal:2',
        'advance_deductions' => 'decimal:2',
        'other_deductions' => 'decimal:2',
        'total_earnings' => 'decimal:2',
        'total_deductions' => 'decimal:2',
        'net_settlement_amount' => 'decimal:2',
        'approved_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function finalPayrollRun(): BelongsTo
    {
        return $this->belongsTo(PayrollRun::class, 'final_payroll_run_id');
    }

    public function settlementPayslip(): BelongsTo
    {
        return $this->belongsTo(Payslip::class, 'settlement_payslip_id');
    }
}
