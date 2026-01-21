<?php

namespace App\Models;

use App\Casts\EncryptedDecimal;
use App\Models\Traits\Auditable;
use App\Models\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollItem extends Model
{
    use HasFactory;
    use BelongsToCompany;
    use Auditable;

    protected $fillable = [
        'company_id',
        'payroll_run_id',
        'employee_id',
        'salary_structure_id',
        'gross_amount',
        'total_earnings',
        'total_deductions',
        'total_contributions',
        'net_amount',
        'currency',
        'status',
    ];

    protected $casts = [
        'gross_amount'        => EncryptedDecimal::class,
        'total_earnings'       => EncryptedDecimal::class,
        'total_deductions'     => EncryptedDecimal::class,
        'total_contributions'  => EncryptedDecimal::class,
        'net_amount'          => EncryptedDecimal::class,
    ];

    public function payrollRun()
    {
        return $this->belongsTo(PayrollRun::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function salaryStructure()
    {
        return $this->belongsTo(SalaryStructure::class);
    }

    public function details()
    {
        return $this->hasMany(PayrollItemDetail::class);
    }
}

