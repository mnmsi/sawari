<?php

namespace Modules\Api\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SendOtpRequest;
use App\Models\User\PhoneVerification;
use Modules\Api\Http\Traits\OTP\OtpTrait;
use Modules\Api\Http\Traits\Product\TotalProductCountTrait;

class ProductController extends Controller
{
    use TotalProductCountTrait;

    public function totalProductType()
    {
        return $this->respondWithSuccessWithData([
            'total_new_bikes'   => $this->totalNewBikes(),
            'total_used_bikes'  => $this->totalUsedBikes(),
            'total_accessories' => $this->totalAccessories(),
        ]);
    }
}
