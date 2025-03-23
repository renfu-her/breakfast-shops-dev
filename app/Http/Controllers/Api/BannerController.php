<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BannerResource;
use App\Http\Resources\BaseResource;
use App\Models\Banner;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BannerController extends Controller
{
    public function index(): AnonymousResourceCollection|JsonResponse
    {
        try {
            $banners = Banner::query()
                ->where('is_active', true)
                ->orderBy('sort')
                ->get();

            if ($banners->isEmpty()) {
                return BaseResource::error('No banners found', 404);
            }

            return BannerResource::collection($banners);
        } catch (\Exception $e) {
            return BaseResource::error($e->getMessage(), 500);
        }
    }

    public function show(Banner $banner): BannerResource|JsonResponse
    {
        try {
            if (!$banner->is_active) {
                return BaseResource::error('Banner not found', 404);
            }

            return new BannerResource($banner);
        } catch (\Exception $e) {
            return BaseResource::error($e->getMessage(), 500);
        }
    }
} 