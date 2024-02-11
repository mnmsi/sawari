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
        $data = $this->featuredNewBike();
        return $this->respondWithSuccessWithData(
            ProductResource::collection($data)
        );
//        $cacheKey = 'featured_new_bike';
//        if (Cache::has($cacheKey)) {
//            $data = Cache::get($cacheKey);
//        } else {
//            $data = $this->featuredNewBike();
//            Cache::put($cacheKey, $data, now()->addMinutes(2400));
//        }
//        return $this->respondWithSuccessWithData(
//            ProductResource::collection($data)
//        );
    }

    /**
     * @return JsonResponse
     */
    public function usedBike()
    {
        $data = $this->featuredUsedBike();
        return $this->respondWithSuccessWithData(
            ProductResource::collection($data)
        );
//        $cacheKey = 'featured_used_bike';
//        if (Cache::has($cacheKey)) {
//            $data = Cache::get($cacheKey);
//        } else {
//            $data = $this->featuredUsedBike();
//            Cache::put($cacheKey, $data, now()->addMinutes(2400));
//        }
//        return $this->respondWithSuccessWithData(
//            ProductResource::collection($data)
//        );
    }

}
