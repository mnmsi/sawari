<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class UserAddress extends BaseModel
{
    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'address',
        'division_id',
        'city_id',
        'area_id',
        'is_default',
        'created_at',
        'updated_at'
    ];
}
