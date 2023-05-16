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
            'showroom_id' => 'required_if:delivery_option_id,2|integer|exists:App\Models\System\Showroom,id',
            'user_address_id' => 'required|exists:App\Models\User\UserAddress,id',
            'discount_rate' => 'required|numeric',
            'shipping_amount' => 'required|numeric',
            'subtotal_price' => 'required|numeric',
            'total_price' => 'required|numeric',
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
