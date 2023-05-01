<?php

namespace App\Models\Sell;

use App\Models\Product\Brand;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class SellBike extends BaseModel
{
    protected $fillable = [
        'brand_id',
        'name',
        'model',
        'version',
        'image_url',
        'created_at',
        'updated_at'
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
