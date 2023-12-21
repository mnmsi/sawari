<?php

namespace Modules\Api\Http\Resources\Order;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Api\Http\Resources\Product\ColorResource;
use Modules\Api\Http\Traits\Product\ProductTrait;

class OrderResource extends JsonResource
{
    use ProductTrait;

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price'=> $this->price,
            'quantity' => 1,
            'total' => $this->calculateDiscountPrice($this->price,$this->discount_rate) + $this->colors->first()->price,
            'product_color_id' => $this->colors->first()->id,
            'discount_rate' => $this->discount_rate,
            'price_after_discount' => $this->calculateDiscountPrice($this->price,$this->discount_rate) + $this->colors->first()->price,
            'total_stock' => $this->colors->first()->stock,
            'image' => asset('storage/'.$this->image_url),
            'color' => $this->colors->first()->name,
            'color_image' => asset('storage/'.$this->colors->first()->image_url),
            'color_price' => $this->colors->first()->price,
        ];
    }
}
