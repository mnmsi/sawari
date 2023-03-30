<?php

namespace Modules\Api\Http\Traits\Product;

use App\Models\Product\Brand;
use App\Models\Product\Category;

trait ProductBrandTrait
{
    /**
     * @return mixed
     */
    public function getBikeBrands()
    {
        return Brand::where('is_active', 1)
                    ->where('type', 'bike')
                    ->orderBy('name', 'asc')
                    ->get();
    }

    /**
     * @return mixed
     */
    public function getPopularBikeBrands()
    {
        return Brand::where('is_active', 1)
                    ->where('type', 'bike')
                    ->where('is_popular', 1)
                    ->orderBy('name', 'asc')
                    ->get();
    }
}
