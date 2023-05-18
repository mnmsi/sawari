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
        'discount_rate',
        'price',
        'total',
        'quantity',
        'status',
        'created_at',
        'updated_at'
    ];

    public function product()
    {
        return $this->belongsTo('App\Models\Product\Product');
    }

    public function productColor()
    {
        return $this->belongsTo('App\Models\Product\ProductColor');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }


}

