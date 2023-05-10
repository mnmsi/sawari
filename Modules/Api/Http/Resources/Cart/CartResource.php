<?php

namespace Modules\Api\Http\Resources\Cart;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Api\Http\Traits\Product\ProductTrait;

class CartResource extends JsonResource
{
    use ProductTrait;
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
            'name' => $this->product->name,
            'price' => $this->product->price,
            'count' => $this->count(),
            'type' => $this->product->type,
            'discount_rate' => $this->product->discount_rate,
            'price_after_discount' => $this->calculateDiscountPrice($this->product->price,$this->product->discount_rate),
            'total_stock' => $this->productColor->stock,
            'image' => $this->product->image_url,
            'color' => $this->productColor->name,
            'color_image' => $this->productColor->image_url,

        ];
    }
}
