<?php

namespace Modules\Api\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Api\Http\Resources\Product\BikeCollection;
use Modules\Api\Http\Traits\Product\ProductTrait;
use Modules\Api\Http\Traits\Product\TotalProductCountTrait;

class ProductController extends Controller
{
    use TotalProductCountTrait, ProductTrait;

    public function totalProductType()
    {
        return $this->respondWithSuccessWithData([
            'total_new_bikes'   => $this->totalNewBikes(),
            'total_used_bikes'  => $this->totalUsedBikes(),
            'total_accessories' => $this->totalAccessories(),
        ]);
    }

    public function bikes(Request $request)
    {
        $filterData = [
            'brand_id'      => $request->brand_id,
            'body_type_id'  => $request->body_type_id,
            'category_id'   => $request->category_id,
            'is_used'       => $request->is_used,
            'color'         => $request->color,
            'price'         => $request->price,
            'discount_rate' => $request->discount_rate,
            'search'        => $request->search,
            'sort_by'       => $request->sort_by,
            'sort_type'     => $request->sort_type,
            'per_page'      => $request->per_page,
        ];

        return $this->respondWithSuccessWithData(
            new BikeCollection($this->getBikeProducts($filterData))
        );
    }

}
