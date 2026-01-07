<?php

namespace App\Filament\Merchant\Resources\MerchantCategoryResource\Pages;

use App\Filament\Merchant\Resources\MerchantCategoryResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateMerchantCategory extends CreateRecord
{
    protected static string $resource = MerchantCategoryResource::class;
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['merchant_id'] = Auth::user()->merchant->id;
        
        return $data;
    }
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    protected function getCreatedNotificationTitle(): ?string
    {
        return __('تم إنشاء الفئة بنجاح');
    }
}
