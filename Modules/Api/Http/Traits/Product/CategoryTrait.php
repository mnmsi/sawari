<?php

namespace Modules\Api\Http\Traits\Product;

use App\Models\Product\Brand;
use App\Models\Product\Category;

trait CategoryTrait
{
    /**
     * @return mixed
     */
    public function getCategories()
    {
        return Category::where('is_active', 1)
//                       ->orderBy('name', 'asc')
            ->orderByRaw('ISNULL(`order_no`), `order_no` ASC')
            ->get();
    }

    /**
     * @return mixed
     */
    public function getPopularCategories()
    {
        return Category::where('is_active', 1)
            ->where('is_popular', 1)
//            ->orderBy('name', 'asc')
            ->orderByRaw('ISNULL(`order_no`), `order_no` ASC')
            ->get();
    }
}
