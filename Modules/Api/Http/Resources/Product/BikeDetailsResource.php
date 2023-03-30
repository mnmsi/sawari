<?php

namespace Modules\Api\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Api\Http\Traits\Product\FeatureTrait;

class BikeDetailsResource extends JsonResource
{
    use FeatureTrait;

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                   => $this->id,
            'name'                 => $this->name,
            'price'                => $this->price,
            'discount_rate'        => $this->discount_rate,
            'price_after_discount' => $this->calculateDiscountPrice($this->price, $this->discount_rate),
            'in_stock'             => $this->total_stock,
            'is_used'              => $this->is_used,
            'brand'                => new BrandResource($this->brand),
            'colors'               => ColorResource::collection($this->colors),
            'media'                => MediaResource::collection($this->media),
            'specifications'       => SpecificationResource::collection($this->specifications->where('is_key_feature', 0)),
            'summary'              => SpecificationResource::collection($this->specifications->where('is_key_feature', 1)),
            'description'          => $this->description,
        ];
    }
}
