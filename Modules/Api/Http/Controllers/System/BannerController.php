<?php

namespace Modules\Api\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\System\Banner;
use Modules\Api\Http\Resources\System\BannerResource;

class BannerController extends Controller
{
    public function banners()
    {
        $banners = Banner::where('is_active', 1)
                         ->get();

        return $this->respondWithSuccessWithData(BannerResource::collection($banners));
    }
}
