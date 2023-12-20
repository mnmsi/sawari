<?php

namespace Modules\Api\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Api\Http\Traits\Product\FeatureTrait;
use Modules\Api\Http\Traits\Product\ProductTrait;

class ProductResource extends JsonResource
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
            'id' => $this->id,
            'type' => $this->type,
            'name' => $this->name,
            'slug' => $this->slug,
            'price' => $this->price,
            'discount_rate' => $this->discount_rate,
            'price_after_discount' => $this->calculateDiscountPrice($this->price, $this->discount_rate),
            'image_url' => str_contains($this->image_url, 'https') ? $this->image_url : asset('storage/' . $this->image_url),
            'colors' => $this->colors->pluck('name', 'price', 'stock', 'id') ?? [],
            'is_favorite' => $this->is_favorite,
            $this->mergeWhen($this->type == 'bike', [
                'is_used' => $this->is_used ?? 0,
            ]),
        ];
    }
}
