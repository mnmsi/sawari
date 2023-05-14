<?php

namespace Modules\Api\Http\Resources\System;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowroomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                 => $this->id,
            'name'               => $this->name,
            'phone'              => $this->phone,
            'address'            => $this->address,
            'country_id'         => $this->country->name,
            'division_id'        => $this->division->name,
            'city_id'            => $this->city->name,
            'area_id'            => $this->area->name,
            'postal_code'        => $this->postal_code,
            'location_image_url' => $this->location_image_url,
            'support_number'     => $this->support_number,
        ];
    }
}
