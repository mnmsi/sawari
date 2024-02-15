<?php

namespace Modules\Api\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\System\Testimonial;
use Illuminate\Support\Facades\Cache;
use Modules\Api\Http\Resources\System\TestimonialResource;

class TestimonialController extends Controller
{
    public function testimonials()
    {
        // Cache the data forever
        $data = Cache::rememberForever('testimonials', function () {
            $testimonials = Testimonial::where('is_active', 1)
                ->orderByRaw('ISNULL(`order_no`), `order_no` ASC')
                ->get();

            return TestimonialResource::collection($testimonials);
        });

        // Return response with testimonials
        return $this->respondWithSuccessWithData($data);
    }
}
