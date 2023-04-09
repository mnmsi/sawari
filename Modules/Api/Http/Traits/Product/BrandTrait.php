<?php

namespace Modules\Api\Http\Traits\Product;

use App\Models\BaseModel;
use App\Models\Product\Brand;
use LaravelIdea\Helper\App\Models\_IH_BaseModel_C;
use LaravelIdea\Helper\App\Models\Product\_IH_Brand_C;

trait BrandTrait
{
    /**
     * @return mixed
     */
    public function getBikeBrands()
    {
        return Brand::where('is_active', 1)
            ->where(function ($query) {
                $query->where('type', 'bike')
                    ->orWhere('type', 'both');
            })
            ->orderBy('name')
            ->paginate(request('per_page', 9));
    }

    /**
     * @return mixed
     */
    public function getPopularBikeBrands()
    {
        return Brand::where('is_active', 1)
            ->where(function ($query) {
                $query->where('type', 'bike')
                    ->orWhere('type', 'both');
            })
            ->where('is_popular', 1)
            ->orderBy('name', 'asc')
            ->get();
    }

    /**
     * @return mixed
     */
    public function getAccessoryBrands()
    {
        return Brand::where('is_active', 1)
            ->where(function ($query) {
                $query->where('type', 'accessory')
                    ->orWhere('type', 'both');
            })
            ->orderBy('name')
            ->paginate(request('per_page', 9));
    }

    /**
     * @return mixed
     */
    public function getPopularAccessoryBrands()
    {
        return Brand::where('is_active', 1)
            ->where(function ($query) {
                $query->where('type', 'accessory')
                    ->orWhere('type', 'both');
            })
            ->where('is_popular', 1)
            ->orderBy('name', 'asc')
            ->get();
    }

    /**
     * @param $id
     * @return BaseModel[]|Brand[]|_IH_BaseModel_C|_IH_Brand_C
     */
    public function getCategoryBrands($id)
    {
        return Brand::where('is_active', 1)
            ->where('category_id', $id)
            ->where(function ($query) {
                $query->where('type', 'accessory')
                    ->orWhere('type', 'both');
            })
            ->orderBy('name')
            ->get();
    }
}
