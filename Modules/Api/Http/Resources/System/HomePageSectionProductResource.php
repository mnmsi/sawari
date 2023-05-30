<?php

namespace Modules\Api\Http\Resources\System;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Api\Http\Resources\Product\AccessoryCollection;
use Modules\Api\Http\Resources\Product\BikeCollection;
use Modules\Api\Http\Resources\Product\ProductResource;

class HomePageSectionProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return ProductResource
     */
    public function toArray($request)
    {
        return new ProductResource($this->product);
    }
}
