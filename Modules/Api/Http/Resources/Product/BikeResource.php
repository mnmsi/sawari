<?php

namespace Modules\Api\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Api\Http\Traits\Product\FeatureTrait;
use Modules\Api\Http\Traits\Product\ProductTrait;

class BikeResource extends JsonResource
{
    use ProductTrait;

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
            'image_url'            => $this->media->where('type', 'image')->first()->url ?? $this->image_url,
            'is_used'              => $this->is_used,
            'colors'               => $this->colors->pluck('name'),
        ];
    }
}
