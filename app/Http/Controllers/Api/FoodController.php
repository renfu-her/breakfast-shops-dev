<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FoodResource;
use App\Http\Resources\BaseResource;
use App\Models\Food;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FoodController extends Controller
{
    public function index(): AnonymousResourceCollection|JsonResponse
    {
        try {
            $foods = Food::with(['category', 'images'])
                ->where('is_active', true)
                ->orderBy('sort')
                ->get();

            if ($foods->isEmpty()) {
                return BaseResource::empty('No food items found');
            }

            return FoodResource::collection($foods);
        } catch (\Exception $e) {
            return BaseResource::error($e->getMessage());
        }
    }

    public function show(Food $food): FoodResource|JsonResponse
    {
        try {
            if (!$food->is_active) {
                return BaseResource::empty('Food item not found');
            }

            return new FoodResource($food->load(['category', 'images']));
        } catch (\Exception $e) {
            return BaseResource::error($e->getMessage());
        }
    }

    public function getByCategory(int $categoryId): AnonymousResourceCollection|JsonResponse
    {
        try {
            $foods = Food::with(['category', 'images'])
                ->where('category_id', $categoryId)
                ->where('is_active', true)
                ->orderBy('sort')
                ->get();

            if ($foods->isEmpty()) {
                return BaseResource::empty('No food items found in this category');
            }

            return FoodResource::collection($foods);
        } catch (\Exception $e) {
            return BaseResource::error($e->getMessage());
        }
    }
} 