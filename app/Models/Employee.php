<?php

namespace App\Models;

use App\Casts\EncryptedString;
use App\Models\Traits\Auditable;
use App\Models\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    use BelongsToCompany;
    use Auditable;

    protected $fillable = [
        'company_id',
        'user_id',
        'employee_code',
        'first_name',
        'last_name',
        'middle_name',
        'email',
        'phone',
        'date_of_birth',
        'national_id',
        'hire_date',
        'termination_date',
        'employment_status',
        'employment_type',
        'department_id',
        'job_title',
        'pay_frequency',
        'bank_account_number',
        'bank_name',
        'bank_branch',
        'tax_number',
        'social_security_number',
        'is_active',
    ];

    protected $casts = [
        'date_of_birth'         => 'date',
        'hire_date'             => 'date',
        'termination_date'       => 'date',
        'national_id'            => EncryptedString::class,
        'bank_account_number'    => EncryptedString::class,
        'tax_number'             => EncryptedString::class,
        'social_security_number' => EncryptedString::class,
    ];

    protected static function booted(): void
    {
        static::created(function (Employee $employee): void {
            // Notify company admins about new employee
            $company = $employee->company;

            if (! $company) {
                return;
            }

            $recipients = \App\Models\User::whereHas('companies', function ($q) use ($company) {
                    $q->where('companies.id', $company->id);
                })
                ->whereHas('roles', function ($q) use ($company) {
                    $q->whereHas('company', function ($q2) use ($company) {
                        $q2->where('companies.id', $company->id);
                    })->whereIn('slug', ['company_admin', 'payroll_manager']);
                })
                ->get();

            foreach ($recipients as $user) {
                $user->notify(new \App\Notifications\NewEmployeeAddedNotification($employee));
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payslips()
    {
        return $this->hasMany(Payslip::class);
    }

    public function lifecycleEvents()
    {
        return $this->hasMany(EmployeeLifecycleEvent::class);
    }

    public function salaryChangeHistory()
    {
        return $this->hasMany(SalaryChangeHistory::class);
    }

    public function terminationSettlements()
    {
        return $this->hasMany(TerminationSettlement::class);
    }

    public function activeTerminationSettlement()
    {
        return $this->hasOne(TerminationSettlement::class)
            ->where('settlement_status', '!=', 'paid')
            ->latest();
    }

    public function employeeSalaryStructures()
    {
        return $this->hasMany(EmployeeSalaryStructure::class);
    }

    public function currentSalaryStructure()
    {
        return $this->hasOne(EmployeeSalaryStructure::class)
            ->where('is_current', true)
            ->where(function ($query) {
                $query->whereNull('effective_to')
                    ->orWhere('effective_to', '>=', now());
            })
            ->latest('effective_from');
    }
}

