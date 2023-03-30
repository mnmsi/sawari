<?php

namespace Modules\Api\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Api\Http\Resources\Product\BikeCollection;
use Modules\Api\Http\Traits\Product\BikeProductTrait;
use Modules\Api\Http\Traits\Product\TotalProductCountTrait;

class BikeController extends Controller
{
    use BikeProductTrait;

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function bikes(Request $request)
    {
        // Initialize filter data
        $filterData = $this->initializeBikeFilterData($request);

        // Return bike products with pagination and filter data as response
        return $this->respondWithSuccessWithData(
            new BikeCollection($this->getBikeProducts($filterData))
        );
    }

}
