<?php

namespace Modules\Api\Http\Controllers\OTP;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\OtpValidateRequest;
use App\Http\Requests\Auth\SendOtpRequest;
use App\Models\System\Notification;
use App\Models\User\PhoneVerification;
use App\Models\User\User;
use App\Models\VerifiedPhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Modules\Api\Http\Traits\OTP\OtpTrait;

class OtpController extends Controller
{
    // Use OtpTrait for generate and send otp
    use OtpTrait;

    public function sendOtp(SendOtpRequest $request)
    {

//        check if user requesting within 2 minutes

        $lastSent = PhoneVerification::where('phone', $request->phone)->first();

        if ($lastSent) {
            if (now() < $lastSent->expires_at) {
                return $this->respondWithSuccessWithData([
                    'message' => 'OTP already sent! Please wait for 5 minutes.',
                ]);
            }
        }


        // Generate otp
        $otp = $this->generateOtp();
        $message = "Your One-Time-Password for Sawari is: $otp" . "  It will expire after 5 minutes"; // Message to send with OTP

        // Send otp to user phone if send sms is true then update or create phone verification record
        if ($isSendSms = $this->sendSms($request->phone, $message)) {
            PhoneVerification::updateOrCreate([
                'phone' => $request->phone
            ], [
                'phone' => $request->phone,
                'otp' => $otp,
                'expires_at' => now()->addMinutes(5),
            ]);
        }

        // Return response with success status according to send sms
        return $this->respondWithSuccessWithData([
            'message' => "OTP sent successfully.",
            'is_send_sms' => $isSendSms,
            'otp' => $otp,
            'expires_at' => now()->addMinutes(5)->format('Y-m-d H:i:s'),
        ]);
    }


    public function verifyOtp(OtpValidateRequest $request)
    {
        // Find phone verification record by phone and otp
        $phoneVerification = PhoneVerification::where('phone', $request->phone)
            ->where('otp', $request->otp)
            ->first();

        // If phone verification record found then check if it is expired or not
        if ($phoneVerification) {
            if (now() > $phoneVerification->expires_at) {
                // If expired then return response with error status
                return $this->respondError('OTP is expired');
            }

            // Update phone verification record as verified

            VerifiedPhoneNumber::create([
                'phone' => $request->phone,
            ]);

            // If not expired then return response with success status
            return $this->respondWithSuccessWithData([
                'message' => 'OTP verified successfully.',
            ]);
        }

        // If phone verification record not found then return response with error status
        return $this->respondError('OTP is invalid');
    }


}
