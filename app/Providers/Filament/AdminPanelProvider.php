<?php

namespace App\Providers\Filament;

use Filament\Enums\ThemeMode;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->defaultThemeMode(ThemeMode::System)
            ->darkMode(true)
            ->colors([
                'primary' => '#8B0000',
                'danger' => '#dc2626',
                'success' => '#10b981',
                'warning' => '#f59e0b',
                'gray' => '#4b5563',
                'info' => '#0891b2',
            ])
            ->font('Inter')
            ->brandName('IUEA Voting System')
            ->brandLogo(asset('images/iuea-logo.png'))
            ->brandLogoHeight('4rem')
            ->favicon(asset('images/favicon.ico'))
            ->authGuard('web')
            ->authMiddleware([
                Authenticate::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                \App\Http\Middleware\AdminPermissionsMiddleware::class,
            ])
            ->discoverResources(app_path('Filament/Resources'), 'App\\Filament\\Resources')
            ->discoverPages(app_path('Filament/Pages'), 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(app_path('Filament/Widgets'), 'App\\Filament\\Widgets')
            ->widgets([
                \App\Filament\Widgets\TotalCandidatesStats::class,
                \App\Filament\Widgets\SectorStats::class,
            ])
            ->renderHook(
                'panels::brand',
                fn (): string => '
                    <div style="background: white; border-radius: 12px; padding: 10px; margin: 15px; display: flex; align-items: center; justify-content: center;">
                        <img src="' . asset('images/iuea-logo.png') . '" style="height: 40px; width: auto; margin-right: 8px;">
                        <div>
                            <div style="color: #8B0000; font-weight: bold; font-size: 13px;">Voting</div>
                            <div style="color: #8B0000; font-weight: bold; font-size: 11px;">System</div>
                        </div>
                    </div>
                '
            )
            ->renderHook(
                'panels::head.end',
                fn () => view('components.admin-styles') . '<link rel="stylesheet" href="' . asset('css/admin-custom.css') . '">',
            );
    }
}
