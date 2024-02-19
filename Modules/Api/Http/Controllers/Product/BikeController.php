<?php

namespace Modules\Api\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\PersonalAccessToken;
use Modules\Api\Http\Resources\Product\BikeCollection;
use Modules\Api\Http\Resources\Product\BikeDetailsResource;
use Modules\Api\Http\Resources\Product\BikeResource;
use Modules\Api\Http\Resources\Product\ProductDetailsResource;
use Modules\Api\Http\Resources\Product\ProductResource;
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
        $filterData = $this->initializeBikeFilterData($request);
        $data = Cache::remember(json_encode($request->all()) . json_encode($filterData), config('cache.stores.redis.lifetime'), function () use ($filterData) {
            return new BikeCollection($this->getBikeProducts($filterData));
        });

        return $this->respondWithSuccessWithData($data);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function details(Request $request, $name)
    {
        if ($token = PersonalAccessToken::findToken($request->bearerToken())) {
            $user = $token->tokenable;
            Auth::setUser($user);
        }
        $product = Cache::rememberForever('products.' . $name, function () use ($name) {
            return new ProductDetailsResource($this->getBikeDetails($name));
        });

        return $this->respondWithSuccessWithData($product);

    }

    /**
     * @return JsonResponse
     */
    public function relatedBikes()
    {
        $bikeDetails = Cache::remember('related_bikes', config('cache.stores.redis.lifetime'), function () {
            return ProductResource::collection($this->getRelatedBikes());
        });
        return $this->respondWithSuccessWithData($bikeDetails);
    }

    /**
     * @return JsonResponse
     */
    public function bikeBodyTypes()
    {
        $bikeBodyTypes = Cache::remember('bike_body_types', config('cache.stores.redis.lifetime'), function () {
            return $this->getBikeBodyTypes();
        });

        return $this->respondWithSuccessWithData(
            $bikeBodyTypes
        );
    }

    public function scooter()
    {
        $scooter = Cache::remember('products.scooter', config('cache.stores.redis.lifetime'), function () {
            return new BikeCollection($this->getScooter());

        });
        return $this->respondWithSuccessWithData($scooter);
    }

    public function upcomingBikes()
    {
        $upcomingBikes = Cache::remember('products.upcoming_bikes', config('cache.stores.redis.lifetime'), function () {
            return new BikeCollection($this->getUpComingBikes());
        });
        return $this->respondWithSuccessWithData($upcomingBikes);
    }
}
