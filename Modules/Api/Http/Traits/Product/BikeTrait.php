<?php

namespace Modules\Api\Http\Traits\Product;

use App\Models\Product\Product;
use App\Models\System\BikeBodyType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait BikeTrait
{
    /**
     * @param array $filters
     * @return mixed
     */
    public function getBikeProducts($filters)
    {
//        dd(Product::all()->toArray());
//        dd($filters,count($filters['brand_id']));
        return Product::where('type', 'bike')
            ->where('is_active', 1)
            ->whereHas('colors', function ($query) {
                $query->where('stock', '>', 0);
            })
            ->when($filters['brand_id'], function ($query) use ($filters) {
                $query->whereIn('brand_id', $filters['brand_id']);
            })
            ->when($filters['body_type_id'], function ($query) use ($filters) {
                $query->whereIn('body_type_id', $filters['body_type_id']);
            })
            ->when($filters['is_used'], function ($query) use ($filters) {
                if ($filters['is_used'] === 'yes') {
                    $query->where('is_used', 1);
                } else {
                    $query->where('is_used', 0);
                }
            })
            ->when($filters['used_bike_type'], function ($query) use ($filters) {
                if ($filters['used_bike_type'] === 'new') {
                    $query->where('used_bike_type', 0);
                } else {
                    $query->where('used_bike_type', 1);
                }
            })
            ->when($filters['color'], function ($query) use ($filters) {
                $query->whereHas('colors', function ($query) use ($filters) {
                    $query->whereIn('name', $filters['color']);
                });
            })
            ->when($filters['search'], function ($query) use ($filters) {
                $query->where('name', 'like', '%' . $filters['search'] . '%');
            })
            ->where(function ($query) use ($filters) {
                $query->when($filters['price_from'], function ($query) use ($filters) {
                    $query->where('price', '>=', $filters['price_from']);
                })
                    ->when($filters['price_to'], function ($query) use ($filters) {
                        $query->where('price', '<=', $filters['price_to']);
                    });
            })
            ->where(function ($query) use ($filters) {
                $query->when($filters['discount_rate_from'], function ($query) use ($filters) {
                    $query->where('discount_rate', '>=', $filters['discount_rate_from']);
                })
                    ->when($filters['discount_rate_to'], function ($query) use ($filters) {
                        $query->where('discount_rate', '<=', $filters['discount_rate_to']);
                    });
            })
//            ->orderBy($filters['sort_by'] ?? 'id', $filters['sort_type'] ?? 'desc')
            ->orderByRaw('ISNULL(`order_no`), `order_no` ASC')
            ->paginate($filters['per_page'] ?? 10);
    }

    /**
     * @param $request
     * @return array
     */
    public function initializeBikeFilterData($request)
    {
        return [
            'brand_id' => isset($request->brand_id) ? explode(',', $request->brand_id) : null,
            'used_bike_type' => $request->used_bike_type,
            'body_type_id' => isset($request->body_type_id) ? explode(',', $request->body_type_id) : null,
            'category_id' => isset($request->category_id) ? explode(',', $request->category_id) : null,
            'is_used' => $request->is_used,
            'color' => isset($request->color) ? explode(',', $request->color) : null,
            'price_from' => $request->price_from,
            'price_to' => $request->price_to,
            'discount_rate_from' => $request->discount_rate_from,
            'discount_rate_to' => $request->discount_rate_to,
            'search' => $request->search,
            'sort_by' => $request->sort_by,
            'sort_type' => $request->sort_type,
            'per_page' => $request->per_page,
        ];
    }

    /**
     * @param $name
     * @return Builder|Model|object|null
     */
    public function getBikeDetails($name)
    {
        return Product::with('brand', 'bodyType', 'category', 'colors', 'media', 'specificationCategories.specifications', 'wishlists')
            ->where('is_active', 1)
            ->where('slug', $name)
            ->first();
    }

    /**
     * @return mixed
     */
    public function getRelatedBikes()
    {
        return Product::where('type', 'bike')
            ->where('is_active', 1)
            ->whereHas('colors', function ($query) {
                $query->where('stock', '>', 0);
            })
            ->inRandomOrder()
            ->take(4)
            ->get();
    }

    public function getUpComingBikes()
    {
        return Product::where('type', 'bike')
            ->where('is_active', 1)
            ->whereHas('colors', function ($query) {
                $query->where('stock', '>', 0);
            })
            ->where('is_upcoming', 1)
            ->orderByRaw('ISNULL(`category_order_no`), `category_order_no` ASC')
            ->paginate( 12);
    }

    public function getScooter()
    {
        return Product::where('type', 'bike')
            ->where('is_active', 1)
            ->whereHas('colors', function ($query) {
                $query->where('stock', '>', 0);
            })
            ->where('is_scooter', 1)
            ->orderByRaw('ISNULL(`category_order_no`), `category_order_no` ASC')
            ->paginate( 12);
    }
    /**
     * @return mixed
     */
    public function getBikeBodyTypes()
    {
        return BikeBodyType::select('id', 'name')
            ->get();
    }
}
