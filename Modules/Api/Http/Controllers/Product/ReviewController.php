<?php

namespace Modules\Api\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Api\Http\Requests\Product\ReviewRequest;
use Modules\Api\Http\Resources\Product\ReviewResource;
use Modules\Api\Http\Traits\Product\ReviewTrait;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    use ReviewTrait;
    public function review($id)
    {
        return $this->respondWithSuccess(
            [
                'data' =>  ReviewResource::collection($this->getReview($id)),
                'user_id' => $this->getReview($id)->pluck('user_id'),
            ]

        );
    }
    public function store(ReviewRequest $request)
    {
        $data = $this->storeReview($request->validated());
        return Response()->json([
            'status' => 'success',
            'message' => 'Review added successfully',
        ], 200);
    }
}
