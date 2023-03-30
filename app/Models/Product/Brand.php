<?php

namespace App\Models\Product;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use App\Models\BaseModel;

class Brand extends BaseModel
{
    use CrudTrait;

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
        'is_active'  => 'boolean'
    ];
}
