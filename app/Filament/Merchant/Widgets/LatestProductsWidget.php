<?php

namespace App\Filament\Merchant\Widgets;

use App\Models\Product;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class LatestProductsWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    
    protected int | string | array $columnSpan = 'full';
    
    protected static ?string $heading = 'أحدث المنتجات';
    
    // تعطيل التحديث التلقائي لتحسين الأداء
    protected static ?string $pollingInterval = null;

    public function table(Table $table): Table
    {
        $merchantId = Auth::user()?->merchant?->id;
        
        return $table
            ->query(
                Product::query()
                    ->where('merchant_id', $merchantId)
                    // Eager loading لحل مشكلة N+1
                    ->with(['primaryImage', 'merchantCategory'])
                    ->latest()
                    ->limit(5)
            )
            ->paginated(false) // تعطيل pagination لأننا نعرض 5 فقط
            ->columns([
                Tables\Columns\ImageColumn::make('primary_image')
                    ->label(__('الصورة'))
                    ->circular()
                    ->getStateUsing(function ($record): ?string {
                        $image = $record->primaryImage;
                        if (!$image) return null;
                        
                        // إذا كانت URL كاملة، أرجعها مباشرة
                        if (str_starts_with($image->image, 'http')) {
                            return $image->image;
                        }
                        
                        // إذا كانت مسار محلي، أرجع URL كامل
                        return asset('storage/' . $image->image);
                    })
                    ->defaultImageUrl(url('/images/placeholder.png')),
                
                Tables\Columns\TextColumn::make('name')
                    ->label(__('المنتج'))
                    ->description(fn (Product $record): string => $record->merchantCategory?->name ?? ''),
                
                Tables\Columns\TextColumn::make('price')
                    ->label(__('السعر'))
                    ->money('SAR'),
                
                Tables\Columns\TextColumn::make('quantity')
                    ->label(__('المخزون'))
                    ->badge()
                    ->color(fn (int $state): string => match(true) {
                        $state === 0 => 'danger',
                        $state < 10 => 'warning',
                        default => 'success',
                    }),
                
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('نشط'))
                    ->boolean(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('التاريخ'))
                    ->since(),
            ])
            ->actions([
                Tables\Actions\Action::make('edit')
                    ->label(__('تعديل'))
                    ->url(fn (Product $record): string => route('filament.merchant.resources.products.edit', [
                        'record' => $record,
                    ]))
                    ->icon('heroicon-m-pencil-square'),
            ])
            ->emptyStateHeading(__('لا توجد منتجات'))
            ->emptyStateDescription(__('ابدأ بإضافة منتجاتك الآن'))
            ->emptyStateIcon('heroicon-o-cube');
    }
}
