<?php

namespace Modules\Api\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\System\Banner;
use Modules\Api\Http\Resources\System\BannerResource;

class BannerController extends Controller
{
    public function banners()
    {
        // Get all active banners
        $banners = Banner::where('is_active', 1)
                         ->get();

        // Return response with banners
        return $this->respondWithSuccessWithData(BannerResource::collection($banners));
    }
}
