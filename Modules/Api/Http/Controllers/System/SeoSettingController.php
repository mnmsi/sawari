<?php

namespace Modules\Api\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\System\SeoSetting;
use App\Models\System\SiteSetting;
use Illuminate\Support\Facades\Cache;

class SeoSettingController extends Controller
{
    public function seoSettings()
    {
        // Cache the data forever
        $data = Cache::rememberForever('seo_settings', function () {
            SeoSetting::select('page_title', 'page_description', 'page_keywords', 'page_url')
                ->get();
        });

        return $this->respondWithSuccessWithData($data);
    }
}
