<?php

namespace Modules\Api\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Api\Http\Traits\Product\FeatureTrait;

class AccessoryDetailsResource extends JsonResource
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
            'brand'                => new BrandResource($this->brand),
            'category'             => new CategoryResource($this->category),
            'colors'               => ColorResource::collection($this->colors),
            'media'                => MediaResource::collection($this->media),
            'short_description'    => $this->short_description,
            'description'          => $this->description,
        ];
    }
}
