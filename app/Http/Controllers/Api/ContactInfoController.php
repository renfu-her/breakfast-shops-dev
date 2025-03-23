<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContactInfoResource;
use App\Models\ContactInfo;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ContactInfoController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $contactInfos = ContactInfo::query()
            ->where('is_active', true)
            ->orderBy('sort')
            ->get();

        return ContactInfoResource::collection($contactInfos);
    }

    public function show(ContactInfo $contactInfo): ContactInfoResource
    {
        return new ContactInfoResource($contactInfo);
    }
} 