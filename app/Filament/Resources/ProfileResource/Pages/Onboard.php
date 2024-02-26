<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Filament\Pages\Dashboard;
use App\Filament\Resources\ProfileResource;
use App\Filament\Resources\ProfileResource\Concerns;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Wizard;
use Filament\Resources\Form;
use Filament\Resources\Pages\EditRecord;

class Onboard extends EditRecord
{
    use Concerns\ResolvesRecord;

    protected static string $resource = ProfileResource::class;

    protected function getTitle(): string
    {
        return __('onboarding.step.profile');
    }

    protected function getActions(): array
    {
        return [];
    }

    protected function getBreadcrumbs(): array
    {
        return [];
    }

    protected function getRedirectUrl(): string
    {
        return Dashboard::getUrl();
    }

    protected function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make()
                    ->columnSpanFull()
                    ->skippable()
                    ->steps([
                        Wizard\Step::make(__('onboarding.step.number', ['step' => 1]))
                            ->description(__('user.profile.section.general'))
                            ->schema([
                                Card::make(EditGeneral::getSchema()),
                            ]),

                        Wizard\Step::make(__('onboarding.step.number', ['step' => 2]))
                            ->description(__('user.profile.section.studies'))
                            ->schema([
                                Card::make(EditStudies::getSchema()),
                            ]),

                        Wizard\Step::make(__('onboarding.step.number', ['step' => 3]))
                            ->description(__('user.profile.section.employers'))
                            ->schema([
                                Card::make(EditEmployers::getSchema()),
                            ]),

                        Wizard\Step::make(__('onboarding.step.number', ['step' => 4]))
                            ->description(__('user.profile.section.area'))
                            ->schema([
                                Card::make(EditArea::getSchema()),
                            ]),

                    ])
                    ->submitAction(view('components.onboarding.submit')),

            ]);
    }

    protected function getFormActions(): array
    {
        return [];
    }

    protected function getRelationManagers(): array
    {
        return [];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['profile_completed_at'] = now();

        return $data;
    }
}
