<?php

namespace Modules\Api\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Api\Http\Resources\Product\BrandResource;
use Modules\Api\Http\Traits\Product\ProductBrandTrait;

class BrandController extends Controller
{
    use ProductBrandTrait;

    /**
     * @return JsonResponse
     */
    public function bikeBrands()
    {
        return $this->respondWithSuccessWithData(
            BrandResource::collection($this->getBikeBrands())
        );
    }

    /**
     * @return JsonResponse
     */
    public function popularBikeBrands()
    {
        return $this->respondWithSuccessWithData(
            BrandResource::collection($this->getPopularBikeBrands())
        );
    }

    /**
     * @return JsonResponse
     */
    public function accessoryBrands()
    {
        return $this->respondWithSuccessWithData(
            BrandResource::collection($this->getAccessoryBrands())
        );
    }

    /**
     * @return JsonResponse
     */
    public function popularAccessoryBrands()
    {
        return $this->respondWithSuccessWithData(
            BrandResource::collection($this->getPopularAccessoryBrands())
        );
    }
}
