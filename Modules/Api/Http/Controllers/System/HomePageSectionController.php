<?php

namespace Modules\Api\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\System\HomePageSection;
use App\Models\System\SiteSetting;
use Illuminate\Support\Facades\Cache;
use Modules\Api\Http\Resources\System\HomePageSectionResource;

class HomePageSectionController extends Controller
{
    public function homePageSections()
    {
        $data = Cache::rememberForever('home_page_sections', function () {
            $homePageSection =HomePageSection::with('homePageSection.product')
                ->orderBy('section_order')
                ->get();

            return HomePageSectionResource::collection($homePageSection);
        });

        return $this->respondWithSuccessWithData($data);
    }
}
