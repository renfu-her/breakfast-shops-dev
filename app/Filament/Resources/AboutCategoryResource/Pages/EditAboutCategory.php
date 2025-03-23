<?php

namespace App\Filament\Resources\AboutCategoryResource\Pages;

use App\Filament\Resources\AboutCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAboutCategory extends EditRecord
{
    protected static string $resource = AboutCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label('刪除'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
} 