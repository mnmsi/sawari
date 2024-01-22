<?php

namespace Modules\Api\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Api\Http\Traits\Product\FeatureTrait;
use Modules\Api\Http\Traits\Product\ProductTrait;

class ProductDetailsResource extends JsonResource
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
            'product_code' => $this->product_code,
            'image' => asset('storage/' . $this->image_url),
            'price' => $this->price,
            'discount_rate' => $this->discount_rate,
            'price_after_discount' => $this->calculateDiscountPrice($this->price, $this->discount_rate),
            'in_stock' => $this->total_stock,
            'is_used' => $this->is_used ?? 0,
            'badge' => $this->badge_url ? asset('storage/' . $this->badge_url) : "",
            'brand' => new BrandResource($this->brand),
            'category' => $this->category ? new CategoryResource($this->category) : [],
            'colors' => $this->colors ? ColorResource::collection($this->colors) : [],
            'media' => $this->media ? MediaResource::collection($this->media) : [],
            'specification_categories' => $this->specificationCategories ? SpecificationCategoryResource::collection($this->specificationCategories) : [],
            'description' => $this->description,
            'short_description' => $this->short_description,
            'is_favorite' => $this->is_favorite,
        ];
    }
}
