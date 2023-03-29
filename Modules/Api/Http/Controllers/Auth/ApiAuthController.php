<?php

namespace Modules\Api\Http\Controllers\Auth;

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

class ApiAuthController extends Controller
{
    use OtpTrait;

    public function login(AuthenticateUserRequest $request)
    {
        if (Auth::attempt($request->only('phone', 'password'))) {
            $user  = Auth::user();
            $token = $user->createToken('user-auth');

            return $this->respondWithSuccess([
                'token' => $token->plainTextToken,
                'user'  => $user,
            ]);

        } else {
            return $this->respondUnAuthenticated();
        }
    }

    public function register(RegisterUserRequest $request)
    {
        if ($request->hasFile('avatar')) {
            $request->merge([
                'avatar' => $request->avatar->store('avatars')
            ]);
        }

        $user  = User::create($request->validated());
        $token = $user->createToken('user-auth');

        return $this->respondWithSuccess([
            'token' => $token->plainTextToken,
            'user'  => $user,
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        $user = Auth::user()->token();
        $user->revoke();

        return response()->json([
            'message' => 'Logged out successfully'
        ], Response::HTTP_OK);
    }
}
