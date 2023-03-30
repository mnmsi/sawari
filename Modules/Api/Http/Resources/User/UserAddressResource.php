<?php

namespace Modules\Api\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Api\Http\Traits\Product\FeatureProductTrait;

class UserAddressResource extends JsonResource
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
            'id'         => $this->id,
            'name'       => $this->name,
            'phone'      => $this->phone,
            'address'    => $this->address,
            'division'   => $this->division->name,
            'city'       => $this->city->name,
            'area'       => $this->area->name,
            'is_default' => $this->is_default,
        ];
    }
}
