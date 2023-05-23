<?php

namespace App\Models\User;

use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
