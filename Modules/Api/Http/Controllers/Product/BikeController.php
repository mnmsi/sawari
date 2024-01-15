<?php

namespace Modules\Api\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
//        dd($request->all());
        // Initialize filter data
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
        if ($token = PersonalAccessToken::findToken($request->bearerToken())) {
            $user = $token->tokenable;
            Auth::setUser($user);
        }

        // Get bike details
        $bikeDetails = $this->getBikeDetails($name);

//            dd($bikeDetails->toArray());

        // Check if bike details is empty
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
        return $this->respondWithSuccessWithData(
            ProductResource::collection(($this->getRelatedBikes()))
        );
    }

    /**
     * @return JsonResponse
     */
    public function bikeBodyTypes()
    {
        return $this->respondWithSuccessWithData(
            $this->getBikeBodyTypes()
        );
    }

    public function scooter(){
        return $this->respondWithSuccessWithData(
            new BikeCollection($this->getScooter())
        );
    }

    public function upcomingBikes(){
        return $this->respondWithSuccessWithData(
            new BikeCollection($this->getUpComingBikes())
        );
    }
}
