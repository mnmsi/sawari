<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Product extends BaseModel
{
    protected $fillable = [
        'brand_id',
        'body_type_id',
        'type',
        'category_id',
        'name',
        'price',
        'discount_rate',
        'shipping_charge',
        'stock',
        'is_used',
        'is_featured',
        'is_active',
        'badge_url',
        'short_description',
        'description',
        'created_at',
        'updated_at'
    ];
}
