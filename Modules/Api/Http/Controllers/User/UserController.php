<?php

namespace Modules\Api\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SendOtpRequest;
use App\Models\User\PhoneVerification;
use App\Models\User\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Modules\Api\Http\Requests\Auth\AuthenticateUserRequest;
use Modules\Api\Http\Requests\Auth\RegisterUserRequest;
use Modules\Api\Http\Traits\OTP\OtpTrait;

class UserController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function user(): JsonResponse
    {
        // Return response with user data
        return $this->respondWithSuccessWithData(Auth::user());
    }
}
