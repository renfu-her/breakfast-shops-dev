<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BannerResource;
use App\Models\Banner;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BannerController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $banners = Banner::query()
            ->where('is_active', true)
            ->orderBy('sort')
            ->get();

        return BannerResource::collection($banners);
    }

    public function show(Banner $banner): BannerResource
    {
        return new BannerResource($banner);
    }
} 