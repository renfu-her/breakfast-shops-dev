<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OpeningHourResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'day_of_week' => $this->day_of_week,
            'opening_time' => $this->opening_time,
            'closing_time' => $this->closing_time,
            'is_closed' => $this->is_closed,
            'sort' => $this->sort,
            'is_active' => $this->is_active,
        ];
    }
} 