<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Modules\Api\Http\Traits\Response\ApiResponseHelper;

class SendOtpRequest extends FormRequest
{
    use ApiResponseHelper;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'phone' => 'required|string|unique:App\Models\VerifiedPhoneNumber,phone',
        ];
    }

    public function messages(): array
    {
        return [
            'phone.unique' => 'This phone number is already verified,no need to send otp',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->respondFailedValidation($validator->errors()->first())
        );
    }
}
