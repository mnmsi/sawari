<?php

namespace App\Models\System;

use App\Models\GuestOrder;
use App\Models\Order\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Showroom extends BaseModel
{
    protected $fillable = [
        'name',
        'phone',
        'address',
        'country_id',
        'division_id',
        'city_id',
        'area_id',
        'postal_code',
        'location_image_url',
        'support_number',
        'is_active',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function guestOrder()
    {
        return $this->hasMany(GuestOrder::class);
    }

//    public function getLocationImageUrlAttribute($value)
//    {
////        $shareableLink = 'https://goo.gl/maps/SHXUXu6jg8GbQVZb6?coh=178571&entry=tt';
//
//        $embedUrl = 'https://www.google.com/maps/embed';
//        $embedParams = [
//            'q' => $value,
//        ];
//
//        $embedUrl .= '?' . http_build_query($embedParams);
//
//        $iframeCode = '<iframe src="' . $embedUrl . '" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';
//        return $iframeCode;
//    }
}
