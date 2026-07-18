<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Pages\Dashboard;
use Filament\Support\Assets\Js;
use Filament\Support\Assets\Css;
use App\Filament\Pages\PrintLabel;
use Filament\Support\Colors\Color;
use App\Livewire\PrintByLabelGroup;
use Filament\Widgets\AccountWidget;
use Illuminate\Support\Facades\Vite;
use App\Livewire\PrintByLabelGroupForm;
use Filament\Http\Middleware\Authenticate;
use App\Filament\Pages\BatchLabelPrintingPage;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Support\Icons\Heroicon;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

class LoginPanelProvider extends PanelProvider
{
   public function panel(Panel $panel): Panel
   {
      return $panel
         ->default()
         ->id('login')
         ->path('/')
         ->login()
         ->colors([
            'primary' => "#f78e27",
         ])
         ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
         ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
         ->pages([
            Dashboard::class,
         ])
         ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
         ->widgets([
            AccountWidget::class,
            // Widgets\FilamentInfoWidget::class,
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
         ])
         ->viteTheme(['resources/css/filament/login/theme.css'])
         ->brandLogo(asset('/images/logo-corel.svg'))
         ->favicon(asset('/images/favicon.png'))
         ->darkMode(false)
         ->navigationGroups(([
            NavigationGroup::make()
               ->label('Impressão')
               ->collapsible(false)
               ->icon('heroicon-o-printer'),

            NavigationGroup::make()
               ->label('Configurações')
               ->collapsed()
               ->icon(Heroicon::OutlinedCog6Tooth),
         ]))
         ->spa();
   }
}
