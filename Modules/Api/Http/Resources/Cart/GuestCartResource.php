<?php

namespace Modules\Api\Http\Resources\Cart;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Api\Http\Traits\Product\ProductTrait;

class GuestCartResource extends JsonResource
{
    use ProductTrait;

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'quantity' => $this->quantity,
            'is_checked' => $this->status,
            'total' => $this->calTotal($this->quantity, $this->calculateDiscountPrice($this->product->price, $this->product->discount_rate)),
            'product_id' => $this->product_id,
            'shipping_charge' => $this->product->charge ?? 0,
            'product_color_id' => $this->product_color_id,
            'name' => $this->product->name,
            'price' => $this->product->price,
            'type' => $this->product->type,
            'discount_rate' => $this->product->discount_rate,
            'price_after_discount' => $this->calculateDiscountPrice($this->product->price, $this->product->discount_rate),
            'total_stock' => $this->productColor->stock,
            'image' => asset('storage/' . $this->product->image_url),
            'color' => $this->productColor->name,
            'color_image' => asset('storage/' . $this->productColor->image_url),
        ];
    }

    private function calTotal($q, $p): float|int
    {
        return ($q * $p);
    }
}
