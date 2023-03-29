<?php

namespace Modules\Api\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Modules\Api\Http\Requests\Auth\AuthenticateUserRequest;
use Modules\Api\Http\Requests\Auth\RegisterUserRequest;

class ApiAuthController extends Controller
{
    public function login(AuthenticateUserRequest $request)
    {
        // Authentication for requested phone and password
        if (Auth::attempt($request->only('phone', 'password'))) {

            // Get user for current request which is authenticated
            $user = Auth::user();

            // Create token for current requested user
            $token = $user->createToken('user-auth');

            // Return response token and user with success status
            return $this->respondWithSuccess([
                'token' => $token->plainTextToken,
                'user'  => $user,
            ]);

        } // If authentication fails
        else {
            return $this->respondUnAuthenticated();
        }
    }

    public function register(RegisterUserRequest $request)
    {
        // Check if request has file
        if ($request->hasFile('avatar')) {
            // Merge avatar with request
            $request->merge([
                'avatar' => $request->avatar->store('avatars') // Store file in public disk
            ]);
        }

        // Create user
        $user = User::create($request->all());

        // Create token for current requested user
        $token = $user->createToken('user-auth');

        // Return response token and user with success status
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
        // Session flush for current user
        Session::flush();

        // Delete current token for current user
        Auth::user()->currentAccessToken()->delete();

        // Return response with success status
        return $this->respondWithSuccessStatusWithMsg('Logged out successfully');
    }
}
