<?php

namespace App\Filament\Resources\GlobalCategoryResource\Pages;

use App\Filament\Resources\GlobalCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGlobalCategory extends EditRecord
{
    protected static string $resource = GlobalCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
