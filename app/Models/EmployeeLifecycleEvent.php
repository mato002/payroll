<?php

namespace App\Models;

use App\Models\Traits\Auditable;
use App\Models\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeLifecycleEvent extends Model
{
    use HasFactory;
    use BelongsToCompany;
    use Auditable;

    protected $fillable = [
        'company_id',
        'employee_id',
        'created_by',
        'event_type',
        'title',
        'description',
        'event_data',
        'effective_date',
        'related_salary_change_id',
        'related_termination_settlement_id',
    ];

    protected $casts = [
        'event_data' => 'array',
        'effective_date' => 'date',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function relatedSalaryChange(): BelongsTo
    {
        return $this->belongsTo(SalaryChangeHistory::class, 'related_salary_change_id');
    }

    public function relatedTerminationSettlement(): BelongsTo
    {
        return $this->belongsTo(TerminationSettlement::class, 'related_termination_settlement_id');
    }
}
