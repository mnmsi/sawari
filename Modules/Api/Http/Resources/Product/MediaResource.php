<?php

namespace Modules\Api\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Api\Http\Traits\Product\FeatureTrait;

class MediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        if ($this->type == 'youtube') {
            $this->type = 'video';
        }
        if(empty($this->thumbnail_url)){
            $this->thumbnail_url = $this->url;
        }
        return [
            'id' => $this->id,
            'color' => $this->color->name,
            'type' => $this->type,
            'url' => $this->url,
            'thumbnail_url' =>$this->thumbnail_url ?? $this->url,
        ];
    }
}
