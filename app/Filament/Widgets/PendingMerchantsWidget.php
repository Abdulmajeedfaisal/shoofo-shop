<?php

namespace App\Filament\Widgets;

use App\Models\Merchant;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Notifications\Notification;

class PendingMerchantsWidget extends BaseWidget
{
    protected static ?int $sort = 3;
    
    protected int | string | array $columnSpan = 'full';
    
    protected static ?string $heading = 'طلبات التجار الجديدة';

    public static function canView(): bool
    {
        return Merchant::where('status', 'pending')->exists();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Merchant::query()
                    ->with(['user'])
                    ->where('status', 'pending')
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\ImageColumn::make('logo')
                    ->label('الشعار')
                    ->circular()
                    ->getStateUsing(function (Merchant $record): ?string {
                        if (!$record->logo) return null;
                        if (str_starts_with($record->logo, 'http')) {
                            return $record->logo;
                        }
                        return asset('storage/' . $record->logo);
                    }),
                
                Tables\Columns\TextColumn::make('store_name')
                    ->label('المتجر')
                    ->description(fn (Merchant $record): string => $record->store_name_ar ?? ''),
                
                Tables\Columns\TextColumn::make('user.name')
                    ->label('صاحب المتجر'),
                
                Tables\Columns\TextColumn::make('user.email')
                    ->label('البريد'),
                
                Tables\Columns\TextColumn::make('phone')
                    ->label('الهاتف'),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ التقديم')
                    ->dateTime('d/m/Y H:i'),
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->label('موافقة')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function (Merchant $record) {
                        $record->update([
                            'status' => 'approved',
                            'approved_at' => now(),
                        ]);
                        Notification::make()
                            ->title('تمت الموافقة على المتجر')
                            ->success()
                            ->send();
                    }),
                
                Tables\Actions\Action::make('reject')
                    ->label('رفض')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function (Merchant $record) {
                        $record->update(['status' => 'rejected']);
                        Notification::make()
                            ->title('تم رفض المتجر')
                            ->danger()
                            ->send();
                    }),
            ])
            ->paginated(false);
    }
}
