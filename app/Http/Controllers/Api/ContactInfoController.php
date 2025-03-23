<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContactInfoResource;
use App\Http\Resources\BaseResource;
use App\Models\ContactInfo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ContactInfoController extends Controller
{
    public function index(): AnonymousResourceCollection|JsonResponse
    {
        try {
            $contactInfos = ContactInfo::query()
                ->where('is_active', true)
                ->orderBy('sort')
                ->get();

            if ($contactInfos->isEmpty()) {
                return BaseResource::empty('找不到聯絡資訊');
            }

            return ContactInfoResource::collection($contactInfos);
        } catch (\Exception $e) {
            return BaseResource::error($e->getMessage());
        }
    }

    public function show(ContactInfo $contactInfo): ContactInfoResource|JsonResponse
    {
        try {
            if (!$contactInfo->is_active) {
                return BaseResource::empty('找不到此聯絡資訊');
            }

            return new ContactInfoResource($contactInfo);
        } catch (\Exception $e) {
            return BaseResource::error($e->getMessage());
        }
    }
} 