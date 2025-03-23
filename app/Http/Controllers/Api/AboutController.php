<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AboutResource;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AboutController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $abouts = About::with(['category.parent'])
            ->where('is_active', true)
            ->get();

        return AboutResource::collection($abouts);
    }

    public function show(About $about): AboutResource
    {
        return new AboutResource($about->load('category.parent'));
    }

    public function getByCategory(int $categoryId): AnonymousResourceCollection
    {
        $abouts = About::with(['category.parent'])
            ->where('category_id', $categoryId)
            ->where('is_active', true)
            ->get();

        return AboutResource::collection($abouts);
    }
} 