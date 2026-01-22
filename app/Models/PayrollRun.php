<?php

namespace App\Models;

use App\Casts\EncryptedDecimal;
use App\Models\Traits\Auditable;
use App\Models\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollRun extends Model
{
    use HasFactory;
    use BelongsToCompany;
    use Auditable;

    protected $fillable = [
        'company_id',
        'name',
        'period_start_date',
        'period_end_date',
        'pay_date',
        'status',
        'pay_frequency',
        'description',
        'created_by',
        'approved_by',
        'approved_at',
        'total_gross_amount',
        'total_net_amount',
    ];

    protected $casts = [
        'period_start_date' => 'date',
        'period_end_date'   => 'date',
        'pay_date'          => 'date',
        'approved_at'       => 'datetime',
        'total_gross_amount' => EncryptedDecimal::class,
        'total_net_amount'   => EncryptedDecimal::class,
    ];

    /**
     * State helpers
     */
    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    public function isUnderReview(): bool
    {
        return $this->status === 'processing';
    }

    public function isApproved(): bool
    {
        return in_array($this->status, ['completed', 'closed'], true);
    }

    public function isLocked(): bool
    {
        return in_array($this->status, ['completed', 'closed', 'canceled'], true);
    }

    /**
     * Allowed transitions
     */
    public function canSubmitForReview(): bool
    {
        return $this->isDraft() && ! $this->isLocked();
    }

    public function canApprove(): bool
    {
        return $this->status === 'processing' && ! $this->isLocked();
    }

    public function canLock(): bool
    {
        return $this->status === 'completed' && ! $this->isLocked();
    }

    protected function getAuditDescription(string $eventType): string
    {
        return sprintf('Payroll Run "%s" %s (ID: %s)', $this->name, $eventType, $this->id);
    }

    public function items()
    {
        return $this->hasMany(PayrollItem::class);
    }

    public function payslips()
    {
        return $this->hasMany(Payslip::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}

