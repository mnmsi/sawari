<?php

namespace Modules\Api\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Product\ProductColor;
use App\Models\System\Showroom;
use Modules\Api\Http\Resources\System\ShowroomResource;

class ColorController extends Controller
{
    public function colors()
    {
        // Get Unique Colors from ProductColor
        $colors = ProductColor::select('name')
                              ->distinct()
                              ->pluck('name');

        // Return response with colors
        return $this->respondWithSuccessWithData($colors);
    }
}
