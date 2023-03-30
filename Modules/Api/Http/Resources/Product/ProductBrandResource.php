<?php

namespace Modules\Api\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Api\Http\Traits\Product\FeatureProductTrait;

class ProductBrandResource extends JsonResource
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
            'name'                 => $this->name,
            'image_url'                => $this->image_url,
            'discount_rate'        => $this->discount_rate,
            'price_after_discount' => $this->calculateDiscountPrice($this->price, $this->discount_rate),
        ];
    }
}
