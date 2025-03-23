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
            'parent_id' => $this->parent_id,
            'name' => $this->name,
            'sort' => $this->sort,
            'is_active' => $this->is_active,
            'parent_name' => $this->parent_name,
            'has_children' => $this->has_children,
            'children' => AboutCategoryResource::collection($this->whenLoaded('children')),
            'abouts' => AboutResource::collection($this->whenLoaded('abouts')),
        ];
    }
} 