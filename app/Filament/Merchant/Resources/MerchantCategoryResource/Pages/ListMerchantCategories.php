<?php

namespace App\Filament\Merchant\Resources\MerchantCategoryResource\Pages;

use App\Filament\Merchant\Resources\MerchantCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMerchantCategories extends ListRecords
{
    protected static string $resource = MerchantCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label(__('إضافة فئة'))
                ->icon('heroicon-o-plus'),
        ];
    }
}
