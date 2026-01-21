<?php

namespace App\Models;

use App\Models\Traits\Auditable;
use App\Models\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SalaryChangeHistory extends Model
{
    use HasFactory;
    use BelongsToCompany;
    use Auditable;

    protected $fillable = [
        'company_id',
        'employee_id',
        'created_by',
        'old_salary_structure_id',
        'new_salary_structure_id',
        'old_employee_salary_structure_id',
        'new_employee_salary_structure_id',
        'change_reason',
        'reason_notes',
        'effective_from',
        'effective_to',
        'old_salary_components',
        'new_salary_components',
        'old_total_gross',
        'new_total_gross',
        'old_total_net',
        'new_total_net',
        'percentage_change',
    ];

    protected $casts = [
        'effective_from' => 'date',
        'effective_to' => 'date',
        'old_salary_components' => 'array',
        'new_salary_components' => 'array',
        'old_total_gross' => 'decimal:2',
        'new_total_gross' => 'decimal:2',
        'old_total_net' => 'decimal:2',
        'new_total_net' => 'decimal:2',
        'percentage_change' => 'decimal:2',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function oldSalaryStructure(): BelongsTo
    {
        return $this->belongsTo(SalaryStructure::class, 'old_salary_structure_id');
    }

    public function newSalaryStructure(): BelongsTo
    {
        return $this->belongsTo(SalaryStructure::class, 'new_salary_structure_id');
    }

    public function oldEmployeeSalaryStructure(): BelongsTo
    {
        return $this->belongsTo(EmployeeSalaryStructure::class, 'old_employee_salary_structure_id');
    }

    public function newEmployeeSalaryStructure(): BelongsTo
    {
        return $this->belongsTo(EmployeeSalaryStructure::class, 'new_employee_salary_structure_id');
    }
}
