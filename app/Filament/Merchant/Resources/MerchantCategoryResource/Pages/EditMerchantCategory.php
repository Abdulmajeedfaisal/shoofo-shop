<?php

namespace App\Filament\Merchant\Resources\MerchantCategoryResource\Pages;

use App\Filament\Merchant\Resources\MerchantCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMerchantCategory extends EditRecord
{
    protected static string $resource = MerchantCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label(__('حذف')),
        ];
    }
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    protected function getSavedNotificationTitle(): ?string
    {
        return __('تم تحديث الفئة بنجاح');
    }
}
