<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    public function mount(string|int $record): void
    {
        $user = $this->getResource()::getModel()::find($record);
        
        if ($user && $user->email === 'admin@admin.com') {
            $this->redirect($this->getResource()::getUrl('index'));
        }
        
        parent::mount($record);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label('刪除')
                ->disabled(fn ($record) => $record->email === 'admin@admin.com'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction()
                ->label('儲存'),
            $this->getCancelFormAction()
                ->label('取消'),
        ];
    }
} 