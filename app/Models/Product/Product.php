<?php

    namespace App\Models\Product;

    use App\Models\System\BikeBodyType;
    use App\Models\User\UserWishlist;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use App\Models\BaseModel;
    use Illuminate\Support\Facades\Auth;

    class Product extends BaseModel
    {
        protected $fillable = [
            'brand_id',
            'body_type_id',
            'type',
            'category_id',
            'name',
            'price',
            'discount_rate',
            'shipping_charge',
            'total_stock',
            'is_used',
            'is_featured',
            'is_active',
            'badge_url',
            'image_url',
            'short_description',
            'description',
            'created_at',
            'updated_at'
        ];
        protected $casts = [
            'is_used' => 'boolean',
            'is_featured' => 'boolean',
            'is_active' => 'boolean'
        ];

        protected $appends = ['is_favorite'];


        public function brand()
        {
            return $this->belongsTo(Brand::class);
        }

        public function bodyType()
        {
            return $this->belongsTo(BikeBodyType::class);
        }

        public function category()
        {
            return $this->belongsTo(Category::class);
        }

        public function colors()
        {
            return $this->hasMany(ProductColor::class);
        }

        public function media()
        {
            return $this->hasMany(ProductMedia::class);
        }

        public function specifications()
        {
            return $this->hasMany(ProductSpecification::class);
        }

        public function wishlists()
        {
            return $this->hasMany(UserWishlist::class);
        }

        public function getIsFavoriteAttribute()
        {
            $query = UserWishlist::where('user_id', Auth::id())
                ->where('product_id', $this->id)
                ->get();
            if ($query->count() > 0) {
                return true;
            } else {
                return false;
            }
        }

    }
