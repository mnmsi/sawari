<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Cart extends BaseModel
{
    protected $fillable = [
        'user_id',
        'product_id',
        'product_color_id',
        'quantity',
        'created_at',
        'updated_at'
    ];
}
