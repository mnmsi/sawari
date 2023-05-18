<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_color_id',
        'price',
        'quantity',
        'total',
        'discount_rate',
        'subtotal_price',
    ];
}
