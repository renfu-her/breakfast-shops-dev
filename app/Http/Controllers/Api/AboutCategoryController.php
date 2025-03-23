<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AboutCategoryResource;
use App\Http\Resources\BaseResource;
use App\Models\AboutCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AboutCategoryController extends Controller
{
    public function index(): AnonymousResourceCollection|JsonResponse
    {
        try {
            $categories = AboutCategory::with(['children', 'abouts'])
                ->where('is_active', true)
                ->where('parent_id', 0)
                ->orderBy('sort')
                ->get();

            if ($categories->isEmpty()) {
                return BaseResource::error('No categories found', 404);
            }

            return AboutCategoryResource::collection($categories);
        } catch (\Exception $e) {
            return BaseResource::error($e->getMessage(), 500);
        }
    }

    public function show(AboutCategory $category): AboutCategoryResource|JsonResponse
    {
        try {
            if (!$category->is_active) {
                return BaseResource::error('Category not found', 404);
            }

            return new AboutCategoryResource($category->load(['children', 'abouts']));
        } catch (\Exception $e) {
            return BaseResource::error($e->getMessage(), 500);
        }
    }

    public function getChildren(AboutCategory $category): AnonymousResourceCollection|JsonResponse
    {
        try {
            if (!$category->is_active) {
                return BaseResource::error('Category not found', 404);
            }

            $children = $category->children()
                ->where('is_active', true)
                ->orderBy('sort')
                ->get();

            if ($children->isEmpty()) {
                return BaseResource::error('No child categories found', 404);
            }

            return AboutCategoryResource::collection($children);
        } catch (\Exception $e) {
            return BaseResource::error($e->getMessage(), 500);
        }
    }
} 