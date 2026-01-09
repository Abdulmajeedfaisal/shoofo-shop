<?php

namespace App\Filament\Merchant\Resources;

use App\Filament\Merchant\Resources\MerchantOrderResource\Pages;
use App\Models\MerchantOrder;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class MerchantOrderResource extends Resource
{
    protected static ?string $model = MerchantOrder::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    
    protected static ?string $navigationGroup = 'الطلبات';
    
    protected static ?string $navigationLabel = 'الطلبات';
    
    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string
    {
        return 'طلب';
    }

    public static function getPluralModelLabel(): string
    {
        return 'الطلبات';
    }

    public static function getNavigationBadge(): ?string
    {
        $merchantId = Auth::user()?->merchant?->id;
        if (!$merchantId) return null;
        
        return static::getModel()::where('merchant_id', $merchantId)
            ->where('status', 'pending')
            ->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                // Timeline - مسار الطلب
                Infolists\Components\Section::make('مسار الطلب')
                    ->icon('heroicon-o-arrow-trending-up')
                    ->schema([
                        Infolists\Components\ViewEntry::make('status')
                            ->label('')
                            ->view('filament.infolists.components.merchant-order-timeline'),
                    ])
                    ->collapsible(),
                
                Infolists\Components\Section::make('معلومات الطلب')
                    ->icon('heroicon-o-shopping-cart')
                    ->schema([
                        Infolists\Components\Grid::make(4)
                            ->schema([
                                Infolists\Components\TextEntry::make('sub_order_number')
                                    ->label('رقم الطلب')
                                    ->weight('bold')
                                    ->color('primary')
                                    ->copyable()
                                    ->size('lg'),
                                
                                Infolists\Components\TextEntry::make('created_at')
                                    ->label('تاريخ الطلب')
                                    ->dateTime('d/m/Y - H:i'),
                                
                                Infolists\Components\TextEntry::make('status')
                                    ->label('حالة الطلب')
                                    ->badge()
                                    ->color(fn (string $state): string => match($state) {
                                        'pending' => 'warning',
                                        'confirmed' => 'info',
                                        'processing' => 'primary',
                                        'shipped' => 'gray',
                                        'delivered' => 'success',
                                        'cancelled' => 'danger',
                                        default => 'gray',
                                    })
                                    ->formatStateUsing(fn (string $state): string => match($state) {
                                        'pending' => '⏳ قيد الانتظار',
                                        'confirmed' => '✅ مؤكد',
                                        'processing' => '🔄 قيد التجهيز',
                                        'shipped' => '🚚 تم الشحن',
                                        'delivered' => '📦 تم التسليم',
                                        'cancelled' => '❌ ملغي',
                                        default => $state,
                                    }),
                                
                                Infolists\Components\TextEntry::make('subtotal')
                                    ->label('الإجمالي')
                                    ->money('SAR')
                                    ->weight('bold')
                                    ->color('success'),
                            ]),
                    ]),
                
                // المنتجات في هذا الطلب
                Infolists\Components\Section::make('المنتجات')
                    ->icon('heroicon-o-cube')
                    ->schema([
                        Infolists\Components\RepeatableEntry::make('items')
                            ->label('')
                            ->schema([
                                Infolists\Components\Grid::make(4)
                                    ->schema([
                                        Infolists\Components\TextEntry::make('product_name')
                                            ->label('المنتج'),
                                        
                                        Infolists\Components\TextEntry::make('quantity')
                                            ->label('الكمية')
                                            ->badge()
                                            ->color('info'),
                                        
                                        Infolists\Components\TextEntry::make('price')
                                            ->label('السعر')
                                            ->money('SAR'),
                                        
                                        Infolists\Components\TextEntry::make('subtotal')
                                            ->label('الإجمالي')
                                            ->money('SAR')
                                            ->weight('bold'),
                                    ]),
                            ])
                            ->columnSpanFull(),
                    ]),
                
                Infolists\Components\Section::make('معلومات العميل')
                    ->icon('heroicon-o-user')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('order.user.name')
                                    ->label('اسم العميل'),
                                
                                Infolists\Components\TextEntry::make('order.user.email')
                                    ->label('البريد الإلكتروني')
                                    ->copyable(),
                            ]),
                    ])
                    ->collapsible(),
                
                Infolists\Components\Section::make('معلومات الشحن')
                    ->icon('heroicon-o-truck')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('order.shipping_name')
                                    ->label('اسم المستلم'),
                                
                                Infolists\Components\TextEntry::make('order.shipping_phone')
                                    ->label('رقم الهاتف')
                                    ->copyable(),
                                
                                Infolists\Components\TextEntry::make('order.shipping_email')
                                    ->label('البريد الإلكتروني')
                                    ->copyable(),
                                
                                Infolists\Components\TextEntry::make('order.shipping_city')
                                    ->label('المدينة'),
                                
                                Infolists\Components\TextEntry::make('order.shipping_country')
                                    ->label('الدولة'),
                                
                                Infolists\Components\TextEntry::make('order.shipping_postal_code')
                                    ->label('الرمز البريدي')
                                    ->default('-'),
                            ]),
                        
                        Infolists\Components\TextEntry::make('order.shipping_address')
                            ->label('العنوان الكامل')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),
                
                Infolists\Components\Section::make('معلومات الدفع')
                    ->icon('heroicon-o-credit-card')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('order.payment_method')
                                    ->label('طريقة الدفع')
                                    ->formatStateUsing(fn (?string $state): string => match($state) {
                                        'cod' => '💵 الدفع عند الاستلام',
                                        'credit_card' => '💳 بطاقة ائتمان',
                                        'bank_transfer' => '🏦 تحويل بنكي',
                                        default => $state ?? '-',
                                    }),
                                
                                Infolists\Components\TextEntry::make('order.payment_status')
                                    ->label('حالة الدفع')
                                    ->badge()
                                    ->color(fn (?string $state): string => match($state) {
                                        'pending' => 'warning',
                                        'paid' => 'success',
                                        'failed' => 'danger',
                                        'refunded' => 'gray',
                                        default => 'gray',
                                    })
                                    ->formatStateUsing(fn (?string $state): string => match($state) {
                                        'pending' => 'قيد الانتظار',
                                        'paid' => 'مدفوع',
                                        'failed' => 'فشل',
                                        'refunded' => 'مسترد',
                                        default => $state ?? '-',
                                    }),
                            ]),
                    ])
                    ->collapsible(),
                
                Infolists\Components\Section::make('ملاحظات العميل')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->schema([
                        Infolists\Components\TextEntry::make('order.notes')
                            ->label('')
                            ->default('لا توجد ملاحظات')
                            ->columnSpanFull(),
                    ])
                    ->collapsed()
                    ->visible(fn ($record) => !empty($record->order->notes)),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sub_order_number')
                    ->label('رقم الطلب')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->copyable(),
                
                Tables\Columns\TextColumn::make('order.user.name')
                    ->label('العميل')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('items_count')
                    ->label('المنتجات')
                    ->counts('items')
                    ->badge()
                    ->color('info'),
                
                Tables\Columns\TextColumn::make('subtotal')
                    ->label('الإجمالي')
                    ->money('SAR')
                    ->weight('bold'),
                
                Tables\Columns\TextColumn::make('status')
                    ->label('الحالة')
                    ->badge()
                    ->color(fn (string $state): string => match($state) {
                        'pending' => 'warning',
                        'confirmed' => 'info',
                        'processing' => 'primary',
                        'shipped' => 'gray',
                        'delivered' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'pending' => 'قيد الانتظار',
                        'confirmed' => 'مؤكد',
                        'processing' => 'قيد التجهيز',
                        'shipped' => 'تم الشحن',
                        'delivered' => 'تم التسليم',
                        'cancelled' => 'ملغي',
                        default => $state,
                    }),
                
                Tables\Columns\TextColumn::make('order.payment_status')
                    ->label('الدفع')
                    ->badge()
                    ->color(fn (string $state): string => match($state) {
                        'pending' => 'warning',
                        'paid' => 'success',
                        'failed' => 'danger',
                        'refunded' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'pending' => 'قيد الانتظار',
                        'paid' => 'مدفوع',
                        'failed' => 'فشل',
                        'refunded' => 'مسترد',
                        default => $state,
                    }),
                
                Tables\Columns\TextColumn::make('order.shipping_city')
                    ->label('المدينة')
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('التاريخ')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('حالة الطلب')
                    ->options([
                        'pending' => 'قيد الانتظار',
                        'confirmed' => 'مؤكد',
                        'processing' => 'قيد التجهيز',
                        'shipped' => 'تم الشحن',
                        'delivered' => 'تم التسليم',
                        'cancelled' => 'ملغي',
                    ]),
                
                Tables\Filters\SelectFilter::make('payment_status')
                    ->label('حالة الدفع')
                    ->options([
                        'pending' => 'قيد الانتظار',
                        'paid' => 'مدفوع',
                        'failed' => 'فشل',
                        'refunded' => 'مسترد',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['value'],
                            fn (Builder $query, $value): Builder => $query->whereHas('order', fn ($q) => $q->where('payment_status', $value))
                        );
                    }),
            ])
            ->actions([
                // زر الإجراء التالي
                Tables\Actions\Action::make('nextAction')
                    ->label(fn (MerchantOrder $record): string => match($record->status) {
                        'pending' => 'تأكيد',
                        'confirmed' => 'تجهيز',
                        'processing' => 'شحن',
                        'shipped' => 'تسليم',
                        default => '',
                    })
                    ->icon(fn (MerchantOrder $record): string => match($record->status) {
                        'pending' => 'heroicon-o-check-circle',
                        'confirmed' => 'heroicon-o-cog-6-tooth',
                        'processing' => 'heroicon-o-truck',
                        'shipped' => 'heroicon-o-check-badge',
                        default => 'heroicon-o-check',
                    })
                    ->color(fn (MerchantOrder $record): string => match($record->status) {
                        'pending' => 'success',
                        'confirmed' => 'primary',
                        'processing' => 'info',
                        'shipped' => 'success',
                        default => 'gray',
                    })
                    ->button()
                    ->visible(fn (MerchantOrder $record) => !in_array($record->status, ['delivered', 'cancelled']))
                    ->requiresConfirmation()
                    ->modalHeading(fn (MerchantOrder $record): string => match($record->status) {
                        'pending' => 'تأكيد الطلب',
                        'confirmed' => 'بدء التجهيز',
                        'processing' => 'تأكيد الشحن',
                        'shipped' => 'تأكيد التسليم',
                        default => 'تحديث الحالة',
                    })
                    ->action(function (MerchantOrder $record) {
                        $newStatus = $record->getNextStatus();
                        if (!$newStatus) return;
                        
                        $record->update(['status' => $newStatus]);
                        
                        // تحديث حالة الطلب الرئيسي
                        $record->order->updateStatusFromMerchantOrders();
                        
                        $statusLabels = [
                            'confirmed' => 'تم تأكيد الطلب',
                            'processing' => 'تم بدء التجهيز',
                            'shipped' => 'تم شحن الطلب',
                            'delivered' => 'تم تسليم الطلب',
                        ];
                        
                        Notification::make()
                            ->title($statusLabels[$newStatus] ?? 'تم تحديث الحالة')
                            ->body('الطلب رقم ' . $record->sub_order_number)
                            ->success()
                            ->send();
                    }),
                
                Tables\Actions\ViewAction::make()
                    ->label('التفاصيل')
                    ->icon('heroicon-o-eye'),
                
                Tables\Actions\Action::make('cancel')
                    ->label('إلغاء')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (MerchantOrder $record) => $record->canBeCancelled())
                    ->requiresConfirmation()
                    ->modalHeading('إلغاء الطلب')
                    ->modalDescription('هل أنت متأكد من إلغاء هذا الطلب؟ سيتم إعادة الكمية للمخزون.')
                    ->modalSubmitActionLabel('نعم، إلغاء الطلب')
                    ->action(function (MerchantOrder $record) {
                        $record->update(['status' => 'cancelled']);
                        
                        // إعادة الكمية للمخزون
                        foreach ($record->items as $item) {
                            if ($item->product) {
                                $item->product->increment('quantity', $item->quantity);
                            }
                        }
                        
                        // تحديث حالة الطلب الرئيسي
                        $record->order->updateStatusFromMerchantOrders();
                        
                        Notification::make()
                            ->title('تم إلغاء الطلب')
                            ->body('الطلب رقم ' . $record->sub_order_number)
                            ->danger()
                            ->send();
                    }),
            ])
            ->bulkActions([])
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('لا توجد طلبات')
            ->emptyStateDescription('ستظهر هنا الطلبات على منتجاتك')
            ->emptyStateIcon('heroicon-o-shopping-cart')
            ->poll('30s');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMerchantOrders::route('/'),
            'view' => Pages\ViewMerchantOrder::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $merchantId = Auth::user()?->merchant?->id;

        return parent::getEloquentQuery()
            ->where('merchant_id', $merchantId)
            ->with(['order.user', 'items.product']);
    }
}
