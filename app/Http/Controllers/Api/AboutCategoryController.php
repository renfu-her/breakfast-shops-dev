<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AboutCategoryResource;
use App\Models\AboutCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AboutCategoryController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $categories = AboutCategory::with(['children', 'abouts'])
            ->where('parent_id', 0)
            ->where('is_active', true)
            ->get();

        return AboutCategoryResource::collection($categories);
    }

    public function show(AboutCategory $category): AboutCategoryResource
    {
        return new AboutCategoryResource($category->load(['children', 'abouts']));
    }

    public function getChildren(AboutCategory $category): AnonymousResourceCollection
    {
        $children = $category->children()
            ->with('abouts')
            ->where('is_active', true)
            ->get();

        return AboutCategoryResource::collection($children);
    }
} 