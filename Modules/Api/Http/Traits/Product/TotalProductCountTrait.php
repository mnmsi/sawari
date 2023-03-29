<?php

namespace Modules\Api\Http\Traits\Product;

use App\Models\Product\Product;

trait TotalProductCountTrait
{
    /**
     * @return mixed
     */
    public function totalNewBikes()
    {
        // Total New Bike Product Count
        return Product::where('is_active', 1)
                      ->where('type', 'bike')
                      ->where('is_used', 1)
                      ->count();

    }

    /**
     * @return mixed
     */
    public function totalUsedBikes()
    {
        // Total Used Bike Product Count
        return Product::where('is_active', 1)
                      ->where('type', 'bike')
                      ->where('is_used', 0)
                      ->count();
    }


    /**
     * @return mixed
     */
    public function totalAccessories()
    {
        // Total Accessory Product Count
        return Product::where('is_active', 1)
                      ->where('type', 'accessory')
                      ->count();
    }
}
