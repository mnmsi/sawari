<?php

namespace App\Models\Product;

use App\Models\BaseModel;

class Category extends BaseModel
{
    protected $fillable = [
        'name',
        'image_url',
        'is_popular',
        'is_active',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'is_popular' => 'boolean',
        'is_active'  => 'boolean'
    ];
}
