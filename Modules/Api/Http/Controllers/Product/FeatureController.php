<?php

namespace Modules\Api\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\PersonalAccessToken;
use Modules\Api\Http\Resources\Product\BikeResource;
use Modules\Api\Http\Resources\Product\ProductResource;
use Modules\Api\Http\Traits\Product\FeatureTrait;

class FeatureController extends Controller
{
    use FeatureTrait;

    /**
     * @return JsonResponse
     */
    public function newBike(Request $request)
    {
        $data = Cache::remember('products.new_bike', config('cache.stores.redis.lifetime'), function () {
            return ProductResource::collection($this->featuredNewBike());
        });

        return $this->respondWithSuccessWithData($data);
    }

    /**
     * @return JsonResponse
     */
    public function usedBike()
    {
        $data = Cache::remember('products.used_bike', config('cache.stores.redis.lifetime'), function () {
            return ProductResource::collection($this->featuredUsedBike());
        });

        return $this->respondWithSuccessWithData($data);
    }

}
