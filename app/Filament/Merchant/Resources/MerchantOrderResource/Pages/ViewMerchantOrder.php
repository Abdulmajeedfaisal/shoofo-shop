<?php

namespace App\Filament\Merchant\Resources\MerchantOrderResource\Pages;

use App\Filament\Merchant\Resources\MerchantOrderResource;
use App\Models\MerchantOrder;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewMerchantOrder extends ViewRecord
{
    protected static string $resource = MerchantOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // زر الإجراء التالي - يظهر حسب الحالة الحالية
            Actions\Action::make('confirm')
                ->label('✅ تأكيد الطلب')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->size('lg')
                ->visible(fn () => $this->record->status === 'pending')
                ->requiresConfirmation()
                ->modalHeading('تأكيد الطلب')
                ->modalDescription('هل أنت متأكد من تأكيد هذا الطلب؟')
                ->modalSubmitActionLabel('نعم، تأكيد الطلب')
                ->action(function () {
                    $this->record->update(['status' => 'confirmed']);
                    $this->record->order->updateStatusFromMerchantOrders();
                    
                    Notification::make()
                        ->title('تم تأكيد الطلب بنجاح')
                        ->body('الطلب رقم ' . $this->record->sub_order_number)
                        ->success()
                        ->send();
                        
                    $this->redirect(MerchantOrderResource::getUrl('view', ['record' => $this->record]));
                }),

            Actions\Action::make('process')
                ->label('🔄 بدء التجهيز')
                ->icon('heroicon-o-cog-6-tooth')
                ->color('primary')
                ->size('lg')
                ->visible(fn () => $this->record->status === 'confirmed')
                ->action(function () {
                    $this->record->update(['status' => 'processing']);
                    $this->record->order->updateStatusFromMerchantOrders();
                    
                    Notification::make()
                        ->title('تم بدء تجهيز الطلب')
                        ->body('الطلب رقم ' . $this->record->sub_order_number)
                        ->success()
                        ->send();
                        
                    $this->redirect(MerchantOrderResource::getUrl('view', ['record' => $this->record]));
                }),

            Actions\Action::make('ship')
                ->label('🚚 تم الشحن')
                ->icon('heroicon-o-truck')
                ->color('info')
                ->size('lg')
                ->visible(fn () => $this->record->status === 'processing')
                ->requiresConfirmation()
                ->modalHeading('تأكيد الشحن')
                ->modalDescription('هل تم شحن الطلب فعلاً؟')
                ->modalSubmitActionLabel('نعم، تم الشحن')
                ->action(function () {
                    $this->record->update(['status' => 'shipped']);
                    $this->record->order->updateStatusFromMerchantOrders();
                    
                    Notification::make()
                        ->title('تم شحن الطلب')
                        ->body('الطلب رقم ' . $this->record->sub_order_number)
                        ->success()
                        ->send();
                        
                    $this->redirect(MerchantOrderResource::getUrl('view', ['record' => $this->record]));
                }),

            Actions\Action::make('deliver')
                ->label('📦 تم التسليم')
                ->icon('heroicon-o-check-badge')
                ->color('success')
                ->size('lg')
                ->visible(fn () => $this->record->status === 'shipped')
                ->requiresConfirmation()
                ->modalHeading('تأكيد التسليم')
                ->modalDescription('هل تم تسليم الطلب للعميل بنجاح؟')
                ->modalSubmitActionLabel('نعم، تم التسليم')
                ->action(function () {
                    $this->record->update(['status' => 'delivered']);
                    $this->record->order->updateStatusFromMerchantOrders();
                    
                    Notification::make()
                        ->title('تم تسليم الطلب بنجاح')
                        ->body('الطلب رقم ' . $this->record->sub_order_number)
                        ->success()
                        ->send();
                        
                    $this->redirect(MerchantOrderResource::getUrl('view', ['record' => $this->record]));
                }),

            // زر الإلغاء
            Actions\Action::make('cancel')
                ->label('إلغاء الطلب')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->outlined()
                ->visible(fn () => $this->record->canBeCancelled())
                ->requiresConfirmation()
                ->modalHeading('إلغاء الطلب')
                ->modalDescription('هل أنت متأكد من إلغاء هذا الطلب؟ سيتم إعادة الكمية للمخزون.')
                ->modalSubmitActionLabel('نعم، إلغاء الطلب')
                ->action(function () {
                    $this->record->update(['status' => 'cancelled']);
                    
                    // إعادة الكمية للمخزون
                    foreach ($this->record->items as $item) {
                        if ($item->product) {
                            $item->product->increment('quantity', $item->quantity);
                        }
                    }
                    
                    $this->record->order->updateStatusFromMerchantOrders();
                    
                    Notification::make()
                        ->title('تم إلغاء الطلب')
                        ->body('الطلب رقم ' . $this->record->sub_order_number)
                        ->danger()
                        ->send();
                        
                    $this->redirect(MerchantOrderResource::getUrl('view', ['record' => $this->record]));
                }),
        ];
    }
}
