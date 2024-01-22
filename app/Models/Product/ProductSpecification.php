<?php

namespace App\Models\Product;

use App\Models\ProductSpecificationCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class ProductSpecification extends BaseModel
{
    protected $fillable = [
        'product_specification_category_id',
        'title',
        'value',
        'created_at',
        'updated_at'
    ];

    public function specificationCategory()
    {
        return $this->belongsTo(ProductSpecificationCategory::class);
    }

}
