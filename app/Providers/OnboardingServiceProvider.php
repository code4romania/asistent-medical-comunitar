<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Spatie\Onboard\Facades\Onboard;

class OnboardingServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->setupNurseOnboarding();
    }

    protected function setupNurseOnboarding(): void
    {
        $isNotANurse = fn (User $model) => ! $model->isNurse();

        Onboard::addStep(__('onboarding.step.profile'))
            ->excludeIf($isNotANurse);

        Onboard::addStep(__('onboarding.step.first_beneficiary'))
            ->excludeIf($isNotANurse);

        Onboard::addStep(__('onboarding.step.first_service'))
            ->excludeIf($isNotANurse);

        Onboard::addStep(__('onboarding.step.first_case'))
            ->excludeIf($isNotANurse);

        Onboard::addStep(__('onboarding.step.first_appointment'))
            ->excludeIf($isNotANurse);
    }
}
