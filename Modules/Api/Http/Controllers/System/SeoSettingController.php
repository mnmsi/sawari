<?php

namespace Modules\Api\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\System\SeoSetting;
use App\Models\System\SiteSetting;
use Modules\Api\Http\Resources\System\SeoResource;

class SeoSettingController extends Controller
{
    public function seoSettings()
    {
        $data = SeoSetting::select('page_title', 'page_description', 'page_keywords', 'page_url')
            ->get();
        //add this query into html meta tag
        return $this->respondWithSuccessWithData(
            SeoResource::collection($data)
        );
    }
}
