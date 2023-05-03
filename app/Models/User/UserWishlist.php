<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class UserWishlist extends BaseModel
{
    protected $table = 'user_wishlist';
    protected $fillable = [
        'user_id',
        'product_id',
        'created_at',
        'updated_at'
    ];
}
