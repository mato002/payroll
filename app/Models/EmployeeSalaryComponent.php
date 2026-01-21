<?php

namespace App\Models;

use App\Models\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeSalaryComponent extends Model
{
    use HasFactory;
    use BelongsToCompany;

    protected $fillable = [
        'company_id',
        'employee_salary_structure_id',
        'salary_structure_component_id',
        'override_amount',
        'override_percentage',
    ];

    public function employeeSalaryStructure()
    {
        return $this->belongsTo(EmployeeSalaryStructure::class);
    }

    public function salaryStructureComponent()
    {
        return $this->belongsTo(SalaryStructureComponent::class);
    }
}

