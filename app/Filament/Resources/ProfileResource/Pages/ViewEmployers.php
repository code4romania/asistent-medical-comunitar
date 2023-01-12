<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Concerns\ResolvesCurrentUserProfile;
use App\Filament\Resources\ProfileResource;
use App\Forms\Components\Subsection;
use App\Models\ProfileEmployer;
use Filament\Forms\Components;
use Filament\Pages\Actions;
use Filament\Resources\Form;
use Filament\Resources\Pages\ViewRecord;

class ViewEmployers extends ViewRecord
{
    use ResolvesCurrentUserProfile;

    protected static string $resource = ProfileResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    protected function form(Form $form): Form
    {
        return $form
            ->schema([
                Components\Repeater::make('studies_repeater')
                    ->relationship('employers')
                    ->schema([
                        Subsection::make()
                            ->icon('heroicon-o-academic-cap')
                            ->schema([
                                Components\Grid::make([
                                    'default' => 1,
                                    'sm' => 4,
                                    'xl' => 6,
                                    '2xl' => 8,
                                ])
                                    ->schema([
                                        Components\Placeholder::make('name')
                                            ->label($this->getTranslationLabel('name'))
                                            ->content(fn (ProfileEmployer $record) => $record->name)
                                            ->columnSpan([
                                                'sm' => 2,
                                                'xl' => 3,
                                                '2xl' => 4,
                                            ]),
                                        Components\Placeholder::make('type')
                                            ->label($this->getTranslationLabel('type'))
                                            ->content(fn (ProfileEmployer $record) => $this->getTranslationLabel('' . $record->type))
                                            ->columnSpan([
                                                'sm' => 2,
                                                'xl' => 3,
                                                '2xl' => 4,
                                            ]),
                                        Components\Placeholder::make('project_name')
                                            ->label($this->getTranslationLabel('duration'))
                                            ->content(fn (ProfileEmployer $record) => $record->project_name)
                                            ->columnSpan([
                                                'sm' => 2,
                                                'xl' => 3,
                                                '2xl' => 4,
                                            ])->hidden(fn (ProfileEmployer $record) => empty($record->project_name)),
                                        Components\Placeholder::make('country_id')
                                            ->label($this->getTranslationLabel('county'))
                                            ->content(fn (ProfileEmployer $record) => $record->county->name)
                                            ->columnSpan([
                                                'sm' => 2,
                                                'xl' => 3,
                                                '2xl' => 4,
                                            ]),
                                        Components\Placeholder::make('city_id')
                                            ->label($this->getTranslationLabel('city'))
                                            ->content(fn (ProfileEmployer $record) => $record->city->name)
                                            ->columnSpan([
                                                'sm' => 2,
                                                'xl' => 3,
                                                '2xl' => 4,
                                            ]),
                                        Components\Placeholder::make('start_date')
                                            ->label($this->getTranslationLabel('start_date'))
                                            ->content(fn (ProfileEmployer $record) => $record->start_date)
                                            ->columnSpan([
                                                'sm' => 2,
                                                'xl' => 3,
                                                '2xl' => 4,
                                            ]),
                                        Components\Placeholder::make('end_date')
                                            ->label($this->getTranslationLabel('end_date'))
                                            ->content(fn (ProfileEmployer $record) => $record->end_date)
                                            ->columnSpan([
                                                'sm' => 2,
                                                'xl' => 3,
                                                '2xl' => 4,
                                            ]),
                                    ]),
                            ]),
                    ])
                    ->label(__('user.profile.employers'))
                    ->defaultItems(1)
                    ->createItemButtonLabel($this->getTranslationLabel('add_btn'))
                    ->disableItemMovement(),
            ])
            ->columns(1);
    }

    protected function getRelationManagers(): array
    {
        return [
        ];
    }

    private function getTranslationLabel(string $key): string
    {
        return __('user.profile.employers_page.' . $key);
    }
}
