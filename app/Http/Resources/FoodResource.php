<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FoodResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'category_id' => $this->category_id,
            'category' => new FoodCategoryResource($this->whenLoaded('category')),
            'images' => FoodImageResource::collection($this->whenLoaded('images')),
            'sort' => $this->sort,
            'is_active' => $this->is_active,
        ];
    }
} 