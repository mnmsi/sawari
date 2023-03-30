<?php

namespace Modules\Api\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Api\Http\Traits\Product\TotalProductCountTrait;

class ProductController extends Controller
{
    use TotalProductCountTrait;

    /**
     * @return JsonResponse
     */
    public function totalProductType()
    {
        return $this->respondWithSuccessWithData([
            'total_new_bikes'   => $this->totalNewBikes(),
            'total_used_bikes'  => $this->totalUsedBikes(),
            'total_accessories' => $this->totalAccessories(),
        ]);
    }
}
