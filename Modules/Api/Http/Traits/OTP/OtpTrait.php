<?php

namespace Modules\Api\Http\Traits\OTP;

use App\Models\User\PhoneVerification;

trait OtpTrait
{
    public function generateOTP()
    {
        return rand(100000, 999999);
    }

    public function sendSms($phone, $otp)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL            => 'https://api.sms.net.bd/sendsms',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => [
                'api_key' => config('services.alpha_sms.api_key'),
                'msg'     => "This is your IOTAIT otp: $otp",
                'to'      => $phone
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        $response = json_decode($response);

        if ($response->error == 0) {
            return true;
        }

        return false;
    }

    public function verifyOtp($phone, $otp)
    {
        $phoneVerification = PhoneVerification::where('phone', $phone)
                                              ->where('otp', $otp)
                                              ->first();

        if (!$phoneVerification) {
            return false;
        }

        if (now() > $phoneVerification->expires_at) {
            return false;
        }

        $phoneVerification->delete();
        return true;
    }
}
