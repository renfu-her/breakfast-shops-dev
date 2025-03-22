<?php

namespace App\Filament\Resources\FoodResource\Pages;

use App\Filament\Resources\FoodResource;
use App\Filament\Resources\FoodCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFoods extends ListRecords
{
    protected static string $resource = FoodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('categories')
                ->label('餐點分類')
                ->url(fn () => FoodCategoryResource::getUrl('index'))
                ->icon('heroicon-o-tag'),
        ];
    }
} 