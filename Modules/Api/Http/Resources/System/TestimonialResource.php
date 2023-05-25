<?php

namespace Modules\Api\Http\Resources\System;

use Illuminate\Http\Resources\Json\JsonResource;

class TestimonialResource extends JsonResource
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
            'id'        => $this->id,
            'name'      => $this->name,
            'address'   => $this->address,
            'note'      => $this->note,
            'rate'      => $this->rate,
            'image_url' => asset('storage/' . $this->image_url),
        ];
    }
}
