<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutCategoryResource\Pages;
use App\Models\AboutCategory;
use App\Services\AboutCategoryService;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AboutCategoryResource extends Resource
{
    protected static ?string $model = AboutCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationGroup = '管理我們管理';
    protected static ?int $navigationSort = 1;
    
    protected static ?string $modelLabel = '分類';
    protected static ?string $pluralModelLabel = '關於我們分類';

    public static function form(Form $form): Form
    {
        return $form->schema(
            app(AboutCategoryService::class)->getFormSchema()
        );
    }

    public static function table(Table $table): Table
    {
        $service = app(AboutCategoryService::class);

        return $table
            ->columns($service->getTableColumns())
            ->filters($service->getTableFilters())
            ->actions($service->getTableActions())
            ->bulkActions($service->getTableBulkActions())
            ->modifyQueryUsing(function (Builder $query) {
                // 先獲取所有分類
                $categories = AboutCategory::all();

                // 遞迴函數來建立排序順序
                $buildOrder = function ($parentId = null) use ($categories, &$buildOrder) {
                    $ids = [];
                    $items = $categories->where('parent_id', $parentId)->sortBy('sort');

                    foreach ($items as $item) {
                        $ids[] = $item->id;
                        $ids = array_merge($ids, $buildOrder($item->id));
                    }

                    return $ids;
                };

                // 獲取排序後的 ID 列表
                $orderedIds = $buildOrder(null);

                if (!empty($orderedIds)) {
                    // 建立 CASE 語句
                    $cases = [];
                    foreach ($orderedIds as $index => $id) {
                        $cases[] = "WHEN id = {$id} THEN {$index}";
                    }
                    $orderByCase = "CASE " . implode(' ', $cases) . " END";

                    return $query->orderByRaw($orderByCase);
                }

                return $query;
            })
            ->paginated(false); // 關閉分頁
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