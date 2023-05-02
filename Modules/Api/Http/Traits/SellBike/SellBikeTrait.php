<?php

namespace Modules\Api\Http\Traits\SellBike;
use App\Models\Sell\BikeSellRequest;
use App\Models\Sell\SellBike;
use Modules\Api\Http\Requests\Sell\SellBikeRequest;

trait SellBikeTrait
{
    public function getBikeByBrand($brand_id) : object
    {
        return SellBike::where('brand_id', $brand_id)->get();
    }

    public function storeSellBike($request)
    {


//            $file = $request->file('bike_image');

        $bike_images = [];
        foreach ($request->images as $image) {
            $bike_images[] = $image->store('bike_images', 'public');
        }
//            dd($bike_images);
        $request->merge([
            'bike_image' => json_encode($bike_images),
            'user_id' => auth()->user()->id,
        ]);
        return BikeSellRequest::create($request->all());
    }
}





