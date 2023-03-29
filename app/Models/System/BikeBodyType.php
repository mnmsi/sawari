<?php

namespace App\Models\System;

use App\Models\BaseModel;

class BikeBodyType extends BaseModel
{
    public $timestamps = false;

    protected $fillable = [
        'name'
    ];
}
