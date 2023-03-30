<?php

namespace Modules\Api\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Api\Http\Traits\Product\ProductTrait;

class ProductCategoryController extends Controller
{
    use ProductTrait;

    /**
     * @return JsonResponse
     */
    public function categories()
    {
        return $this->respondWithSuccessWithData($this->getCategories());
    }

    /**
     * @return JsonResponse
     */
    public function popularCategories()
    {
        return $this->respondWithSuccessWithData($this->getPopularCategories());
    }
}
