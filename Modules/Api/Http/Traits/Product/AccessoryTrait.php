<?php

namespace Modules\Api\Http\Traits\Product;

use App\Models\BaseModel;
use App\Models\Product\Product;
use App\Models\System\BikeBodyType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use LaravelIdea\Helper\App\Models\_IH_BaseModel_C;
use LaravelIdea\Helper\App\Models\Product\_IH_Product_C;

trait AccessoryTrait
{
    /**
     * @param $filters
     * @return BaseModel[]|Product[]|LengthAwarePaginator|_IH_BaseModel_C|_IH_Product_C
     */
    public function getAccessories($filters)
    {
//        dd(Product::where('category_id',$filters['category_id'])->get());
        return Product::where('type', 'accessory')
            ->where('is_active', 1)
            ->when($filters['brand_id'], function ($query) use ($filters) {
                $query->where('brand_id', $filters['brand_id']);
            })
            ->when($filters['category_id'], function ($query) use ($filters) {
                $query->where('category_id', $filters['category_id']);
            })
            ->when($filters['search'], function ($query) use ($filters) {
                $query->whereRaw('LOWER(name) LIKE ?', '%' . strtolower($filters['name']) . '%');
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
            ->when($filters['sort_by'], function ($query) use ($filters) {
                $query->orderBy($filters['sort_by'], $filters['sort_type'] ?? 'desc');
            })
            ->paginate($filters['per_page'] ?? 10);
    }

    /**
     * @param $request
     * @return array
     */
    public function initializeAccessoryFilterData($request)
    {
        return [
            'brand_id'           => isset($request->brand_id) ? explode(',', $request->brand_id) : null,
            'category_id'        => isset($request->category_id) ? explode(',', $request->category_id) : null,
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
     * @return BaseModel|Product
     */
    public function getAccessoryDetails($name)
    {
        return Product::with('brand', 'bodyType', 'category', 'colors', 'media', 'specificationCategories.specifications')
            ->where('type', 'accessory')
            ->where('is_active', 1)
            ->where('slug', $name)
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

    /**
     * @return mixed
     */
    public function getFeaturedAccessories()
    {
        return Product::where('type', 'accessory')
            ->where('is_featured', 1)
            ->get();
    }
}
