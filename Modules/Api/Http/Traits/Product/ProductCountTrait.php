<?php

namespace Modules\Api\Http\Traits\Product;

use App\Models\Product\Product;
use App\Models\System\Showroom;

trait ProductCountTrait
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

    /**
     * @return mixed
     */
    public function totalShops()
    {
        // Total Shop Count
        return Showroom::where('is_active', 1)
            ->count();
    }

    public function getSearchSuggestions($search)
    {
        $searchItem = explode(' ', $search);
        $query = Product::where('is_active', 1)->whereIn('type', 'bike');
        foreach ($searchItem as $item) {
            $query->where('name', 'LIKE', '%' . $item . '%');
        }
        return $query->take(5)->get();
    }
}
