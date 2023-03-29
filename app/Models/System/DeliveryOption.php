<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class DeliveryOption extends BaseModel
{
    protected $fillable = [
        'name',
        'bonus',
        'is_active',
        'created_at',
        'updated_at'
    ];
}
