<?php

namespace Modules\Api\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Api\Http\Traits\Product\FeatureProductTrait;

class UserResource extends JsonResource
{
    use FeatureProductTrait;

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'first_name' => $this->first_name,
            'last_name'  => $this->last_name,
            'name'       => $this->name,
            'email'      => $this->email,
            'phone'      => $this->phone,
            'dob'        => $this->dob,
            'gender'     => $this->gender,
            'avatar'     => $this->avatar,
        ];
    }
}
