<?php

    namespace Modules\Api\Http\Resources\User;

    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;
    use Modules\Api\Http\Traits\Product\FeatureTrait;

    class UserAddressResource extends JsonResource
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
                'id' => $this->id,
                'name' => $this->name,
                'phone' => $this->phone,
                'address' => $this->address,
                'division' => $this->division->name,
                'division_id' => $this->division->id,
                'city' => $this->city->name,
                'city_id' => $this->city->id,
                'area' => $this->area->name,
                'area_id' => $this->area->id,
                'is_default' => $this->is_default,
            ];
        }
    }
