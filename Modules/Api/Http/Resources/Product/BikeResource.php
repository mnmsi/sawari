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
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type, // 'bike' or 'part
            'slug' => $this->slug,
            'price' => $this->price,
            'discount_rate' => $this->discount_rate,
            'price_after_discount' => $this->calculateDiscountPrice($this->price, $this->discount_rate),
            'image_url' => str_contains($this->image_url, 'https') ? $this->image_url : asset('storage/' . $this->image_url),
            'is_used' => $this->is_used,
            'is_favorite' => $this->is_favorite,
            'colors' => $this->colors->pluck('name', 'id', 'price', 'stock'),
            'is_stock_out' => $this->colors->sum('stock') == 0,
        ];
    }
}
