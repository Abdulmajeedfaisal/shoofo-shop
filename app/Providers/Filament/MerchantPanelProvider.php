<?php

namespace App\Providers\Filament;

use App\Http\Middleware\EnsureMerchantApproved;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Navigation\NavigationGroup;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class MerchantPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('merchant')
            ->path('merchant')
            ->brandName(fn () => auth()->user()?->merchant?->store_name ?? 'SHOOFO Merchant')
            ->brandLogo(fn () => auth()->user()?->merchant?->logo_url ?? asset('images/logo_shoofo_shop_1.png'))
            ->darkModeBrandLogo(fn () => auth()->user()?->merchant?->logo_url ?? asset('images/logo_shoofo_shop_in_dark.png'))
            ->favicon(asset('favicon.png'))
            ->colors([
                'primary' => Color::Amber,
                'success' => Color::Emerald,
                'warning' => Color::Orange,
                'danger' => Color::Rose,
                'info' => Color::Blue,
                'gray' => Color::Slate,
            ])
            ->font('Cairo')
            ->navigationGroups([
                NavigationGroup::make()
                    ->label('لوحة التحكم')
                    ->icon('heroicon-o-home'),
                NavigationGroup::make()
                    ->label('المنتجات')
                    ->icon('heroicon-o-cube'),
                NavigationGroup::make()
                    ->label('الطلبات')
                    ->icon('heroicon-o-shopping-cart'),
                NavigationGroup::make()
                    ->label('المتجر')
                    ->icon('heroicon-o-building-storefront')
                    ->collapsed(),
            ])
            ->discoverResources(in: app_path('Filament/Merchant/Resources'), for: 'App\\Filament\\Merchant\\Resources')
            ->discoverPages(in: app_path('Filament/Merchant/Pages'), for: 'App\\Filament\\Merchant\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Merchant/Widgets'), for: 'App\\Filament\\Merchant\\Widgets')
            ->widgets([
                \App\Filament\Merchant\Widgets\StoreStatsWidget::class,
                \App\Filament\Merchant\Widgets\LatestProductsWidget::class,
                \App\Filament\Merchant\Widgets\MerchantOrdersWidget::class,
                \App\Filament\Merchant\Widgets\RevenueChartWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
                EnsureMerchantApproved::class,
            ])
            ->authGuard('web')
            ->sidebarCollapsibleOnDesktop()
            ->maxContentWidth('full')
            ->globalSearchKeyBindings(['command+k', 'ctrl+k'])
            ->databaseNotifications()
            ->databaseNotificationsPolling('30s');
    }
}
