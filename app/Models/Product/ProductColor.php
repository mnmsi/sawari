<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class ProductColor extends BaseModel
{
    protected $fillable = [
        'product_id',
        'name',
        'image_url',
        'created_at',
        'updated_at'
    ];
}
