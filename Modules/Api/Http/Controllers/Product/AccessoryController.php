<?php

namespace Modules\Api\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Modules\Api\Http\Resources\Product\AccessoryCollection;
use Modules\Api\Http\Resources\Product\AccessoryDetailsResource;
use Modules\Api\Http\Resources\Product\AccessoryResource;
use Modules\Api\Http\Resources\Product\BikeCollection;
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
        $filterData = $this->initializeAccessoryFilterData($request);
        $data       = Cache::remember(json_encode($request->all()) . json_encode($filterData), config('cache.stores.redis.lifetime'), function () use ($filterData) {
            return new AccessoryCollection($this->getAccessories($filterData));
        });

        return $this->respondWithSuccessWithData($data);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function details($name)
    {
        $product = Cache::rememberForever('products.' . $name, function () use ($name) {
            return new ProductDetailsResource($this->getAccessoryDetails($name));
        });

        return $this->respondWithSuccessWithData($product);
    }

    /**
     * @return JsonResponse
     */
    public function relatedAccessories()
    {
        $product = Cache::remember('products.related_accessory', config('cache.stores.redis.lifetime'), function () {
            return ProductResource::collection(($this->getRelatedAccessories()));
        });

        return $this->respondWithSuccessWithData($product);
    }

    /**
     * @return JsonResponse
     */
    public function featuredAccessories()
    {
        $product = Cache::remember('products.featured_accessory', config('cache.stores.redis.lifetime'), function () {
            return ProductResource::collection(($this->getFeaturedAccessories()));
        });

        return $this->respondWithSuccessWithData($product);
    }
}
