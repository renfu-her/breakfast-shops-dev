<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FoodCategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'foods' => FoodResource::collection($this->whenLoaded('foods')),
            'sort' => $this->sort,
            'is_active' => $this->is_active,
        ];
    }
} 