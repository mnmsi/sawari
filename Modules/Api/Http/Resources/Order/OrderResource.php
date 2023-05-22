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
            'total' => $this->calculateDiscountPrice($this->price,$this->discount_rate),
            'product_color_id' => $this->colors->first()->id,
            'discount_rate' => $this->discount_rate,
            'price_after_discount' => $this->calculateDiscountPrice($this->price,$this->discount_rate),
            'total_stock' => $this->colors->first()->stock,
            'image' => $this->image_url,
            'color' => $this->colors->first()->name,
            'color_image' => $this->colors->first()->image_url,
        ];
    }
}
