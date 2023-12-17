<?php

namespace Modules\Api\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Api\Http\Traits\Product\ProductCountTrait;

class ProductController extends Controller
{
    use ProductCountTrait;

    /**
     * @return JsonResponse
     */
    public function totalProductType()
    {
        return $this->respondWithSuccessWithData([
            'total_new_bikes' => $this->totalNewBikes(),
            'total_used_bikes' => $this->totalUsedBikes(),
            'total_accessories' => $this->totalAccessories(),
            'total_shops' => $this->totalShops(),
        ]);
    }

    public function getProductSuggestion(Request $request)
    {
        return $this->respondWithSuccessWithData($this->getSearchSuggestions($request->name));
    }
}
