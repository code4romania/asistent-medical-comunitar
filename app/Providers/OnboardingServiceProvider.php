<?php

declare(strict_types=1);

namespace App\Providers;

use App\Filament\Resources\Appointments\AppointmentResource;
use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Filament\Resources\Profiles\ProfileResource;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;
use Spatie\Onboard\Facades\Onboard;

class OnboardingServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Filament::serving(function () {
            $this->setupNurseOnboarding();
        });
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
