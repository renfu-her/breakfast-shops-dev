<?php

namespace App\Filament\Resources\BrandInfoResource\Pages;

use App\Filament\Resources\BrandInfoResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBrandInfo extends CreateRecord
{
    protected static string $resource = BrandInfoResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
} 