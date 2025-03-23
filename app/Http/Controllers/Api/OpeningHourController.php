<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OpeningHourResource;
use App\Models\OpeningHour;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OpeningHourController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $openingHours = OpeningHour::query()
            ->where('is_active', true)
            ->orderBy('sort')
            ->get();

        return OpeningHourResource::collection($openingHours);
    }

    public function show(OpeningHour $openingHour): OpeningHourResource
    {
        return new OpeningHourResource($openingHour);
    }
} 