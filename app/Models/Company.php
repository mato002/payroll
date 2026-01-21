<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'legal_name',
        'registration_number',
        'tax_id',
        'billing_email',
        'stripe_customer_id',
        'paystack_customer_code',
        'country',
        'timezone',
        'currency',
        'address_line1',
        'address_line2',
        'city',
        'state',
        'postal_code',
        'is_active',
        'subscription_status',
        'trial_ends_at',
        'logo_path',
    ];

    /**
     * Boot the model.
     */
    protected static function boot(): void
    {
        parent::boot();

        // Auto-generate slug from name if not provided
        static::creating(function ($company) {
            if (empty($company->slug) && !empty($company->name)) {
                $company->slug = \Illuminate\Support\Str::slug($company->name);
            }
        });
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'company_user')
            ->withPivot(['is_owner', 'status', 'invited_at', 'joined_at'])
            ->withTimestamps();
    }

    public function roles()
    {
        return $this->hasMany(Role::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function salaryStructures()
    {
        return $this->hasMany(SalaryStructure::class);
    }

    public function payrollRuns()
    {
        return $this->hasMany(PayrollRun::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}

