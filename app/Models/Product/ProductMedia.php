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

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function color()
    {
        return $this->belongsTo(ProductColor::class, 'product_color_id', 'id');
    }
}
