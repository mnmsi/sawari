<?php

namespace App\Models\Product;

use App\Models\Sell\SellBike;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Brand extends BaseModel
{

    protected $fillable = [
        'name',
        'image_url',
        'type',
        'is_popular',
        'is_active',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'is_popular' => 'boolean',
        'is_active' => 'boolean'
    ];

    public function sellBike()
    {
        return $this->hasMany(SellBike::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
