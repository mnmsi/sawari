<?php

namespace App\Models\Sell;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class BikeSellRequest extends BaseModel
{
    protected $fillable = [
        'user_id',
        'city_id',
        'area_id',
        'brand_id',
        'bike_id',
        'registration_year',
        'registration_duration',
        'registration_zone',
        'registration_series',
        'color',
        'mileage_range',
        'bought_from_us',
        'ownership_status',
        'engine_condition',
        'accident_history',
        'bike_image',
        'created_at',
        'updated_at'
    ];
}
