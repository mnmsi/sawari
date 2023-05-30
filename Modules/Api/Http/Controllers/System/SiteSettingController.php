<?php

namespace Modules\Api\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\System\SiteSetting;

class SiteSettingController extends Controller
{
    public function siteSettings()
    {
        $data = SiteSetting::select('name', 'email', 'phone', 'header_logo', 'footer_logo', 'fav_icon', 'facebook_url', 'instagram_url', 'twitter_url', 'youtube_url', 'linkedin_url', 'facebook_logo', 'instagram_logo', 'twitter_logo', 'youtube_logo', 'linkedin_logo')
            ->first();

        $data['status'] = true;

        return $data;
    }
}
