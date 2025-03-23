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
                return BaseResource::empty('No about categories found');
            }

            return AboutCategoryResource::collection($categories);
        } catch (\Exception $e) {
            return BaseResource::error($e->getMessage());
        }
    }

    public function show(AboutCategory $category): AboutCategoryResource|JsonResponse
    {
        try {
            if (!$category->is_active) {
                return BaseResource::empty('About category not found');
            }

            return new AboutCategoryResource($category->load(['children', 'abouts']));
        } catch (\Exception $e) {
            return BaseResource::error($e->getMessage());
        }
    }

    public function getChildren(AboutCategory $category): AnonymousResourceCollection|JsonResponse
    {
        try {
            if (!$category->is_active) {
                return BaseResource::empty('About category not found');
            }

            $children = $category->children()
                ->where('is_active', true)
                ->orderBy('sort')
                ->get();

            if ($children->isEmpty()) {
                return BaseResource::empty('No child categories found');
            }

            return AboutCategoryResource::collection($children);
        } catch (\Exception $e) {
            return BaseResource::error($e->getMessage());
        }
    }
} 