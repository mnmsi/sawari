<?php

namespace Modules\Api\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Api\Http\Resources\Product\AccessoryCollection;
use Modules\Api\Http\Resources\Product\AccessoryDetailsResource;
use Modules\Api\Http\Resources\Product\AccessoryResource;
use Modules\Api\Http\Resources\Product\ProductDetailsResource;
use Modules\Api\Http\Resources\Product\ProductResource;
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
            new AccessoryCollection($this->getAccessories($filters))
        );
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function details($name)
    {
        // Get bike details
        $accessoryDetails = $this->getAccessoryDetails($name);

        // Check if bike details is empty
        if (empty($accessoryDetails)) {
            return $this->respondWithNotFound();
        }

        // Return bike details as response
        return $this->respondWithSuccessWithData(
            new ProductDetailsResource($accessoryDetails)
        );
    }

    /**
     * @return JsonResponse
     */
    public function relatedAccessories()
    {
        return $this->respondWithSuccessWithData(
            ProductResource::collection(($this->getRelatedAccessories()))
        );
    }

    /**
     * @return JsonResponse
     */
    public function featuredAccessories()
    {
        return $this->respondWithSuccessWithData(
            ProductResource::collection(($this->getFeaturedAccessories()))
        );
    }
}
