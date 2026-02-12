<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use App\Filament\Pages\Auth\EditProfile;
use App\Filament\Pages\Dashboard;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Filament\Http\Middleware\AuthenticateSession;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use App\Filament\Resources\HasilPsiResource\Widgets\Layak;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use App\Filament\Resources\HasilPsiResource\Widgets\TidakLayak;
use App\Filament\Resources\DashboardResource\Widgets\DashboardStats;
use App\Filament\Resources\DashboardResource\Widgets\HasilPsiWidget;
use App\Filament\Resources\CalonPenerimaResource\Widgets\BanyakCalon;
use EightyNine\Reports\ReportsPlugin;
use Filament\Support\Facades\FilamentView;
use Illuminate\Support\Facades\Blade;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->authGuard('admin')
            ->brandLogo(fn() => view('admin.logo'))
            ->profile(isSimple: false, page: EditProfile::class)
            ->login()
            ->darkMode(false)
            ->colors([
                'primary' => Color::hex('#10b981'), // Hijau emerald
            ])

            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                HasilPsiWidget::class,
                DashboardStats::class,
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

    public function boot(): void
    {
        FilamentView::registerRenderHook(
            'panels::head.end',
            fn(): string => Blade::render('<style>
                /* Sidebar background */
                .fi-sidebar { background-color: #059669 !important; }

                /* Normal sidebar items - white text */
                .fi-sidebar-item-label { color: white !important; }
                .fi-sidebar-item-icon { color: white !important; }

                /* Active sidebar item - using different selectors */
                .fi-sidebar-item-button.bg-gray-100,
                .fi-sidebar-item-button[aria-current],
                .fi-sidebar-item-button[data-active="true"],
                .fi-sidebar-item.active .fi-sidebar-item-button,
                .fi-sidebar-item[data-active="true"] .fi-sidebar-item-button {
                    background-color: white !important;
                }

                .fi-sidebar-item-button.bg-gray-100 .fi-sidebar-item-label,
                .fi-sidebar-item-button[aria-current] .fi-sidebar-item-label,
                .fi-sidebar-item-button[data-active="true"] .fi-sidebar-item-label,
                .fi-sidebar-item.active .fi-sidebar-item-label,
                .fi-sidebar-item[data-active="true"] .fi-sidebar-item-label {
                    color: #1f2937 !important;
                    font-weight: 600 !important;
                }

                .fi-sidebar-item-button.bg-gray-100 .fi-sidebar-item-icon,
                .fi-sidebar-item-button[aria-current] .fi-sidebar-item-icon,
                .fi-sidebar-item-button[data-active="true"] .fi-sidebar-item-icon,
                .fi-sidebar-item.active .fi-sidebar-item-icon,
                .fi-sidebar-item[data-active="true"] .fi-sidebar-item-icon {
                    color: #1f2937 !important;
                }

                /* Hover effect for non-active items */
                .fi-sidebar-item-button:hover:not(.bg-gray-100):not([aria-current]):not([data-active="true"]) {
                    background-color: rgba(255, 255, 255, 0.15) !important;
                }

                .fi-sidebar-item-button:hover:not(.bg-gray-100):not([aria-current]):not([data-active="true"]) .fi-sidebar-item-label,
                .fi-sidebar-item-button:hover:not(.bg-gray-100):not([aria-current]):not([data-active="true"]) .fi-sidebar-item-icon {
                    color: #f9fafb !important;
                }
                /* Other sidebar elements */
                .fi-sidebar-group-label { color: white !important; font-weight: 500 !important; }
                .fi-sidebar-collapse-button { color: white !important; }
                .fi-sidebar-collapse-button:hover { background-color: #047857 !important; }


            </style>')
        );
    }
}
