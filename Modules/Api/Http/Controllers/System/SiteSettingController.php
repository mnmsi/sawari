<?php

namespace Modules\Api\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\System\SiteSetting;

class SiteSettingController extends Controller
{
    public function siteSettings()
    {
        $data = SiteSetting::select('name', 'email', 'phone', 'header_logo', 'footer_logo', 'fav_icon', 'dark_fav_icon', 'facebook_url', 'instagram_url', 'twitter_url', 'youtube_url', 'linkedin_url', 'welcome_popup_image', 'section_order')
            ->first();

        $data['status'] = true;
        $data['welcome_popup_image'] = isset($data['welcome_popup_image']) ?asset('storage/' . $data['welcome_popup_image']) : null;
        $data['header_logo'] = isset($data['header_logo']) ? asset('storage/' . $data['header_logo']) : null;
        $data['footer_logo'] = isset($data['footer_logo']) ? asset('storage/' . $data['footer_logo']) : null;
        $data['fav_icon'] = isset($data['fav_icon']) ? asset('storage/' . $data['fav_icon']) : '';
        $data['dark_fav_icon'] = isset($data['dark_fav_icon']) ? asset('storage/' . $data['dark_fav_icon']) : '';
        $data['section_order'] = !empty($data["section_order"]) ? array_values(json_decode($data["section_order"], true)) : [];

        return $data;
    }
}
