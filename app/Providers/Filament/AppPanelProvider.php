<?php

namespace App\Providers\Filament;

use App\Filament\Pages\TaskBoard;
use App\Filament\Pages\Tenancy\EditBusinessProfile;
use App\Filament\Pages\Tenancy\RegisterBusiness;
use App\Filament\Resources\DealResource\Widgets\DealStatusChart;
use App\Filament\Widgets\DealStatusStats;
use App\Filament\Widgets\DealsValueTrend;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\TaskStatusStats;
use App\Filament\Widgets\UserAssignmentsTable;
use App\Models\Business;
use Elemind\FilamentECharts\FilamentEChartsPlugin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AppPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('app')
            ->path('app')
            ->viteTheme('resources/css/filament/app/theme.css')
            ->plugins([
                FilamentEChartsPlugin::make(),
            ])
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->tenant(Business::class, slugAttribute: 'slug')
            ->tenantRegistration(RegisterBusiness::class)
            ->tenantProfile(EditBusinessProfile::class)
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
                TaskBoard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\ Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                StatsOverview::class,
                DealStatusStats::class,
                TaskStatusStats::class,
                DealsValueTrend::class,
                DealStatusChart::class,
                UserAssignmentsTable::class,
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
            ]);
    }
}
