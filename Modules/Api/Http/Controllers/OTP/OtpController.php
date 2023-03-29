<?php

namespace Modules\Api\Http\Controllers\OTP;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SendOtpRequest;
use App\Models\User\PhoneVerification;
use Modules\Api\Http\Traits\OTP\OtpTrait;

class OtpController extends Controller
{
    // Use OtpTrait for generate and send otp
    use OtpTrait;

    public function sendOtp(SendOtpRequest $request)
    {
        // Generate otp
        $otp = $this->generateOtp();

        // Send otp to user phone if send sms is true then update or create phone verification record
        if ($isSendSms = $this->sendSms($request->phone, $otp)) {
            PhoneVerification::updateOrCreate([
                'phone' => $request->phone
            ], [
                'phone'      => $request->phone,
                'otp'        => $otp,
                'expires_at' => now()->addMinutes(5),
            ]);
        }

        // Return response with success status according to send sms
        return $this->respondWithSuccessStatus($isSendSms);
    }
}
