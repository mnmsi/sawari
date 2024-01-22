<?php

namespace App\Models;

use App\Models\Product\Product;
use App\Models\Product\ProductSpecification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSpecificationCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'name',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function specifications()
    {
        return $this->hasMany(ProductSpecification::class, 'category_id', 'id');
    }
}
