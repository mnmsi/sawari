<?php

namespace Modules\Api\Http\Controllers\SellBike;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Modules\Api\Http\Requests\Sell\SellBikeRequest;
use Modules\Api\Http\Resources\SellBike\BikeResource;
use Modules\Api\Http\Traits\SellBike\SellBikeTrait;

class SellBikeController extends Controller
{
    use SellBikeTrait;

    public function bikeByBrand($brand_id)
    {
        $data = Cache::rememberForever('sell_bikes.' . $brand_id, function () use ($brand_id) {
            return BikeResource::collection($this->getBikeByBrand($brand_id));
        });

        return $this->respondWithSuccessWithData($data);
    }

    public function store(SellBikeRequest $request)
    {
        $this->storeSellBike($request);
        return $this->respondWithSuccess([
            'message' => 'Bike sell request has been submitted successfully'
        ]);
    }
}
