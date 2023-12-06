<?php

namespace Modules\Api\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User\PhoneVerification;
use App\Models\User\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Modules\Api\Http\Requests\Auth\AuthenticateUserRequest;
use Modules\Api\Http\Requests\Auth\RegisterUserRequest;
use Modules\Api\Http\Requests\Auth\ResetPasswordRequest;
use Modules\Api\Http\Services\FileService;
use Modules\Api\Http\Traits\OTP\OtpTrait;

class ApiAuthController extends Controller
{
    use OtpTrait;

    public function login(Request $request)
    {
//        dd($request->all());
        // Authentication for requested phone and password
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            // Get user for current request which is authenticated
            $user = Auth::user();

            // Create token for current requested user
            $token = $user->createToken('user-auth');

            // Return response token and user with success status
            return $this->respondWithSuccess([
                'token' => $token->plainTextToken,
                'user' => $user,
            ]);

        } // If authentication fails
        else {
            return $this->respondUnAuthenticated();
        }
    }

    public function register(RegisterUserRequest $request)
    {
        $request->merge([
            'phone' => '+880 0 0 0 ' . rand(1000000, 9999999),
        ]);
        $reqData = $request->all(); // Get request data

        // Check if request has file
        if ($request->hasFile('avatar')) {
            // Merge avatar with request
            $reqData['avatar'] = FileService::storeOrUpdateFile($request->avatar, 'avatar'); // Store file in public disk
        }

        // Create user
        $user = User::create($reqData);

        // Create token for current requested user
        $token = $user->createToken('user-auth');

        // Return response token and user with success status
        return $this->respondWithSuccess([
            'token' => $token->plainTextToken,
            'user' => $user,
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

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'phone' => 'required|exists:users,phone',
        ]);

        $user = User::where('phone', $request->phone)->first();
        if ($user) {
            $otp = $this->generateOtp();
            $message = "This is your IOTAIT otp: $otp"; // Message to send with OTP
            // Send otp to user phone if send sms is true then update or create phone verification record
            if ($isSendSms = $this->sendSms($request->phone, $message)) {
                PhoneVerification::updateOrCreate([
                    'phone' => $request->phone
                ], [
                    'phone' => $request->phone,
                    'otp' => $otp,
                    'expires_at' => now()->addMinutes(30),
                ]);
            }
            return $this->respondWithSuccessStatus($isSendSms);
        } else {
            return $this->respondNotFound('User not found');
        }

    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        User::where('phone', $request->phone)->update([
            'password' => $request->password
        ]);
        return $this->respondWithSuccessStatusWithMsg(['message' => 'Password updated successfully']);
    }
}
