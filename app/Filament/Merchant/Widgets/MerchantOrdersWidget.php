<?php

namespace App\Filament\Merchant\Widgets;

use App\Models\OrderItem;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class MerchantOrdersWidget extends BaseWidget
{
    protected static ?int $sort = 3;
    
    protected int | string | array $columnSpan = 'full';
    
    protected static ?string $heading = 'أحدث الطلبات';

    public function table(Table $table): Table
    {
        $merchantId = Auth::user()?->merchant?->id;
        
        return $table
            ->query(
                OrderItem::query()
                    ->where('merchant_id', $merchantId)
                    ->with(['order.user', 'product'])
                    ->latest()
                    ->limit(10)
            )
            ->paginated(false)
            ->columns([
                Tables\Columns\TextColumn::make('order.order_number')
                    ->label('رقم الطلب')
                    ->searchable()
                    ->weight('bold')
                    ->copyable(),
                
                Tables\Columns\TextColumn::make('order.user.name')
                    ->label('العميل'),
                
                Tables\Columns\TextColumn::make('product_name')
                    ->label('المنتج')
                    ->limit(30),
                
                Tables\Columns\TextColumn::make('quantity')
                    ->label('الكمية')
                    ->alignCenter()
                    ->badge()
                    ->color('info'),
                
                Tables\Columns\TextColumn::make('subtotal')
                    ->label('الإجمالي')
                    ->money('SAR')
                    ->weight('bold'),
                
                Tables\Columns\BadgeColumn::make('order.status')
                    ->label('الحالة')
                    ->colors([
                        'warning' => 'pending',
                        'info' => 'confirmed',
                        'primary' => 'processing',
                        'secondary' => 'shipped',
                        'success' => 'delivered',
                        'danger' => 'cancelled',
                    ])
                    ->formatStateUsing(fn (?string $state): string => match($state) {
                        'pending' => 'قيد الانتظار',
                        'confirmed' => 'مؤكد',
                        'processing' => 'قيد التجهيز',
                        'shipped' => 'تم الشحن',
                        'delivered' => 'تم التسليم',
                        'cancelled' => 'ملغي',
                        default => $state ?? '-',
                    }),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('التاريخ')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->emptyStateHeading('لا توجد طلبات')
            ->emptyStateDescription('ستظهر هنا الطلبات الجديدة على منتجاتك')
            ->emptyStateIcon('heroicon-o-shopping-cart');
    }
}
