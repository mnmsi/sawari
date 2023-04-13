<?php

namespace Modules\Api\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Api\Http\Resources\Product\AccessoryDetailsResource;
use Modules\Api\Http\Resources\Product\AccessoryResource;
use Modules\Api\Http\Traits\Product\AccessoryTrait;

class AccessoryController extends Controller
{
    use AccessoryTrait;

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function accessories(Request $request)
    {
        $filters = $this->initializeAccessoryFilterData($request);

        return $this->respondWithSuccessWithData(
            AccessoryResource::collection($this->getAccessories($filters))
        );
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function details($id)
    {
        // Get bike details
        $accessoryDetails = $this->getAccessoryDetails($id);

        // Check if bike details is empty
        if (empty($accessoryDetails)) {
            return $this->respondWithNotFound();
        }

        // Return bike details as response
        return $this->respondWithSuccessWithData(
            new AccessoryDetailsResource($accessoryDetails)
        );
    }

    /**
     * @return JsonResponse
     */
    public function relatedAccessories()
    {
        return $this->respondWithSuccessWithData(
            AccessoryResource::collection(($this->getRelatedAccessories()))
        );
    }

    /**
     * @return JsonResponse
     */
    public function featuredAccessories()
    {
        return $this->respondWithSuccessWithData(
            AccessoryResource::collection(($this->getFeaturedAccessories()))
        );
    }
}
