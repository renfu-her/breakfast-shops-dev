<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AboutResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'content' => $this->content,
            'category_id' => $this->category_id,
            'category' => new AboutCategoryResource($this->whenLoaded('category')),
            'sort' => $this->sort,
            'is_active' => $this->is_active,
        ];
    }
} 