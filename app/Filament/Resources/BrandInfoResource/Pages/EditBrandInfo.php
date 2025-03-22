<?php

namespace App\Filament\Resources\BrandInfoResource\Pages;

use App\Filament\Resources\BrandInfoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBrandInfo extends EditRecord
{
    protected static string $resource = BrandInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
} 