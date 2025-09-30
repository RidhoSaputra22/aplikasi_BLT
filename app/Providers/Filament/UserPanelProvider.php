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
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Support\Facades\FilamentView;
use Illuminate\Support\Facades\Blade;


class UserPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('user')
            ->path('user')
            ->authGuard('web')
            ->login()
            ->darkMode(false)
            ->colors([
                'primary' => Color::Green,
            ])
            ->discoverResources(in: app_path('Filament/User/Resources'), for: 'App\\Filament\\User\\Resources')
            ->discoverPages(in: app_path('Filament/User/Pages'), for: 'App\\Filament\\User\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/User/Widgets'), for: 'App\\Filament\\User\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
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

                /* Sidebar header */
                .fi-sidebar-header { background-color: #047857 !important; }

                /* Top bar */
                .fi-topbar { background-color: #10b981 !important; }
                .fi-topbar .fi-application-name { color: white !important; }
                .fi-topbar .fi-user-menu-trigger { color: white !important; }

                /* Other sidebar elements */
                .fi-logo { filter: invert(1) !important; }
                .fi-sidebar-group-label { color: white !important; font-weight: 500 !important; }
                .fi-sidebar-collapse-button { color: white !important; }
                .fi-sidebar-collapse-button:hover { background-color: #047857 !important; }

                /* Badge styling */
                .fi-sidebar .fi-badge {
                    background-color: rgba(255, 255, 255, 0.2) !important;
                    color: white !important;
                }
            </style>')
        );
    }
}
