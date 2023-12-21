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
            'quantity' => $this->quantity,
            'is_checked' => $this->status,
            'total' => $this->total,
            'product_id' => $this->product_id,
            'shipping_charge' => $this->product->charge ?? 0,
            'product_color_id' => $this->product_color_id,
            'name' => $this->product->name,
            'price' => $this->product->price + $this->productColor->price ?? 0,
            'type' => $this->product->type,
            'discount_rate' => $this->product->discount_rate,
            'price_after_discount' => $this->calculateDiscountPrice($this->product->price,$this->product->discount_rate) + $this->productColor->price ?? 0,
            'total_stock' => $this->productColor->stock,
            'image' => asset('storage/'.$this->product->image_url),
            'color' => $this->productColor->name,
            'color_image' => asset('storage/'.$this->productColor->image_url),
            'color_price' => $this->productColor->price ?? 0,
        ];
    }
}
