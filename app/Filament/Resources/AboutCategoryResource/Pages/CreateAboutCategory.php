<?php

namespace App\Filament\Resources\AboutCategoryResource\Pages;

use App\Filament\Resources\AboutCategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAboutCategory extends CreateRecord
{
    protected static string $resource = AboutCategoryResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
} 