<?php

namespace Modules\Api\Http\Resources\System;

use Illuminate\Http\Resources\Json\JsonResource;

class SeoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title'      => '<title name="name" content="' . $this->page_title . '"/>',
            'description'   => '<meta name="description" content="' . $this->page_description . '"/>',
            'page_keywords' => '<meta name="keywords" content="' . $this->page_keywords . '"/>',
            'page_url' => '<meta name="url" content="' . $this->page_url . '"/>',
        ];
    }
}
