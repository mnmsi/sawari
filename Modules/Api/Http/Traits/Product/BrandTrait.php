<?php

namespace Modules\Api\Http\Traits\Product;

use App\Models\Product\Brand;
use App\Models\Product\Category;

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
                    ->orderBy('name', 'asc')
                    ->get();
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
                    ->orderBy('name', 'asc')
                    ->get();
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
}
