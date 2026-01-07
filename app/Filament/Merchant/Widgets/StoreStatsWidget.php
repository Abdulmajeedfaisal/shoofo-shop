<?php

namespace App\Filament\Merchant\Widgets;

use App\Models\Product;
use App\Models\MerchantCategory;
use App\Models\OrderItem;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class StoreStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;
    
    protected static ?string $pollingInterval = '30s';
    
    protected function getStats(): array
    {
        $merchantId = Auth::user()?->merchant?->id;
        
        if (!$merchantId) {
            return [];
        }
        
        $cacheKey = "merchant_stats_{$merchantId}";
        
        $stats = Cache::remember($cacheKey, now()->addMinutes(5), function () use ($merchantId) {
            return DB::table('products')
                ->where('merchant_id', $merchantId)
                ->selectRaw('
                    COUNT(*) as total_products,
                    SUM(CASE WHEN is_active = 1 THEN 1 ELSE 0 END) as active_products,
                    SUM(CASE WHEN quantity = 0 THEN 1 ELSE 0 END) as out_of_stock
                ')
                ->first();
        });
        
        $totalCategories = Cache::remember("merchant_categories_count_{$merchantId}", now()->addMinutes(5), function () use ($merchantId) {
            return MerchantCategory::where('merchant_id', $merchantId)->count();
        });
        
        // إحصائيات الطلبات والإيرادات
        $orderStats = Cache::remember("merchant_order_stats_{$merchantId}", now()->addMinutes(5), function () use ($merchantId) {
            return DB::table('order_items')
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->where('order_items.merchant_id', $merchantId)
                ->selectRaw('
                    COUNT(DISTINCT orders.id) as total_orders,
                    SUM(CASE WHEN orders.status = "pending" THEN 1 ELSE 0 END) as pending_orders,
                    SUM(CASE WHEN orders.payment_status = "paid" THEN order_items.subtotal ELSE 0 END) as total_revenue
                ')
                ->first();
        });
        
        $totalProducts = $stats->total_products ?? 0;
        $activeProducts = $stats->active_products ?? 0;
        $outOfStock = $stats->out_of_stock ?? 0;
        $totalOrders = $orderStats->total_orders ?? 0;
        $pendingOrders = $orderStats->pending_orders ?? 0;
        $totalRevenue = $orderStats->total_revenue ?? 0;
        
        return [
            Stat::make('إجمالي الإيرادات', number_format($totalRevenue, 2) . ' ر.س')
                ->description('من الطلبات المدفوعة')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5, 8]),
            
            Stat::make('الطلبات', $totalOrders)
                ->description($pendingOrders . ' طلب قيد الانتظار')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color($pendingOrders > 0 ? 'warning' : 'info'),
            
            Stat::make('المنتجات', $totalProducts)
                ->description($activeProducts . ' منتج نشط')
                ->descriptionIcon('heroicon-m-cube')
                ->color('primary'),
            
            Stat::make('الفئات', $totalCategories)
                ->description('فئة في متجرك')
                ->descriptionIcon('heroicon-m-tag')
                ->color('info'),
            
            Stat::make('نفذ من المخزون', $outOfStock)
                ->description('منتج يحتاج إعادة تخزين')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color($outOfStock > 0 ? 'danger' : 'success'),
        ];
    }
}
