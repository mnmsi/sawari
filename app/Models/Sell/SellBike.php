<?php

namespace App\Models\Sell;

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
}
