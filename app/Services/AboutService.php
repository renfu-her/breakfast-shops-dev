<?php

namespace App\Services;

use App\Models\About;
use App\Models\AboutCategory;
use Filament\Forms;
use Filament\Tables;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class AboutService extends BaseService
{
    public function getFormSchema(): array
    {
        return [
            Forms\Components\Select::make('category_id')
                ->label('分類')
                ->options(function () {
                    // 獲取所有分類並組織成階層結構
                    $categories = AboutCategory::all();
                    $options = [];

                    // 先找出頂層分類
                    $topCategories = $categories->where('parent_id', 0);

                    // 遞迴函數來建立階層結構
                    $buildOptions = function ($items, $depth = 0) use (&$buildOptions, $categories) {
                        $options = [];
                        foreach ($items as $category) {
                            // 只有子分類可以被選擇
                            if ($depth > 0) {
                                $prefix = str_repeat('　', $depth - 1);
                                $options[$category->id] = $prefix . '|-' . $category->name;
                            }

                            // 找出此分類的子分類
                            $children = $categories->where('parent_id', $category->id);
                            if ($children->count() > 0) {
                                if ($depth === 0) {
                                    $options[$category->name] = [];
                                }
                                if ($depth === 0) {
                                    $options[$category->name] = $buildOptions($children, $depth + 1);
                                } else {
                                    $options += $buildOptions($children, $depth + 1);
                                }
                            }
                        }
                        return $options;
                    };

                    return $buildOptions($topCategories);
                })
                ->searchable()
                ->required(),
            Forms\Components\TextInput::make('title')
                ->label('主題')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('subtitle')
                ->label('副主題')
                ->maxLength(255),
            TinyEditor::make('content')
                ->label('內容')
                ->minHeight(500)
                ->required()
                ->columnSpanFull(),
            Forms\Components\Toggle::make('is_active')
                ->label('啟用')
                ->default(true)
                ->inline(false),
        ];
    }

    public function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('category.parent.name')
                ->label('主分類')
                ->sortable(),
            Tables\Columns\TextColumn::make('category.name')
                ->label('次分類')
                ->sortable(),
            Tables\Columns\TextColumn::make('title')
                ->label('主題')
                ->searchable(),
            Tables\Columns\TextColumn::make('subtitle')
                ->label('副主題')
                ->searchable(),
            Tables\Columns\ToggleColumn::make('is_active')
                ->label('啟用'),
            Tables\Columns\TextColumn::make('created_at')
                ->label('建立時間')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('updated_at')
                ->label('更新時間')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    public function getTableFilters(): array
    {
        return [
            Tables\Filters\TernaryFilter::make('is_active')
                ->label('啟用狀態')
        ];
    }

    public function getTableActions(): array
    {
        return [
            Tables\Actions\EditAction::make()
                ->label('編輯'),
            Tables\Actions\DeleteAction::make()
                ->label('刪除'),
        ];
    }

    public function getTableBulkActions(): array
    {
        return [
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make()
                    ->label('刪除所選'),
            ]),
        ];
    }
} 