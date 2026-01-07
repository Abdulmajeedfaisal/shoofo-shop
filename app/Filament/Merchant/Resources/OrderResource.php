<?php

namespace App\Filament\Merchant\Resources;

use App\Filament\Merchant\Resources\OrderResource\Pages;
use App\Models\OrderItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class OrderResource extends Resource
{
    protected static ?string $model = OrderItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    
    protected static ?string $navigationGroup = 'الطلبات';
    
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
            ->whereHas('order', fn ($q) => $q->where('status', 'pending'))
            ->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('معلومات الطلب')
                    ->schema([
                        Forms\Components\Placeholder::make('order_number')
                            ->label('رقم الطلب')
                            ->content(fn ($record) => $record->order->order_number),
                        
                        Forms\Components\Placeholder::make('customer')
                            ->label('العميل')
                            ->content(fn ($record) => $record->order->user->name),
                        
                        Forms\Components\Placeholder::make('product')
                            ->label('المنتج')
                            ->content(fn ($record) => $record->product_name),
                        
                        Forms\Components\Placeholder::make('quantity')
                            ->label('الكمية')
                            ->content(fn ($record) => $record->quantity),
                        
                        Forms\Components\Placeholder::make('price')
                            ->label('السعر')
                            ->content(fn ($record) => number_format($record->price, 2) . ' ر.س'),
                        
                        Forms\Components\Placeholder::make('subtotal')
                            ->label('الإجمالي')
                            ->content(fn ($record) => number_format($record->subtotal, 2) . ' ر.س'),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('معلومات الشحن')
                    ->schema([
                        Forms\Components\Placeholder::make('shipping_name')
                            ->label('اسم المستلم')
                            ->content(fn ($record) => $record->order->shipping_name),
                        
                        Forms\Components\Placeholder::make('shipping_phone')
                            ->label('الهاتف')
                            ->content(fn ($record) => $record->order->shipping_phone),
                        
                        Forms\Components\Placeholder::make('shipping_address')
                            ->label('العنوان')
                            ->content(fn ($record) => $record->order->shipping_address),
                        
                        Forms\Components\Placeholder::make('shipping_city')
                            ->label('المدينة')
                            ->content(fn ($record) => $record->order->shipping_city),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order.order_number')
                    ->label('رقم الطلب')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->copyable(),
                
                Tables\Columns\TextColumn::make('order.user.name')
                    ->label('العميل')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('product_name')
                    ->label('المنتج')
                    ->searchable()
                    ->limit(25)
                    ->tooltip(fn ($record) => $record->product_name),
                
                Tables\Columns\TextColumn::make('quantity')
                    ->label('الكمية')
                    ->alignCenter()
                    ->badge()
                    ->color('info'),
                
                Tables\Columns\TextColumn::make('price')
                    ->label('السعر')
                    ->money('SAR'),
                
                Tables\Columns\TextColumn::make('subtotal')
                    ->label('الإجمالي')
                    ->money('SAR')
                    ->weight('bold'),
                
                Tables\Columns\BadgeColumn::make('order.status')
                    ->label('حالة الطلب')
                    ->colors([
                        'warning' => 'pending',
                        'info' => 'confirmed',
                        'primary' => 'processing',
                        'secondary' => 'shipped',
                        'success' => 'delivered',
                        'danger' => 'cancelled',
                    ])
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'pending' => 'قيد الانتظار',
                        'confirmed' => 'مؤكد',
                        'processing' => 'قيد التجهيز',
                        'shipped' => 'تم الشحن',
                        'delivered' => 'تم التسليم',
                        'cancelled' => 'ملغي',
                        default => $state,
                    }),
                
                Tables\Columns\BadgeColumn::make('order.payment_status')
                    ->label('الدفع')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'paid',
                        'danger' => 'failed',
                        'gray' => 'refunded',
                    ])
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
                Tables\Filters\SelectFilter::make('order_status')
                    ->label('حالة الطلب')
                    ->options([
                        'pending' => 'قيد الانتظار',
                        'confirmed' => 'مؤكد',
                        'processing' => 'قيد التجهيز',
                        'shipped' => 'تم الشحن',
                        'delivered' => 'تم التسليم',
                        'cancelled' => 'ملغي',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['value'],
                            fn (Builder $query, $value): Builder => $query->whereHas('order', fn ($q) => $q->where('status', $value))
                        );
                    }),
                
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
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([])
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('لا توجد طلبات')
            ->emptyStateDescription('ستظهر هنا الطلبات على منتجاتك')
            ->emptyStateIcon('heroicon-o-shopping-cart');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'view' => Pages\ViewOrder::route('/{record}'),
        ];
    }
    
    public static function getEloquentQuery(): Builder
    {
        $merchantId = Auth::user()?->merchant?->id;
        
        return parent::getEloquentQuery()
            ->where('merchant_id', $merchantId)
            ->with(['order.user', 'product']);
    }
}
