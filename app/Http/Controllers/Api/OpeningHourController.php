<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OpeningHourResource;
use App\Http\Resources\BaseResource;
use App\Models\OpeningHour;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OpeningHourController extends Controller
{
    public function index(): AnonymousResourceCollection|JsonResponse
    {
        try {
            $openingHours = OpeningHour::query()
                ->where('is_active', true)
                ->orderBy('sort')
                ->get();

            if ($openingHours->isEmpty()) {
                return BaseResource::empty('No opening hours found');
            }

            return OpeningHourResource::collection($openingHours);
        } catch (\Exception $e) {
            return BaseResource::error($e->getMessage());
        }
    }

    public function show(OpeningHour $openingHour): OpeningHourResource|JsonResponse
    {
        try {
            if (!$openingHour->is_active) {
                return BaseResource::empty('Opening hour not found');
            }

            return new OpeningHourResource($openingHour);
        } catch (\Exception $e) {
            return BaseResource::error($e->getMessage());
        }
    }
} 