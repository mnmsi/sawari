<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class ProductReview extends BaseModel
{
    protected $fillable = [
        'user_id',
        'product_id',
        'review',
        'rate',
        'created_at',
        'updated_at'
    ];
}
