<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutCategoryResource\Pages;
use App\Models\AboutCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AboutCategoryResource extends Resource
{
    protected static ?string $model = AboutCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationGroup = '管理我們管理';
    protected static ?int $navigationSort = 1;
    
    protected static ?string $modelLabel = '關於我們分類';
    protected static ?string $pluralModelLabel = '關於我們分類';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('名稱')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('sort')
                    ->label('排序')
                    ->numeric()
                    ->default(0)
                    ->required(),
                Forms\Components\Toggle::make('is_active')
                    ->label('啟用')
                    ->default(true)
                    ->inline(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('名稱')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sort')
                    ->label('排序')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('啟用')
                    ->boolean(),
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
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('啟用狀態')
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('編輯'),
                Tables\Actions\DeleteAction::make()
                    ->label('刪除'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('刪除所選'),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAboutCategories::route('/'),
            'create' => Pages\CreateAboutCategory::route('/create'),
            'edit' => Pages\EditAboutCategory::route('/{record}/edit'),
        ];
    }
} 