<?php

declare(strict_types=1);

namespace App\Filament\Resources\Profiles\Pages;

use App\Filament\Resources\Profiles\Concerns\ResolvesRecord;
use App\Filament\Resources\Profiles\Pages\EditArea;
use App\Filament\Resources\Profiles\Pages\EditEmployers;
use App\Filament\Resources\Profiles\Pages\EditGeneral;
use App\Filament\Resources\Profiles\Pages\EditStudies;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Components\Section;
use App\Filament\Pages\Dashboard;
use App\Filament\Resources\Profiles\ProfileResource;
use App\Filament\Resources\ProfileResource\Concerns;
use Filament\Resources\Pages\EditRecord;

class Onboard extends EditRecord
{
    use ResolvesRecord;

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

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getBreadcrumbs(): array
    {
        return [];
    }

    protected function getRedirectUrl(): string
    {
        return Dashboard::getUrl();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make()
                    ->columnSpanFull()
                    ->steps([
                        Step::make(__('onboarding.step.number', ['step' => 1]))
                            ->description(__('user.profile.section.general'))
                            ->schema([
                                Section::make(EditGeneral::getSchema()),
                            ]),

                        Step::make(__('onboarding.step.number', ['step' => 2]))
                            ->description(__('user.profile.section.studies'))
                            ->schema([
                                Section::make(EditStudies::getSchema()),
                            ]),

                        Step::make(__('onboarding.step.number', ['step' => 3]))
                            ->description(__('user.profile.section.employers'))
                            ->schema([
                                Section::make(EditEmployers::getSchema()),
                            ]),

                        Step::make(__('onboarding.step.number', ['step' => 4]))
                            ->description(__('user.profile.section.area'))
                            ->schema([
                                Section::make(EditArea::getSchema()),
                            ]),

                    ])
                    ->submitAction(view('components.onboarding.submit')),

            ]);
    }

    protected function getFormActions(): array
    {
        return [];
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
