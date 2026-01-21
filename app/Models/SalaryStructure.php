<?php

namespace App\Models;

use App\Models\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryStructure extends Model
{
    use HasFactory;
    use BelongsToCompany;

    protected $fillable = [
        'company_id',
        'name',
        'description',
        'pay_frequency',
        'currency',
        'is_default',
        'effective_from',
        'effective_to',
    ];

    public function components()
    {
        return $this->hasMany(SalaryStructureComponent::class);
    }

    public function employeeAssignments()
    {
        return $this->hasMany(EmployeeSalaryStructure::class);
    }
}

