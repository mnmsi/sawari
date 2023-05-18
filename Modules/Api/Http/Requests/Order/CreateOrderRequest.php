<?php

namespace Modules\Api\Http\Requests\Order;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Modules\Api\Http\Traits\Response\ApiResponseHelper;

class CreateOrderRequest extends FormRequest
{
    use ApiResponseHelper;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cart_id'=>'required|array|exists:App\Models\Order\Cart,id',
            'delivery_option_id' => 'required|integer|exists:App\Models\System\DeliveryOption,id',
            'payment_method_id' => 'required|integer|exists:App\Models\System\PaymentMethod,id',
        ];
    }

//    add charge based on shipping address name

    public function withValidator($validator)
    {

    }


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->respondFailedValidation($validator->errors()->first())
        );
    }
}
