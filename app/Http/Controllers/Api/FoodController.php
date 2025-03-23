<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FoodResource;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FoodController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $foods = Food::with(['category', 'images'])
            ->where('is_active', true)
            ->get();

        return FoodResource::collection($foods);
    }

    public function show(Food $food): FoodResource
    {
        return new FoodResource($food->load(['category', 'images']));
    }

    public function getByCategory(int $categoryId): AnonymousResourceCollection
    {
        $foods = Food::with(['category', 'images'])
            ->where('food_category_id', $categoryId)
            ->where('is_active', true)
            ->get();

        return FoodResource::collection($foods);
    }
} 