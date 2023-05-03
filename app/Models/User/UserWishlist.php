<?php

namespace App\Models\User;

use App\Models\Product\Product;
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

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
