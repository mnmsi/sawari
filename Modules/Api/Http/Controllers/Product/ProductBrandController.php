<?php

namespace Modules\Api\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SendOtpRequest;
use App\Models\User\PhoneVerification;
use Illuminate\Http\JsonResponse;
use Modules\Api\Http\Resources\Product\BrandResource;
use Modules\Api\Http\Traits\OTP\OtpTrait;
use Modules\Api\Http\Traits\Product\ProductBrandTrait;
use Modules\Api\Http\Traits\Product\ProductTrait;
use Modules\Api\Http\Traits\Product\TotalProductCountTrait;

class ProductBrandController extends Controller
{
    use ProductBrandTrait;

    /**
     * @return JsonResponse
     */
    public function bikeBrands()
    {
        return $this->respondWithSuccessWithData(
            BrandResource::collection($this->getBikeBrands())
        );
    }

    /**
     * @return JsonResponse
     */
    public function popularBikeBrands()
    {
        return $this->respondWithSuccessWithData(
            BrandResource::collection($this->getPopularBikeBrands())
        );
    }
}
