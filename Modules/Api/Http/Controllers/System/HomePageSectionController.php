<?php

namespace Modules\Api\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\System\HomePageSection;
use App\Models\System\SiteSetting;
use Modules\Api\Http\Resources\System\HomePageSectionResource;

class HomePageSectionController extends Controller
{
    public function homePageSections()
    {
        $data = HomePageSection::with('homePageSection.product')
            ->orderBy('section_order')
            ->get();

        return $this->respondWithSuccessWithData(
            HomePageSectionResource::collection($data)
        );
    }
}
