<?php

namespace App\Models;

use App\Models\Order\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'tran_id',
        'val_id',
        'amount',
        'store_amount',
        'bank_tran_id',
        'card_type',
        'card_no',
        'status',
        'tran_date',
        'currency',
        'card_issuer',
        'card_brand',
        'card_sub_brand',
        'card_issuer_country',
        'card_issuer_country_code',
        'currency_type',
        'currency_amount',
        'currency_rate',
        'risk_title',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
