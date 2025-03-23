<?php

namespace App\Filament\Resources\FoodResource\Pages;

use App\Filament\Resources\FoodResource;
use App\Filament\Resources\FoodCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;

class ListFoods extends ListRecords
{
    protected static string $resource = FoodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('categories')
                ->label('餐點分類')
                ->url(FoodCategoryResource::getUrl('index'))
                ->icon('heroicon-o-tag'),
            Actions\CreateAction::make()
                ->label('新增餐點'),
        ];
    }
} 