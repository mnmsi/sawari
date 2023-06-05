<?php

namespace App\Models\Product;

use App\Models\System\BikeBodyType;
use App\Models\User\UserWishlist;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Whitecube\NovaFlexibleContent\Value\FlexibleCast;

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
        'is_used' => 'boolean',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'color_list' => FlexibleCast::class,
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->slug = Str::slug($model->name);
        });
    }

    protected $appends = ['is_favorite', 'product_colors_id'];


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
        return $this->belongsTo(Category::class);
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

    public function wishlists()
    {
        return $this->hasMany(UserWishlist::class);
    }

    public function getIsFavoriteAttribute()
    {
        $query = UserWishlist::where('user_id', Auth::id())
            ->where('product_id', $this->id)
            ->get();
        if ($query->count() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getProductColorsIdAttribute()
    {
        return $this->colors->pluck('id');
    }

//    list

    /**
     * @throws \Exception
     */
    public function getColorListAttribute(): array
    {
        if (isset($this->attributes['id'])) {
            $list = [];
            $product = ProductColor::where('product_id', $this->attributes['id'])->get();
            foreach ($product as $l) {
                $list[] = [
                    "layout" => "video",
                    "key" => $l->id,
                    "attributes" => [
                        "color_id" => $l->id,
                        "color_name" => $l->name,
                        "color_image" => $l->image_url,
                        "color_stock" => $l->stock,
                    ]
                ];
            }
            return $list;
        } else {
            return [];
        }
    }

    public function getSpecificationListAttribute(): array
    {
        if (isset($this->attributes['id'])) {
            $list = [];
            $product = ProductSpecification::where('product_id', $this->attributes['id'])->get();
            foreach ($product as $l) {
                $list[] = [
                    "layout" => "video",
                    "key" => $l->id,
                    "attributes" => [
                        "specification_id" => $l->id,
                        "specification_title" => $l->title,
                        "specification_value" => $l->value,
                        "is_key_feature" => $l->is_key_feature,
                    ]
                ];
            }
            return $list;
        } else {
            return [];
        }
    }

}
