<?php

    namespace Modules\Api\Http\Traits\SellBike;
    use App\Models\Sell\SellBike;

    trait SellBikeTrait
    {
        public function getBikeByBrand($brand_id) : object
        {
            return SellBike::where('brand_id', $brand_id)->get();
        }
    }
