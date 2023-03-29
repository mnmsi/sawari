<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Order extends BaseModel
{
    protected $fillable = [
        'user_id',
        'product_id',
        'product_color_id',
        'payment_method_id',
        'delivery_option_id',
        'quantity',
        'price',
        'discount_rate',
        'shipping_amount',
        'subtotal_price',
        'total_price',
        'status',
        'created_at',
        'updated_at'
    ];
}
