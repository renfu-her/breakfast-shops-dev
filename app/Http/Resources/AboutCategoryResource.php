<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AboutCategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'parent_id' => $this->parent_id,
            'parent' => new AboutCategoryResource($this->whenLoaded('parent')),
            'children' => AboutCategoryResource::collection($this->whenLoaded('children')),
            'abouts' => AboutResource::collection($this->whenLoaded('abouts')),
            'sort' => $this->sort,
            'is_active' => $this->is_active,
        ];
    }
} 