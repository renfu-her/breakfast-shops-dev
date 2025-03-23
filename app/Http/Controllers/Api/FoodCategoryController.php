<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FoodCategoryResource;
use App\Models\FoodCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FoodCategoryController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $categories = FoodCategory::with('foods')
            ->where('is_active', true)
            ->get();

        return FoodCategoryResource::collection($categories);
    }

    public function show(FoodCategory $category): FoodCategoryResource
    {
        return new FoodCategoryResource($category->load('foods'));
    }
} 