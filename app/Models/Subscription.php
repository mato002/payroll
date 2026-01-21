<?php

namespace App\Models;

use App\Models\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
    use BelongsToCompany;

    protected $fillable = [
        'company_id',
        'external_subscription_id',
        'plan_code',
        'billing_cycle',
        'status',
        'start_date',
        'end_date',
        'trial_end_date',
        'next_billing_date',
        'base_price',
        'per_employee_price',
        'max_employees_included',
        'currency',
        'auto_renew',
    ];

    protected $casts = [
        'start_date'        => 'date',
        'end_date'          => 'date',
        'trial_end_date'    => 'date',
        'next_billing_date' => 'date',
        'auto_renew'        => 'boolean',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'plan_code', 'code');
    }

    public function isActive(): bool
    {
        return $this->status === 'active'
            && ($this->end_date === null || $this->end_date->isFuture());
    }

    public function isOnTrial(): bool
    {
        return $this->status === 'trial'
            && $this->trial_end_date !== null
            && $this->trial_end_date->isFuture();
    }

    public function isPastDue(): bool
    {
        return $this->status === 'past_due';
    }

    public function isCanceled(): bool
    {
        return in_array($this->status, ['canceled', 'paused'], true);
    }
}

