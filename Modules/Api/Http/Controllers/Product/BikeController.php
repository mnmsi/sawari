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
        // Return bike products with pagination and filter data as response
        return $this->respondWithSuccessWithData(
            new BikeCollection($this->getBikeProducts($filterData))
        );
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function details(Request $request, $name)
    {
      $bikeDetails = $this->getBikeDetails($name);
//      dd($bikeDetails->toArray());
        return $this->respondWithSuccessWithData(
            new ProductDetailsResource($bikeDetails)
        );
        if ($token = PersonalAccessToken::findToken($request->bearerToken())) {
            $user = $token->tokenable;
            Auth::setUser($user);
        }
        $cacheKey = 'bike_details_' . $name;
        if (Cache::has($cacheKey)) {
            $bikeDetails = Cache::get($cacheKey);
        } else {
            $bikeDetails = $this->getBikeDetails($name);
            Cache::put($cacheKey, $bikeDetails, now()->addMinutes(2400));
        }
        if (empty($bikeDetails)) {
            return $this->respondNotFound("Not Found");
        }
        // Return bike details as response
        return $this->respondWithSuccessWithData(
            new ProductDetailsResource($bikeDetails)
        );
    }

    /**
     * @return JsonResponse
     */
    public function relatedBikes()
    {
        $cacheKey = 'related_bikes';
        if (Cache::has($cacheKey)) {
            $bikeDetails = Cache::get($cacheKey);
        } else {
            $bikeDetails = $this->getRelatedBikes();
            Cache::put($cacheKey, $bikeDetails, now()->addMinutes(2));
        }
        return $this->respondWithSuccessWithData(
            ProductResource::collection($bikeDetails)
        );
    }

    /**
     * @return JsonResponse
     */
    public function bikeBodyTypes()
    {
        $cacheKey = 'bike_body_types';
        if (Cache::has($cacheKey)) {
            $bikeDetails = Cache::get($cacheKey);
        } else {
            $bikeDetails = $this->getBikeBodyTypes();
            Cache::put($cacheKey, $bikeDetails, now()->addMinutes(2400));
        }
        return $this->respondWithSuccessWithData(
            $bikeDetails
        );

    }

    public function scooter()
    {
        $cacheKey = 'scooter';
        if (Cache::has($cacheKey)) {
            $bikeDetails = Cache::get($cacheKey);
        } else {
            $bikeDetails = $this->getScooter();
            Cache::put($cacheKey, $bikeDetails, now()->addMinutes(2400));
        }
        return $this->respondWithSuccessWithData(
            new BikeCollection($bikeDetails)
        );
    }

    public function upcomingBikes()
    {
        $cacheKey = 'upcoming_bikes';
        if (Cache::has($cacheKey)) {
            $bikeDetails = Cache::get($cacheKey);
        } else {
            $bikeDetails = $this->getUpComingBikes();
            Cache::put($cacheKey, $bikeDetails, now()->addMinutes(2400));
        }

        return $this->respondWithSuccessWithData(
            new BikeCollection($bikeDetails)
        );
    }
}
