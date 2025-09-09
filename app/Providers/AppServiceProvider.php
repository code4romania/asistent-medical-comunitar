<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Appointment;
use App\Models\Beneficiary;
use App\Models\Catagraphy;
use App\Models\City;
use App\Models\CommunityActivity;
use App\Models\County;
use App\Models\Disability;
use App\Models\Disease;
use App\Models\Document;
use App\Models\Family;
use App\Models\Household;
use App\Models\Intervention;
use App\Models\Intervention\InterventionableCase;
use App\Models\Intervention\InterventionableIndividualService;
use App\Models\Intervention\OcasionalIntervention;
use App\Models\Profile\Course;
use App\Models\Profile\Employer;
use App\Models\Profile\Study;
use App\Models\Suspicion;
use App\Models\User;
use App\Models\Vacation;
use App\Models\Vulnerability\Vulnerability;
use App\Models\Vulnerability\VulnerabilityCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
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
        $this->registerTelescope();
        $this->registerQueryMacros();
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

        $this->setPasswordDefaults();
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

        // FilamentBreezy::setPasswordRules([
        //     static::passwordDefaults(),
        // ]);
    }

    protected function registerTelescope(): void
    {
        if (
            ! $this->app->environment('local') ||
            ! class_exists(\Laravel\Telescope\TelescopeServiceProvider::class, false)
        ) {
            return;
        }

        $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
        $this->app->register(TelescopeServiceProvider::class);
    }

    // TODO: remove this when migrating to Laravel 11.x
    protected function registerQueryMacros(): void
    {
        Builder::macro('whereJsonOverlaps', function (string $column, $value, bool $not = false): Builder {
            $not = $not ? 'not ' : '';

            return $this->whereRaw($not . 'json_overlaps(`' . $column . '`, ?)', [
                collect($value)->toJson(),
            ]);
        });

        Builder::macro('whereJsonDoesntOverlap', function (string $column, $value): Builder {
            return $this->whereJsonOverlaps($column, $value, true);
        });
    }

    protected function enforceMorphMap(): void
    {
        Relation::enforceMorphMap([
            'appointment' => Appointment::class,
            'beneficiary' => Beneficiary::class,
            'case' => InterventionableCase::class,
            'catagraphy' => Catagraphy::class,
            'community_activity' => CommunityActivity::class,
            'city' => City::class,
            'county' => County::class,
            'disability' => Disability::class,
            'disease' => Disease::class,
            'document' => Document::class,
            'family' => Family::class,
            'household' => Household::class,
            'individual_service' => InterventionableIndividualService::class,
            'intervention' => Intervention::class,
            'ocasional_intervention' => OcasionalIntervention::class,
            'profile_course' => Course::class,
            'profile_employer' => Employer::class,
            'profile_study' => Study::class,
            'suspicion' => Suspicion::class,
            'user' => User::class,
            'vulnerability' => Vulnerability::class,
            'vulnerability_category' => VulnerabilityCategory::class,
            'vacation' => Vacation::class,
        ]);
    }
}
