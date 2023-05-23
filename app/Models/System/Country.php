<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends BaseModel
{
    public $timestamps = false;

    public function division(): HasMany
    {
        return $this->hasMany(Division::class);
    }
}
