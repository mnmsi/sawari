<?php

namespace App\Models;

use App\Models\Product\Product;
use App\Models\Product\ProductSpecification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Whitecube\NovaFlexibleContent\Value\FlexibleCast;

class ProductSpecificationCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'name',
    ];

    protected $appends = ['specification_list'];

    protected $casts = [
        'specification_list' => FlexibleCast::class,
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function specifications()
    {
        return $this->hasMany(ProductSpecification::class);
    }

    public function getSpecificationListAttribute(): array
    {
        if (isset($this->attributes['id'])) {
            $list = [];
            $product = ProductSpecification::where('product_specification_category_id', $this->attributes['id'])->get();
            foreach ($product as $l) {
                $list[] = [
                    "layout" => "video",
                    "key" => $l->id,
                    "attributes" => [
                        "specification_id" => $l->id,
                        "specification_title" => $l->title,
                        "specification_value" => $l->value,
                    ]
                ];
            }
            return $list;
        } else {
            return [];
        }
    }
}
