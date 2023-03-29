<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Category extends BaseModel
{
    protected $fillable = [
        'name',
        'image_url',
        'is_active',
        'created_at',
        'updated_at'
    ];
}
