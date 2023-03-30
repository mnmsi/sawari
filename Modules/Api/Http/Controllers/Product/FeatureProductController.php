<?php

namespace Modules\Api\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Api\Http\Resources\Product\BikeListResource;
use Modules\Api\Http\Traits\Product\FeatureProductTrait;

class FeatureProductController extends Controller
{
    use FeatureProductTrait;

    /**
     * @return JsonResponse
     */
    public function newBike()
    {
        return $this->respondWithSuccessWithData(
            BikeListResource::collection($this->featuredNewBike())
        );
    }

    /**
     * @return JsonResponse
     */
    public function usedBike()
    {
        return $this->respondWithSuccessWithData(
            BikeListResource::collection($this->featuredUsedBike())
        );
    }

}
