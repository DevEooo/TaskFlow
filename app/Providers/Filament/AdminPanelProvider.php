<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use App\Filament\Resources\Admin\BulkTugas\BulkTugasResource;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Filament\Widgets\Admin\TugasStatsOverview as TugasOverview;
use App\Filament\Widgets\Admin\AttendanceLocationWidget as Attendance;
use App\Filament\Widgets\Admin\UndoneTaskWidget as UTaskWidget;
use App\Filament\Widgets\Admin\SummarizeChartWidget as SummarizeChart;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('admin')
            ->path('admin')
            ->databaseNotifications()
            ->databaseNotificationsPolling('30s')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources/Admin'), for: 'App\\Filament\\Resources\\Admin')
            ->discoverPages(in: app_path('Filament/Pages/Admin'), for: 'App\\Filament\\Pages\\Admin')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->resources([
                BulkTugasResource::class, 
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets/Admin'), for: 'App\\Filament\\Widgets\\Admin')
            ->widgets([
                \App\Filament\Widgets\CustomAccountWidget::class,
                TugasOverview::class,
                Attendance::class,
                UTaskWidget::class,
                SummarizeChart::class,
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
                \App\Http\Middleware\AdminMiddleware::class,
            ])
            ->authGuard('web');
    }
}
