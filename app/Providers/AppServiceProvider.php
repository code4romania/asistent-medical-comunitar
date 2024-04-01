<?php

declare(strict_types=1);

namespace App\Providers;

use Aedart\Antivirus\Validation\Rules\InfectionFreeFile;
use App\Filament\Pages\Settings;
use App\Filament\Resources\ProfileResource;
use App\Filament\Resources\VacationResource;
use Filament\Facades\Filament;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Navigation\UserMenuItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\Vite;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use JeffGreco13\FilamentBreezy\FilamentBreezy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCarbonMacros();

        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }

        Config::set('sentry.release', $this->getAppVersion());
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->enforceMorphMap();

        tap($this->app->isLocal(), function (bool $shouldBeEnabled) {
            Model::preventLazyLoading($shouldBeEnabled);
            Model::preventAccessingMissingAttributes($shouldBeEnabled);
        });

        Filament::serving(function () {
            Filament::registerViteTheme('resources/css/app.css');
            Filament::registerScripts([
                app(Vite::class)('resources/js/app.js'),
            ]);

            $this->registerUserMenuItems();
        });

        Filament::registerRenderHook('head.end', fn () => view('components.favicons'));
        Filament::registerRenderHook('footer.end', fn () => $this->getAppVersion());

        $this->setPasswordDefaults();

        SpatieMediaLibraryFileUpload::configureUsing(function (SpatieMediaLibraryFileUpload $component) {
            $component->rule(new InfectionFreeFile);
        });
    }

    /**
     * Read the application version.
     *
     * @return string
     */
    public function getAppVersion(): string
    {
        $version = base_path('.version');

        if (! file_exists($version)) {
            return 'develop';
        }

        return trim(file_get_contents($version));
    }

    private static function passwordDefaults(): Password
    {
        return Password::min(8)
            ->uncompromised();
    }

    protected function setPasswordDefaults(): void
    {
        Password::defaults(function () {
            return static::passwordDefaults();
        });

        FilamentBreezy::setPasswordRules([
            static::passwordDefaults(),
        ]);
    }

    protected function registerCarbonMacros(): void
    {
        Carbon::macro('toFormattedDate', fn () => $this->translatedFormat(config('forms.components.date_time_picker.display_formats.date')));
        Carbon::macro('toFormattedDateTime', fn () => $this->translatedFormat(config('forms.components.date_time_picker.display_formats.date_time')));
        Carbon::macro('toFormattedDateTimeWithSeconds', fn () => $this->translatedFormat(config('forms.components.date_time_picker.display_formats.date_time_with_seconds')));
        Carbon::macro('toFormattedTime', fn () => $this->translatedFormat(config('forms.components.date_time_picker.display_formats.time')));
        Carbon::macro('toFormattedTimeWithSeconds', fn () => $this->translatedFormat(config('forms.components.date_time_picker.display_formats.time_with_seconds')));
    }

    protected function enforceMorphMap(): void
    {
        Relation::enforceMorphMap([
            'appointment' => \App\Models\Appointment::class,
            'beneficiary' => \App\Models\Beneficiary::class,
            'case' => \App\Models\Intervention\InterventionableCase::class,
            'catagraphy' => \App\Models\Catagraphy::class,
            'community_activity' => \App\Models\CommunityActivity::class,
            'city' => \App\Models\City::class,
            'county' => \App\Models\County::class,
            'document' => \App\Models\Document::class,
            'family' => \App\Models\Family::class,
            'household' => \App\Models\Household::class,
            'individual_service' => \App\Models\Intervention\InterventionableIndividualService::class,
            'intervention' => \App\Models\Intervention::class,
            'ocasional_intervention' => \App\Models\Intervention\OcasionalIntervention::class,
            'profile_course' => \App\Models\Profile\Course::class,
            'profile_employer' => \App\Models\Profile\Employer::class,
            'profile_study' => \App\Models\Profile\Study::class,
            'user' => \App\Models\User::class,
        ]);
    }

    protected function registerUserMenuItems(): void
    {
        if (auth()->guest()) {
            return;
        }

        $items = [
            'settings' => UserMenuItem::make()
                ->url(Settings::getUrl())
                ->label(__('auth.settings'))
                ->icon('heroicon-o-cog'),
        ];

        if (auth()->user()->isNurse()) {
            $items['profile'] = UserMenuItem::make()
                ->url(ProfileResource::getUrl('general.view'))
                ->label(__('auth.profile'))
                ->icon('heroicon-o-user');

            $items['vacations'] = UserMenuItem::make()
                ->url(VacationResource::getUrl('index'))
                ->label(__('vacation.label.plural'))
                ->icon('heroicon-o-calendar');
        }

        Filament::registerUserMenuItems($items);
    }
}
