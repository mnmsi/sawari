<?php

namespace Modules\Api\Http\Controllers\OTP;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SendOtpRequest;
use App\Models\User\PhoneVerification;
use Modules\Api\Http\Traits\OTP\OtpTrait;

class OtpController extends Controller
{
    use OtpTrait;

    public function sendOtp(SendOtpRequest $request)
    {
        $otp = $this->generateOtp();

        if ($isSendSms = $this->sendSms($request->phone, $otp)) {
            PhoneVerification::updateOrCreate([
                'phone' => $request->phone
            ], [
                'phone'      => $request->phone,
                'otp'        => $otp,
                'expires_at' => now()->addMinutes(5),
            ]);
        }

        return $this->respondWithSuccessStatus($isSendSms);
    }
}
