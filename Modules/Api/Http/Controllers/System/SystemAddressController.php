<?php

    namespace Modules\Api\Http\Controllers\System;

    use Illuminate\Contracts\Support\Renderable;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;
    use App\Models\System\Division;
    use Illuminate\Http\JsonResponse;
    use Modules\Api\Http\Traits\System\SystemTrait;

    class SystemAddressController extends Controller
    {
        use SystemTrait;

        /**
         * Display a listing of the resource.
         * @return JsonResponse
         */
        public function division()
        {
            return $this->respondWithSuccessWithData(
                $this->getDivision()
            );
        }

        /**
         * Display a listing of the resource.
         * @return JsonResponse
         */
        public function city($division_id = null)
        {
            return $this->respondWithSuccessWithData(
                $this->getCityByDivision($division_id)
            );
        }

        /**
         * Display a listing of the resource.
         * @return JsonResponse
         */
        public function area($city_id = null)
        {
            return $this->respondWithSuccessWithData(
                $this->getAreaByCity($city_id)
            );
        }
    }
