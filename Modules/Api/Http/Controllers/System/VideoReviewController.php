<?php

namespace Modules\Api\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\VideoReview;
use Modules\Api\Http\Resources\System\VideoReviewResource;


class VideoReviewController extends Controller
{
    public function index()
    {
        $data = VideoReview::all();
        return $this->respondWithSuccessWithData(
            VideoReviewResource::collection($data),
        );
    }
}
