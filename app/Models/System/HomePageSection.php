<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomePageSection extends Model
{
    public function homePageSection()
    {
        return $this->hasMany(HpsProduct::class, 'hps_section_id', 'id');
    }
}
