<?php

namespace App\Filament\Resources\FoodResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;

class FoodImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'images';

    protected static ?string $title = '圖片管理';

    protected static ?string $recordTitleAttribute = 'image';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
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
                    })
                    ->required(),
                Forms\Components\TextInput::make('sort')
                    ->label('排序')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort', 'asc')
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('圖片'),
                Tables\Columns\TextColumn::make('sort')
                    ->label('排序')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('新增圖片'),
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
            ])
            ->reorderable('sort');
    }
} 