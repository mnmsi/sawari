<?php

namespace App\Models\Product;

use App\Models\System\BikeBodyType;
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
        'total_stock',
        'is_used',
        'is_featured',
        'is_active',
        'badge_url',
        'image_url',
        'short_description',
        'description',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'is_used'      => 'boolean',
        'is_featured'  => 'boolean',
        'is_active'    => 'boolean'
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function bodyType()
    {
        return $this->belongsTo(BikeBodyType::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class)->whereNotNull('category_id');
    }

    public function colors()
    {
        return $this->hasMany(ProductColor::class);
    }

    public function media()
    {
        return $this->hasMany(ProductMedia::class);
    }

    public function specifications()
    {
        return $this->hasMany(ProductSpecification::class);
    }
}
