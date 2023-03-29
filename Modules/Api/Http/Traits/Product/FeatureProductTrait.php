<?php

namespace Modules\Api\Http\Traits\Product;

use App\Models\Product\Product;

trait FeatureProductTrait
{
    /**
     * @return mixed
     */
    public function featuredNewBike()
    {
        // Featured New Bike Product
        return Product::where('is_active', 1)
                      ->where('type', 'bike')
                      ->where('is_used', 1)
                      ->where('is_featured', 1)
                      ->get();
    }

    /**
     * @return mixed
     */
    public function featuredUsedBike()
    {
        // Featured Used Bike Product
        return Product::where('is_active', 1)
                      ->where('type', 'bike')
                      ->where('is_used', 0)
                      ->where('is_featured', 1)
                      ->get();
    }
}
