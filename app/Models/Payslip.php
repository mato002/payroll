<?php

namespace App\Models;

use App\Casts\EncryptedDecimal;
use App\Models\Traits\Auditable;
use App\Models\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payslip extends Model
{
    use HasFactory;
    use BelongsToCompany;
    use Auditable;

    protected $fillable = [
        'company_id',
        'payroll_run_id',
        'employee_id',
        'payslip_number',
        'issue_date',
        'gross_amount',
        'total_earnings',
        'total_deductions',
        'net_amount',
        'currency',
        'status',
        'pdf_url',
    ];

    protected $casts = [
        'issue_date'      => 'date',
        'gross_amount'     => EncryptedDecimal::class,
        'total_earnings'   => EncryptedDecimal::class,
        'total_deductions' => EncryptedDecimal::class,
        'net_amount'       => EncryptedDecimal::class,
    ];

    protected static function booted(): void
    {
        static::created(function (Payslip $payslip): void {
            // Notify employee when payslip is ready
            $employeeUser = $payslip->employee?->user;

            if ($employeeUser) {
                $employeeUser->notify(new \App\Notifications\PayslipReadyNotification($payslip));
            }
        });
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function payrollRun()
    {
        return $this->belongsTo(PayrollRun::class);
    }

    public function payrollItem()
    {
        return $this->belongsTo(PayrollItem::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}

