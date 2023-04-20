<?php

namespace Modules\Api\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Api\Http\Requests\Product\ReviewRequest;
use Modules\Api\Http\Resources\Product\ReviewResource;
use Modules\Api\Http\Traits\Product\ReviewTrait;

class ReviewController extends Controller
{
    use ReviewTrait;
    public function review($id){
        return $this->respondWithSuccessWithData(
           ReviewResource::collection($this->getReview($id))
        );
    }
    public function store(ReviewRequest $request){
        $data = $this->storeReview($request->validated());
        return $this->respondWithSuccessWithData(
            ReviewResource::collection($this->getReview($data->product_id))
        );
    }
}
