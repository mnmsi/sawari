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

        // Set some options - we are passing in a useragent too here for AlphaSMS
        curl_setopt_array($curl, [
            CURLOPT_URL            => 'https://api.sms.net.bd/sendsms',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => [
                'api_key' => config('services.alpha_sms.api_key'), // AlphaSMS API Key
                'msg'     => "This is your IOTAIT otp: $otp", // Message to send with OTP
                'to'      => $phone
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        $response = json_decode($response);

        // Check if the response is successful then return true
        if ($response->error == 0) {
            return true;
        }

        return false;
    }

    public function verifyOtp($phone, $otp)
    {
        // Check if the phone number and otp is valid / it exists in the database
        $phoneVerification = PhoneVerification::where('phone', $phone)
                                              ->where('otp', $otp)
                                              ->first();

        // If the phone number and otp is not valid / not exists in the database then return false
        if (!$phoneVerification) {
            return false;
        }

        // Check if the otp is expired or not and return false if it is expired
        if (now() > $phoneVerification->expires_at) {
            return false;
        }

        // Delete the otp from the database after verification
        $phoneVerification->delete();
        return true;
    }
}
