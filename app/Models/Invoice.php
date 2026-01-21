<?php

namespace App\Models;

use App\Models\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    use BelongsToCompany;

    protected $fillable = [
        'company_id',
        'subscription_id',
        'invoice_number',
        'issue_date',
        'due_date',
        'period_start_date',
        'period_end_date',
        'status',
        'subtotal_amount',
        'tax_amount',
        'total_amount',
        'amount_paid',
        'currency',
        'notes',
        'external_invoice_id',
    ];

    protected $casts = [
        'issue_date'        => 'date',
        'due_date'          => 'date',
        'period_start_date' => 'date',
        'period_end_date'   => 'date',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}

