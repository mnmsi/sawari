<?php

namespace Modules\Api\Http\Traits\Product;

use App\Models\Product\Product;
use App\Models\System\BikeBodyType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait AccessoryTrait
{
    public function getAccessories($filters)
    {
        return Product::where('type', 'accessory')
            ->where('is_active', 1)
            ->when($filters['brand_id'], function ($query) use ($filters) {
                $query->where('brand_id', $filters['brand_id']);
            })
            ->when($filters['category_id'], function ($query) use ($filters) {
                $query->where('category_id', $filters['category_id']);
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
            ->orderBy($filters['sort_by'] ?? 'id', $filters['sort_type'] ?? 'desc')
            ->paginate($filters['per_page'] ?? 10);
    }

    /**
     * @param $request
     * @return array
     */
    public function initializeAccessoryFilterData($request)
    {
        return [
            'brand_id'           => $request->brand_id,
            'category_id'        => $request->category_id,
            'price_from'         => $request->price_from,
            'price_to'           => $request->price_to,
            'discount_rate_from' => $request->discount_rate_from,
            'discount_rate_to'   => $request->discount_rate_to,
            'search'             => $request->search,
            'sort_by'            => $request->sort_by,
            'sort_type'          => $request->sort_type,
            'per_page'           => $request->per_page,
        ];
    }

    /**
     * @param $id
     * @return Builder|Model|object|null
     */
    public function getAccessoryDetails($id)
    {
        return Product::with('brand', 'bodyType', 'category', 'colors', 'media', 'specifications')
                      ->where('type', 'accessory')
                      ->where('is_active', 1)
                      ->where('id', $id)
                      ->first();
    }

    /**
     * @return mixed
     */
    public function getRelatedAccessories()
    {
        return Product::where('type', 'accessory')
                      ->where('is_active', 1)
                      ->inRandomOrder()
                      ->take(4)
                      ->get();
    }
}
