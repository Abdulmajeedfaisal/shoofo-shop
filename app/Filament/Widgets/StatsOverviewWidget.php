<?php

namespace App\Filament\Widgets;

use App\Models\Merchant;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Cache;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;
    
    protected static ?string $pollingInterval = '30s';

    protected function getStats(): array
    {
        $stats = Cache::remember('admin_dashboard_stats', 300, function () {
            return [
                'total_revenue' => Order::where('payment_status', 'paid')->sum('total'),
                'pending_orders' => Order::where('status', 'pending')->count(),
                'total_orders' => Order::count(),
                'total_merchants' => Merchant::count(),
                'pending_merchants' => Merchant::where('status', 'pending')->count(),
                'approved_merchants' => Merchant::where('status', 'approved')->count(),
                'total_products' => Product::count(),
                'active_products' => Product::where('is_active', true)->count(),
                'total_users' => User::count(),
                'customers' => User::where('role', 'customer')->count(),
            ];
        });

        return [
            Stat::make('إجمالي الإيرادات', number_format($stats['total_revenue'], 2) . ' ر.س')
                ->description('من الطلبات المدفوعة')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5, 8]),
            
            Stat::make('الطلبات', $stats['total_orders'])
                ->description($stats['pending_orders'] . ' طلب قيد الانتظار')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color($stats['pending_orders'] > 0 ? 'warning' : 'success'),
            
            Stat::make('التجار', $stats['total_merchants'])
                ->description($stats['pending_merchants'] . ' بانتظار الموافقة')
                ->descriptionIcon('heroicon-m-building-storefront')
                ->color($stats['pending_merchants'] > 0 ? 'warning' : 'info'),
            
            Stat::make('المنتجات', $stats['total_products'])
                ->description($stats['active_products'] . ' منتج نشط')
                ->descriptionIcon('heroicon-m-cube')
                ->color('info'),
            
            Stat::make('المستخدمون', $stats['total_users'])
                ->description($stats['customers'] . ' عميل')
                ->descriptionIcon('heroicon-m-users')
                ->color('gray'),
        ];
    }
}
