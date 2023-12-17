<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Banner extends BaseModel
{
    protected $fillable = [
        'page',
        'show_on',
        'image_url',
        'order_no',
        'home_images',
        'is_active',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $appends = ['home_show_on'];

    public function getHomeImageAttribute(): array
    {
        if (isset($this->attributes['id']) && !empty($this->attributes['home_images'])) {
            $list = [];
            $banner_list = json_decode($this->attributes['home_images'], true);
            foreach ($banner_list as $l) {
                $list[] = [
                    "layout" => "video",
                    "key" => rand(111111, 999999),
                    "attributes" => [
                        "home_image" => $l["image"],
                        "image_url" => $l["url"],
                    ]
                ];
            }
            return $list;
        } else {
            return [];
        }
    }

    public function getHomeShowOnAttribute()
    {
        if (!empty($this->attributes['show_on'])) {
            return $this->attributes['show_on'];
        }
        return null;
    }
}
