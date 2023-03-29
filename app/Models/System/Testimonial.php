<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Testimonial extends BaseModel
{
    protected $fillable = [
        'name',
        'address',
        'note',
        'rate',
        'image_url',
        'is_active',
        'created_at',
        'updated_at'
    ];
}
