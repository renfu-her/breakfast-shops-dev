<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BrandInfoResource;
use App\Models\BrandInfo;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BrandInfoController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $brandInfos = BrandInfo::query()
            ->where('is_active', true)
            ->orderBy('sort')
            ->get();

        return BrandInfoResource::collection($brandInfos);
    }

    public function show(BrandInfo $brandInfo): BrandInfoResource
    {
        return new BrandInfoResource($brandInfo);
    }
} 