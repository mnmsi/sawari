<?php

namespace Modules\Api\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Product\ProductColor;
use App\Models\System\Showroom;
use Illuminate\Support\Facades\Cache;
use Modules\Api\Http\Resources\System\ShowroomResource;

class ColorController extends Controller
{
    public function colors()
    {
        // Get Unique Colors from ProductColor
        $colors = Cache::rememberForever('product_colors', function () {
            return ProductColor::select('name')
                ->distinct()
                ->pluck('name');
        });

        // Return response with colors
        return $this->respondWithSuccessWithData($colors);
    }
}
