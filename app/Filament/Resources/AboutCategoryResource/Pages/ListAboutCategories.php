<?php

namespace App\Filament\Resources\AboutCategoryResource\Pages;

use App\Filament\Resources\AboutCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAboutCategories extends ListRecords
{
    protected static string $resource = AboutCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('新增分類'),
        ];
    }
} 