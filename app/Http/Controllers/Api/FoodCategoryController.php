<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FoodCategoryResource;
use App\Http\Resources\BaseResource;
use App\Models\FoodCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FoodCategoryController extends Controller
{
    public function index(): AnonymousResourceCollection|JsonResponse
    {
        try {
            $categories = FoodCategory::with('foods')
                ->where('is_active', true)
                ->orderBy('sort')
                ->get();

            if ($categories->isEmpty()) {
                return BaseResource::error('No categories found', 404);
            }

            return FoodCategoryResource::collection($categories);
        } catch (\Exception $e) {
            return BaseResource::error($e->getMessage(), 500);
        }
    }

    public function show(FoodCategory $category): FoodCategoryResource|JsonResponse
    {
        try {
            if (!$category->is_active) {
                return BaseResource::error('Category not found', 404);
            }

            return new FoodCategoryResource($category->load('foods'));
        } catch (\Exception $e) {
            return BaseResource::error($e->getMessage(), 500);
        }
    }
} 