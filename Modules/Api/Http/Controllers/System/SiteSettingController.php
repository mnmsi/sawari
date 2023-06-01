<?php

namespace Modules\Api\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\System\SiteSetting;

class SiteSettingController extends Controller
{
    public function siteSettings()
    {
        $data = SiteSetting::select('name', 'email', 'phone', 'header_logo', 'footer_logo', 'fav_icon', 'dark_fav_icon', 'facebook_url', 'instagram_url', 'twitter_url', 'youtube_url', 'linkedin_url')
            ->first();

        $data['status'] = true;
        $data['header_logo'] = asset('storage/' . $data['header_logo']);
        $data['footer_logo'] = asset('storage/' . $data['footer_logo']);
        $data['fav_icon'] = asset('storage/' . $data['fav_icon']);
        $data['dark_fav_icon'] = asset('storage/' . $data['dark_fav_icon']);

        return $data;
    }
}
