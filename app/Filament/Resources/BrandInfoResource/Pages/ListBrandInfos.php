<?php

namespace App\Filament\Resources\BrandInfoResource\Pages;

use App\Filament\Resources\BrandInfoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBrandInfos extends ListRecords
{
    protected static string $resource = BrandInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
} 