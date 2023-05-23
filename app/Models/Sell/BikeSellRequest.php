<?php

namespace App\Models\Sell;

use App\Models\Product\Brand;
use App\Models\System\Area;
use App\Models\System\City;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'status',
        'created_at',
        'updated_at'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function bike(): BelongsTo
    {
        return $this->belongsTo(SellBike::class, 'bike_id', 'id');
    }

    public function getBikeImageAttribute($value)
    {
        $images = json_decode($value, true);
        $html = '';

        foreach ($images as $image) {
            $image = asset('storage/' . $image);
            $html .= "<img src='$image' alt='Image'>";
        }

        return $html;
    }
}
