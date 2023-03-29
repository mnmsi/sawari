<?php

namespace Modules\Api\Http\Traits\Product;

use App\Models\Product\Product;

trait TotalProductCountTrait
{
    // Total New Bike Product Count
    public function totalNewBikes()
    {
        return Product::where('is_active', 1)
                      ->where('type', 'bike')
                      ->where('is_used', 1)
                      ->count();

    }

    // Total Used Bike Product Count
    public function totalUsedBikes()
    {
        return Product::where('is_active', 1)
                      ->where('type', 'bike')
                      ->where('is_used', 0)
                      ->count();
    }

    // Total Accessory Product Count
    public function totalAccessories()
    {
        return Product::where('is_active', 1)
                      ->where('type', 'accessory')
                      ->count();
    }
}
