<?php

namespace Modules\Api\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\System\Testimonial;
use Modules\Api\Http\Resources\System\TestimonialResource;

class TestimonialController extends Controller
{
    public function testimonials()
    {
        // Get all active testimonials
        $testimonials = Testimonial::where('is_active', 1)
                                   ->get();

        // Return response with testimonials
        return $this->respondWithSuccessWithData(TestimonialResource::collection($testimonials));
    }
}
