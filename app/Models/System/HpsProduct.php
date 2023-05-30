<?php

namespace App\Models\System;

use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HpsProduct extends Model
{
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
