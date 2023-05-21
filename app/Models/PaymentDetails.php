<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
