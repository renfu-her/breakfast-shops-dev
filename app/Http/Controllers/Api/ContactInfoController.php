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
                return BaseResource::error('No contact info found', 404);
            }

            return ContactInfoResource::collection($contactInfos);
        } catch (\Exception $e) {
            return BaseResource::error($e->getMessage(), 500);
        }
    }

    public function show(ContactInfo $contactInfo): ContactInfoResource|JsonResponse
    {
        try {
            if (!$contactInfo->is_active) {
                return BaseResource::error('Contact info not found', 404);
            }

            return new ContactInfoResource($contactInfo);
        } catch (\Exception $e) {
            return BaseResource::error($e->getMessage(), 500);
        }
    }
} 