<?php

namespace Modules\Api\Http\Resources\System;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowroomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name'               => $this->name,
            'phone'              => $this->phone,
            'address'            => $this->address,
            'country_id'         => $this->country_id,
            'division_id'        => $this->division_id,
            'city_id'            => $this->city_id,
            'area_id'            => $this->area_id,
            'postal_code'        => $this->postal_code,
            'location_image_url' => $this->location_image_url,
            'support_number'     => $this->support_number,
        ];
    }
}
