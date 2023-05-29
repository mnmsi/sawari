<?php

    namespace Modules\Api\Http\Resources\SellBike;

    use Illuminate\Http\Resources\Json\JsonResource;
    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\ResourceCollection;

    class BikeResource extends JsonResource
    {
        /**
         * Transform the resource collection into an array.
         *
         * @param \Illuminate\Http\Request
         * @return array
         */
        public function toArray($request): array
        {
            return [
                'id' => $this->id,
                "name" => $this->name,
                'brand_name' => $this->brand->name,
                "image_url" => asset('storage/' . $this->image_url),
            ];
        }
    }
