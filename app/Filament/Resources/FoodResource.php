<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FoodResource\Pages;
use App\Models\Food;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;
use App\Filament\Resources\FoodResource\RelationManagers;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class FoodResource extends Resource
{
    protected static ?string $model = Food::class;

    protected static ?string $navigationIcon = 'heroicon-o-cake';
    protected static ?string $navigationGroup = '餐點管理';
    protected static ?int $navigationSort = 1;
    
    protected static ?string $modelLabel = '餐點';
    protected static ?string $pluralModelLabel = '餐點介紹';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('food_category_id')
                    ->label('餐點分類')
                    ->relationship('category', 'name')
                    ->required()
                    ->preload()
                    ->searchable()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->label('名稱')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Toggle::make('is_active')
                            ->label('啟用')
                            ->default(true)
                            ->inline(false),
                    ]),
                Forms\Components\TextInput::make('title')
                    ->label('主題')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('subtitle')
                    ->label('副主題')
                    ->maxLength(255),
                Forms\Components\FileUpload::make('image')
                    ->label('圖片')
                    ->image()
                    ->imageEditor()
                    ->directory('foods')
                    ->columnSpanFull()
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->downloadable()
                    ->openable()
                    ->getUploadedFileNameForStorageUsing(
                        fn($file): string => (string) str(Str::uuid7() . '.webp')
                    )
                    ->saveUploadedFileUsing(function ($file) {
                        $manager = new ImageManager(new Driver());
                        $image = $manager->read($file);
                        $image->cover(800, 600);
                        $filename = Str::uuid7()->toString() . '.webp';

                        if (!file_exists(storage_path('app/public/foods'))) {
                            mkdir(storage_path('app/public/foods'), 0755, true);
                        }

                        $image->toWebp(80)->save(storage_path('app/public/foods/' . $filename));
                        return 'foods/' . $filename;
                    })
                    ->deleteUploadedFileUsing(function ($file) {
                        if ($file) {
                            Storage::disk('public')->delete($file);
                        }
                    }),
                TinyEditor::make('content')
                    ->label('內容')
                    ->minHeight(500)
                    ->required()
                    ->columnSpanFull(),
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
                Tables\Columns\TextColumn::make('category.name')
                    ->label('分類')
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('主題')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subtitle')
                    ->label('副主題')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image')
                    ->label('圖片'),
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
            'index' => Pages\ListFoods::route('/'),
            'create' => Pages\CreateFood::route('/create'),
            'edit' => Pages\EditFood::route('/{record}/edit'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\FoodImagesRelationManager::class,
        ];
    }
} 