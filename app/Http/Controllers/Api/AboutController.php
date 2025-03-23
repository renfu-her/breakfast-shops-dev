<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AboutResource;
use App\Http\Resources\BaseResource;
use App\Models\About;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AboutController extends Controller
{
    public function index(): AnonymousResourceCollection|JsonResponse
    {
        try {
            $abouts = About::with(['category.parent'])
                ->where('is_active', true)
                ->orderBy('sort')
                ->get();

            if ($abouts->isEmpty()) {
                return BaseResource::empty('No about data found');
            }

            return AboutResource::collection($abouts);
        } catch (\Exception $e) {
            return BaseResource::error($e->getMessage());
        }
    }

    public function show(About $about): AboutResource|JsonResponse
    {
        try {
            if (!$about->is_active) {
                return BaseResource::empty('About data not found');
            }

            return new AboutResource($about->load('category.parent'));
        } catch (\Exception $e) {
            return BaseResource::error($e->getMessage());
        }
    }

    public function getByCategory(int $categoryId): AnonymousResourceCollection|JsonResponse
    {
        try {
            $abouts = About::with(['category.parent'])
                ->where('category_id', $categoryId)
                ->where('is_active', true)
                ->orderBy('sort')
                ->get();

            if ($abouts->isEmpty()) {
                return BaseResource::empty('No about data found in this category');
            }

            return AboutResource::collection($abouts);
        } catch (\Exception $e) {
            return BaseResource::error($e->getMessage());
        }
    }
} 