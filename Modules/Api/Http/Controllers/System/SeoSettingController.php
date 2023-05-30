<?php

namespace Modules\Api\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\System\SeoSetting;
use App\Models\System\SiteSetting;

class SeoSettingController extends Controller
{
    public function seoSettings()
    {
        return $this->respondWithSuccessWithData(
            SeoSetting::select('page_title', 'page_description', 'page_keywords', 'page_url')
                ->get());
    }
}
