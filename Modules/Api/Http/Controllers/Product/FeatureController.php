<?php

namespace Modules\Api\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Api\Http\Resources\Product\BikeResource;
use Modules\Api\Http\Traits\Product\FeatureTrait;

class FeatureController extends Controller
{
    use FeatureTrait;

    /**
     * @return JsonResponse
     */
    public function newBike()
    {
        return $this->respondWithSuccessWithData(
            BikeResource::collection($this->featuredNewBike())
        );
    }

    /**
     * @return JsonResponse
     */
    public function usedBike()
    {
        return $this->respondWithSuccessWithData(
            BikeResource::collection($this->featuredUsedBike())
        );
    }

}
