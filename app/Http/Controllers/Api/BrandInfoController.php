<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BrandInfoResource;
use App\Http\Resources\BaseResource;
use App\Models\BrandInfo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BrandInfoController extends Controller
{
    public function index(): AnonymousResourceCollection|JsonResponse
    {
        try {
            $brandInfos = BrandInfo::query()
                ->where('is_active', true)
                ->orderBy('sort')
                ->get();

            if ($brandInfos->isEmpty()) {
                return BaseResource::empty('No brand information found');
            }

            return BrandInfoResource::collection($brandInfos);
        } catch (\Exception $e) {
            return BaseResource::error($e->getMessage());
        }
    }

    public function show(BrandInfo $brandInfo): BrandInfoResource|JsonResponse
    {
        try {
            if (!$brandInfo->is_active) {
                return BaseResource::empty('Brand information not found');
            }

            return new BrandInfoResource($brandInfo);
        } catch (\Exception $e) {
            return BaseResource::error($e->getMessage());
        }
    }
} 