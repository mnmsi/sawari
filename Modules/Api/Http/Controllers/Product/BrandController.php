<?php

namespace Modules\Api\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Modules\Api\Http\Resources\Product\BrandCollection;
use Modules\Api\Http\Resources\Product\BrandResource;
use Modules\Api\Http\Traits\Product\BrandTrait;

class BrandController extends Controller
{
    use BrandTrait;

    /**
     * @return JsonResponse
     */
    public function bikeBrands()
    {
        // Cache the brands forever
        $data = Cache::rememberForever('brands', function () {
            return new BrandCollection($this->getBikeBrands());
        });

        return $this->respondWithSuccessWithData($data);
    }

    /**
     * @return JsonResponse
     */
    public function popularBikeBrands()
    {
        // Cache the popular brands forever
        $data = Cache::rememberForever('brands.popular', function () {
            return BrandResource::collection($this->getPopularBikeBrands());
        });

        return $this->respondWithSuccessWithData($data);
    }

    /**
     * @return JsonResponse
     */
    public function accessoryBrands()
    {
        return $this->respondWithSuccessWithData(
            new BrandCollection($this->getAccessoryBrands())
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

    /**
     * @param $id
     * @return JsonResponse
     */
    public function categoryBrands($id)
    {
        return $this->respondWithSuccessWithData(
            BrandResource::collection($this->getCategoryBrands($id))
        );
    }
}
