<?php

namespace Modules\Api\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\System\Banner;
use Illuminate\Support\Facades\Cache;
use Modules\Api\Http\Resources\System\BannerResource;

class BannerController extends Controller
{
    public function banners()
    {
        // Cache the data forever
        $data = Cache::rememberForever('banners', function () {
            // Get all active banners
            $banners = Banner::where('is_active', 1)
                ->orderByRaw('ISNULL(`order_no`), `order_no` ASC')
                ->get();

            return BannerResource::collection($banners);
        });

        // Return response with banners
        return $this->respondWithSuccessWithData($data);
    }
}
