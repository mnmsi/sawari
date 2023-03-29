<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class PaymentMethod extends BaseModel
{
    protected $fillable = [
        'name',
        'is_active',
        'created_at',
        'updated_at'
    ];
}
