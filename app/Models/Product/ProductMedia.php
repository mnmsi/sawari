<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class ProductMedia extends BaseModel
{
    protected $fillable = [
        'product_id',
        'product_color_id',
        'type',
        'url',
        'thumbnail_url',
        'created_at',
        'updated_at'
    ];
}
