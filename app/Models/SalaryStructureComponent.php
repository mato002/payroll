<?php

namespace App\Models;

use App\Models\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryStructureComponent extends Model
{
    use HasFactory;
    use BelongsToCompany;

    protected $fillable = [
        'company_id',
        'salary_structure_id',
        'name',
        'code',
        'type',
        'calculation_type',
        'amount',
        'percentage',
        'formula',
        'taxable',
        'included_in_gross',
        'sort_order',
    ];

    public function salaryStructure()
    {
        return $this->belongsTo(SalaryStructure::class);
    }
}

