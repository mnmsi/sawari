<?php

namespace Modules\Api\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Modules\Api\Http\Traits\OTP\OtpTrait;
use Modules\Api\Http\Traits\Response\ApiResponseHelper;

class RegisterUserRequest extends FormRequest
{
    use OtpTrait, ApiResponseHelper;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|string|max:190',
            'last_name' => 'required|string|max:190',
//            'phone' => 'required|string|unique:App\Models\User\User,phone',
//            'otp' => 'required|numeric|digits:6',
            'email' => 'nullable | string | email | max:190 | unique:App\Models\User\User,email',
            'date_of_birth' => 'nullable | date',
            'gender' => 'nullable | in:male,female,other',
            'avatar' => 'nullable | image | mimes:jpeg,png,jpg,gif,svg | max:2048',
            'password' => ['required', 'string', 'min:6'],
        ];
    }

//    protected function passedValidation()
//    {
//        // Verify OTP if it is not valid throw response exception
//        if (!$this->verifyOtp($this->phone, $this->otp)) {
//            throw new HttpResponseException(
//                $this->respondFailedValidation('Invalid OTP')
//            );
//        }
//
//        // Hash password and merge it with request
//        $this->merge([
//            'password' => Hash::make($this->password),
//        ]);
//    }

    protected function failedValidation(Validator $validator)
    {
        // Throw response exception with failed validation message
        throw new HttpResponseException(
            $this->respondFailedValidation($validator->errors()->first())
        );
    }
}
