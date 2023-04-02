<?php

namespace Modules\Api\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Api\Http\Resources\Product\BikeCollection;
use Modules\Api\Http\Resources\Product\BikeDetailsResource;
use Modules\Api\Http\Resources\Product\BikeResource;
use Modules\Api\Http\Traits\Product\BikeTrait;
use Modules\Api\Http\Traits\Product\ProductCountTrait;

class BikeController extends Controller
{
    use BikeTrait;

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

    /**
     * @param $id
     * @return JsonResponse
     */
    public function details($id)
    {
        // Get bike details
        $bikeDetails = $this->getBikeDetails($id);

        // Check if bike details is empty
        if (empty($bikeDetails)) {
            return $this->respondWithNotFound();
        }

        // Return bike details as response
        return $this->respondWithSuccessWithData(
            new BikeDetailsResource($bikeDetails)
        );
    }

    /**
     * @return JsonResponse
     */
    public function relatedBikes()
    {
        return $this->respondWithSuccessWithData(
            BikeResource::collection(($this->getRelatedBikes()))
        );
    }

    /**
     * @return JsonResponse
     */
    public function bikeBodyTypes()
    {
        return $this->respondWithSuccessWithData(
            $this->getBikeBodyTypes()
        );
    }
}
