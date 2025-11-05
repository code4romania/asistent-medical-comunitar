<?php

declare(strict_types=1);

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\Login;
use App\Filament\Pages\Settings;
use App\Filament\Pages\Settings\PersonalInfo;
use App\Filament\Resources\Appointments\AppointmentResource;
use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Filament\Resources\Profiles\ProfileResource;
use App\Filament\Resources\Vacations\VacationResource;
use App\Models\User;
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
use Illuminate\Support\Facades\Route;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Jeffgreco13\FilamentBreezy\BreezyCore;
use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin;
use Spatie\Onboard\Facades\Onboard;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->login(Login::class)
            ->colors([
                'success' => Color::Emerald,
                'danger' => Color::Rose,
                'warning' => Color::Amber,
            ])
            ->maxContentWidth(Width::Full)
            ->viteTheme('resources/css/app.css')
            ->brandLogo(fn () => view('components.brand'))
            ->brandLogoHeight('3rem')
            ->topNavigation()
            ->globalSearch(false)
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->resourceEditPageRedirect('view')
            ->readOnlyRelationManagersOnResourceViewPagesByDefault(false)
            ->userMenuItems([
                Action::make('vacations')
                    ->label(__('vacation.label.plural'))
                    ->url(fn () => VacationResource::getUrl('index'))
                    ->icon(Heroicon::CalendarDateRange)
                    ->visible(fn () => auth()->user()->isNurse()),

                Action::make('nurse_profile')
                    ->label(__('auth.profile'))
                    ->url(fn () => ProfileResource::getUrl('index'))
                    ->icon(Heroicon::User)
                    ->visible(fn () => auth()->user()->isNurse()),

                Action::make('settings')
                    ->label(__('auth.settings'))
                    ->url(fn () => Settings::getUrl())
                    ->icon(Heroicon::Cog),
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->plugins([
                BreezyCore::make()
                    ->customMyProfilePage(Settings::class)
                    ->enableTwoFactorAuthentication()
                    // ->enableBrowserSessions()
                    ->myProfile(slug: 'settings', shouldRegisterUserMenu: false)
                    ->myProfileComponents([
                        'personal_info' => PersonalInfo::class,
                    ]),

                FilamentFullCalendarPlugin::make()
                    ->editable(),
            ])
            ->widgets([
                //
            ])
            ->routes(function () {
                Route::get('/welcome/{user:uuid}', \App\Http\Livewire\Welcome::class)->name('auth.welcome');
            })
            ->authenticatedRoutes(function () {
                Route::get('/media/{media:uuid}', \App\Http\Controllers\MediaController::class)->name('media');
            })
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
            ->bootUsing(function (Panel $panel) {
                $this->setupNurseOnboarding();
            })
            ->authMiddleware([
                Authenticate::class,
            ]);
    }

    protected function setupNurseOnboarding(): void
    {
        $isNotANurse = fn (User $model) => ! $model->isNurse();

        Onboard::addStep(__('onboarding.step.profile'))
            ->link(ProfileResource::getUrl('onboard'))
            ->completeIf(fn (User $model) => $model->hasCompletedProfile())
            ->excludeIf($isNotANurse);

        Onboard::addStep(__('onboarding.step.first_beneficiary'))
            ->link(BeneficiaryResource::getUrl('create'))
            ->completeIf(fn (User $model) => $model->beneficiaries()->exists())
            ->excludeIf($isNotANurse);

        Onboard::addStep(__('onboarding.step.first_service'))
            ->completeIf(fn (User $model) => $model->interventions()->onlyIndividualServices()->exists())
            ->excludeIf($isNotANurse);

        Onboard::addStep(__('onboarding.step.first_case'))
            ->completeIf(fn (User $model) => $model->interventions()->onlyCases()->exists())
            ->excludeIf($isNotANurse);

        Onboard::addStep(__('onboarding.step.first_appointment'))
            ->link(AppointmentResource::getUrl('create'))
            ->completeIf(fn (User $model) => $model->appointments()->exists())
            ->excludeIf($isNotANurse);
    }
}
