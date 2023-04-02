<?php

namespace Modules\Api\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
}
