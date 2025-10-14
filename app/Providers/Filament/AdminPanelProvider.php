<?php

declare(strict_types=1);

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\Login;
use App\Filament\Pages\Dashboard;
use App\Filament\Pages\Settings;
use App\Filament\Resources\Vacations\VacationResource;
use Filament\Actions\Action;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Jeffgreco13\FilamentBreezy\BreezyCore;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->login(Login::class)
            ->profile()
            // ->strictAuthorization()
            ->colors([
                'success' => Color::Emerald,
                'danger' => Color::Rose,
                'warning' => Color::Amber,
            ])
            ->maxContentWidth(Width::Full)
            ->viteTheme('resources/css/app.css')
            ->brandLogo(fn () => view('filament.brand'))
            ->brandLogoHeight('3rem')
            ->topNavigation()
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->userMenuItems([
                'profile' => fn (Action $action) => $action
                    // ->url(ProfileResource::getUrl('general.view'))
                    ->label(__('auth.profile'))
                    ->icon('heroicon-o-user')
                    ->visible(fn () => auth()->user()->isNurse()),
                Action::make('vacations')
                    ->label(__('vacation.label.plural'))
                    ->url(fn () => VacationResource::getUrl('index'))
                    ->icon(Heroicon::CalendarDateRange)
                    ->visible(fn () => auth()->user()->isNurse()),
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->plugins([
                // BreezyCore::make()
                //     ->myProfile()
                //     ->customMyProfilePage(Settings::class),

            ])
            ->widgets([
                //
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
