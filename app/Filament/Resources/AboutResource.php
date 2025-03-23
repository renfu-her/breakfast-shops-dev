<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutResource\Pages;
use App\Models\About;
use App\Services\AboutService;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class AboutResource extends Resource
{
    protected static ?string $model = About::class;

    protected static ?string $navigationIcon = 'heroicon-o-information-circle';
    protected static ?string $navigationGroup = '管理我們管理';
    protected static ?int $navigationSort = 2;
    
    protected static ?string $modelLabel = '關於我們';
    protected static ?string $pluralModelLabel = '關於我們';

    public static function form(Form $form): Form
    {
        $aboutService = new AboutService();

        return $form->schema($aboutService->getFormSchema());
    }

    public static function table(Table $table): Table
    {
        $aboutService = new AboutService();

        return $table
            ->columns($aboutService->getTableColumns())
            ->filters($aboutService->getTableFilters())
            ->actions($aboutService->getTableActions())
            ->bulkActions($aboutService->getTableBulkActions())
            ->emptyStateHeading('尚無內容')
            ->emptyStateDescription('開始建立您的第一個內容')
            ->defaultSort('created_at', 'desc')
            ->searchPlaceholder('搜尋內容')
            ->filtersTriggerAction(
                fn($action) => $action->label('篩選')
            );
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAbouts::route('/'),
            'create' => Pages\CreateAbout::route('/create'),
            'edit' => Pages\EditAbout::route('/{record}/edit'),
        ];
    }
} 