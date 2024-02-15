<?php

namespace Modules\Api\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\VideoReview;
use Illuminate\Support\Facades\Cache;
use Modules\Api\Http\Resources\System\VideoReviewResource;


class VideoReviewController extends Controller
{
    public function index()
    {
        $data = Cache::rememberForever('video_reviews', function () {
            $reviews = VideoReview::where('status', 1)
                ->orderByRaw('ISNULL(`order_no`), `order_no` ASC')
                ->get();

            return VideoReviewResource::collection($reviews);
        });

        return $this->respondWithSuccessWithData($data);
    }
}
