<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BrandInfoResource\Pages;
use App\Models\BrandInfo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class BrandInfoResource extends Resource
{
    protected static ?string $model = BrandInfo::class;

    protected static ?string $navigationIcon = 'heroicon-o-information-circle';
    protected static ?string $navigationGroup = '網站管理';
    protected static ?int $navigationSort = 2;
    
    protected static ?string $modelLabel = '品牌簡介';
    protected static ?string $pluralModelLabel = '品牌簡介';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
                Forms\Components\TextInput::make('sort')
                    ->label('排序')
                    ->numeric()
                    ->default(0)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort', 'asc')
            ->columns([
                Tables\Columns\TextColumn::make('sort')
                    ->label('排序')
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
            'index' => Pages\ListBrandInfos::route('/'),
            'create' => Pages\CreateBrandInfo::route('/create'),
            'edit' => Pages\EditBrandInfo::route('/{record}/edit'),
        ];
    }
} 