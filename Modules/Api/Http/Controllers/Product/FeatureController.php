<?php

namespace Modules\Api\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
//        if ($token = PersonalAccessToken::findToken($request->bearerToken())) {
//            $user = $token->tokenable;
//            Auth::setUser($user);
//        }
        return $this->respondWithSuccessWithData(
            ProductResource::collection($this->featuredNewBike())
        );
    }

    /**
     * @return JsonResponse
     */
    public function usedBike()
    {
        return $this->respondWithSuccessWithData(
            ProductResource::collection($this->featuredUsedBike())
        );
    }

}
