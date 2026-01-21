<?php

namespace App\Models;

use App\Casts\EncryptedDecimal;
use App\Models\Traits\Auditable;
use App\Models\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollItemDetail extends Model
{
    use HasFactory;
    use BelongsToCompany;
    use Auditable;

    protected $fillable = [
        'company_id',
        'payroll_item_id',
        'component_type',
        'component_code',
        'component_name',
        'base_amount',
        'calculated_amount',
        'taxable',
        'sort_order',
    ];

    protected $casts = [
        'base_amount'        => EncryptedDecimal::class,
        'calculated_amount'  => EncryptedDecimal::class,
    ];

    public function payrollItem()
    {
        return $this->belongsTo(PayrollItem::class);
    }
}

