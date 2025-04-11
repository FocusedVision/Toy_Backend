<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\Brand\DefaultResource as BrandResource;
use App\Http\Resources\Tag\DefaultResource as TagResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DefaultView extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'brand' => new BrandResource($this->whenLoaded('brand')),
            'external_link' => $this->external_link_proxy,
            'image' => $this->image,
            'background' => $this->background,
            'grid_image' => $this->grid_image,
            'brand_image' => $this->brand_image,
            'model' => $this->model,
            'is_in_user_products' => $this->whenNotNull($this->isInUserProducts),
            'is_liked' => $this->whenNotNull($this->isLiked),
            'is_y_axis_locked' => $this->is_y_axis_locked,
            'default_zoom_level' => $this->default_zoom_level,
            'has_info_block' => $this->has_info_block,
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            'created_at' => $this->created_at->timestamp,
            'updated_at' => $this->updated_at->timestamp,
        ];
    }
}
