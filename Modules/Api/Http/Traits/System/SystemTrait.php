<?php

    namespace Modules\Api\Http\Traits\System;

    use App\Models\System\Division;
    use App\Models\System\City;
    use App\Models\System\Area;

    trait SystemTrait
    {
        public function getDivision()
        {
            return Division::all();
        }

        public function getCityByDivision($division_id = null)
        {
            if ($division_id) {
                return City::where('division_id', $division_id)->get();
            } else {
                return City::all();
            }
        }


        public function getAreaByCity($city_id = null)
        {
            if ($city_id) {
                return Area::where('city_id', $city_id)->get();
            } else {
                return Area::all();
            }
        }
    }
