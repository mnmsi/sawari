<?php

namespace Modules\Api\Http\Requests\Sell;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Modules\Api\Http\Traits\Response\ApiResponseHelper;

class SellBikeRequest extends FormRequest
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
            'name'=> 'required|string',
            'phone'=> 'required|string',
            'bike_id' => 'required|numeric|exists:sell_bikes,id',
            'city_id' => 'required|numeric|exists:cities,id',
            'area_id' => 'required|numeric|exists:areas,id',
            'registration_year' => 'required|string',
            'registration_duration' => 'required|string',
            'registration_zone' => 'required|string',
            'registration_series' => 'required|string',
            'color' => 'required|string',
            'mileage_range' => 'required|string',
            'bought_from_us' => 'required|string',
            'ownership_status' => 'required|string',
            'engine_condition' => 'required|string',
            'accident_history' => 'required|string',
            'images' => 'required|array|min:1',

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        // Throw response exception with failed validation message
        throw new HttpResponseException(
            $this->respondFailedValidation($validator->errors()->first())
        );
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

}
