<?php

    namespace App\Http\Requests\Auth;

    use Illuminate\Foundation\Http\FormRequest;

    class OtpValidateRequest extends FormRequest
    {
        /**
         * Determine if the user is authorized to make this request.
         */

        /**
         * Get the validation rules that apply to the request.
         *
         * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
         */
        public function rules(): array
        {
            return [
                'phone' => 'required|string|exists:phone_verifications,phone',
                'otp' => 'required|numeric|digits:6|exists:phone_verifications,otp',
            ];
        }

        protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
        {
            throw new \Illuminate\Http\Exceptions\HttpResponseException(
                response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first(),
                    'data' => null,
                ], 422)
            );
        }


    }
