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
        'stock',
        'created_at',
        'updated_at'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
