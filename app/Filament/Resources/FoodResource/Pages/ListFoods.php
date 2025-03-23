<?php

namespace App\Filament\Resources\FoodResource\Pages;

use App\Filament\Resources\FoodResource;
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
                ->url(FoodResource::getUrl('index', ['activeTab' => 'categories']))
                ->icon('heroicon-o-tag'),
            Actions\CreateAction::make()
                ->label('新增餐點'),
        ];
    }
} 