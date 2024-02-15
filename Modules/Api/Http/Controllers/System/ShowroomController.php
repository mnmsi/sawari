<?php

namespace Modules\Api\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\System\Showroom;
use Illuminate\Support\Facades\Cache;
use Modules\Api\Http\Resources\System\ShowroomResource;

class ShowroomController extends Controller
{
    public function showrooms()
    {
        // Cache the data forever
        $data = Cache::rememberForever('showrooms', function () {
            // Get all active showrooms
            $showrooms = Showroom::where('is_active', 1)
                ->orderByRaw('ISNULL(`order_no`), `order_no` ASC')
                ->get();

            return ShowroomResource::collection($showrooms);
        });

        // Return response with showrooms
        return $this->respondWithSuccessWithData($data);
    }
}
