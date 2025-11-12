<?php

declare(strict_types=1);

namespace App\Filament\Resources\Profiles\Pages;

use App\Filament\Pages\Dashboard;
use App\Filament\Resources\Profiles\Concerns\ResolvesRecord;
use App\Filament\Resources\Profiles\ProfileResource;
use App\Filament\Resources\Profiles\Schemas\AreaForm;
use App\Filament\Resources\Profiles\Schemas\EmployersForm;
use App\Filament\Resources\Profiles\Schemas\GeneralForm;
use App\Filament\Resources\Profiles\Schemas\StudiesForm;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\EditRecord\Concerns\HasWizard;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;

class Onboard extends EditRecord
{
    use ResolvesRecord;
    use HasWizard;

    protected static string $resource = ProfileResource::class;

    protected function authorizeAccess(): void
    {
        if (! $this->getRecord()?->isNurse()) {
            redirect()->to(Dashboard::getUrl());

            return;
        }
    }

    public function getTitle(): string
    {
        return __('onboarding.step.profile');
    }

    public function getBreadcrumbs(): array
    {
        return [];
    }

    protected function getRedirectUrl(): string
    {
        return Dashboard::getUrl();
    }

    public function getSteps(): array
    {
        return [
            Step::make(__('onboarding.step.number', ['step' => 1]))
                ->description(__('user.profile.section.general'))
                ->components([
                    Section::make()
                        ->components(fn (Schema $schema) => GeneralForm::configure($schema)),
                ]),

            Step::make(__('onboarding.step.number', ['step' => 2]))
                ->description(__('user.profile.section.studies'))
                ->components([
                    Section::make()
                        ->components(fn (Schema $schema) => StudiesForm::configure($schema)),
                ]),

            Step::make(__('onboarding.step.number', ['step' => 3]))
                ->description(__('user.profile.section.employers'))
                ->components([
                    Section::make()
                        ->components(fn (Schema $schema) => EmployersForm::configure($schema)),
                ]),

            Step::make(__('onboarding.step.number', ['step' => 4]))
                ->description(__('user.profile.section.area'))
                ->components([
                    Section::make()
                        ->components(fn (Schema $schema) => AreaForm::configure($schema)),
                ]),
        ];
    }

    protected function getSaveFormAction(): Action
    {
        return parent::getSaveFormAction()
            ->label(__('onboarding.finish'));
    }

    public function getRelationManagers(): array
    {
        return [];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['profile_completed_at'] = now();

        return $data;
    }
}
