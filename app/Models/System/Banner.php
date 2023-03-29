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
        'is_active',
        'created_at',
        'updated_at',
    ];
}
