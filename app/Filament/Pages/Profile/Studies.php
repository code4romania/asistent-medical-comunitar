<?php

declare(strict_types=1);

namespace App\Filament\Pages\Profile;

use App\Enums\StudyType;
use App\Filament\Pages\Profile;
use App\Forms\Components\Subsection;
use Filament\Forms\Components;
use Filament\Forms\Components\Grid;

class Studies extends Profile
{
    protected function getFormSchema(): array
    {
        return [
            Components\Repeater::make('studies_repeater')->schema([
                Subsection::make()
                ->icon('heroicon-o-academic-cap')
                ->schema([
                    Grid::make([
                        'default' => 1,
                        'sm' => 4,
                        'xl' => 6,
                        '2xl' => 8,
                    ])
                        ->schema([
                            Components\TextInput::make('studies_name')
                                ->label(__('user.profile.studies_page.name'))
                                ->columnSpan([
                                    'sm' => 2,
                                    'xl' => 3,
                                    '2xl' => 4,
                                ]),
                            Components\Select::make('studies_type')
                                ->label(__('user.profile.studies_page.type'))
                                ->columnSpan([
                                    'sm' => 2,
                                    'xl' => 3,
                                    '2xl' => 4,
                                ])
                                ->options($this->getTypeOption()),
                            Components\TextInput::make('studies_emitted_institution')
                                ->label(__('user.profile.studies_page.emitted_institution'))
                                ->columnSpan([
                                    'sm' => 2,
                                    'xl' => 3,
                                    '2xl' => 4,
                                ]),
                            Components\Select::make('studies_duration')
                                ->label(__('user.profile.studies_page.duration'))
                                ->columnSpan([
                                    'sm' => 2,
                                    'xl' => 3,
                                    '2xl' => 4,
                                ]),
                            Components\Select::make('country')
                                ->label(__('user.profile.studies_page.county'))
                                ->columnSpan([
                                    'sm' => 2,
                                    'xl' => 3,
                                    '2xl' => 4,
                                ]),
                            Components\Select::make('city')
                                ->label(__('user.profile.studies_page.city'))
                                ->columnSpan([
                                    'sm' => 2,
                                    'xl' => 3,
                                    '2xl' => 4,
                                ]),
                        ]),
                ]),
                ])
                ->label('Studii')
                ->defaultItems(1)
                ->createItemButtonLabel(__('user.profile.studies_page.add_studies_btn'))
                ->disableItemMovement()
        ];
    }

    private function getTypeOption(): array
    {
        return  collect(StudyType::cases())
            ->mapWithKeys(fn ($type) => [$type->value => __('user.profile.studies_page.' . $type->value)
            ])->toArray();
    }
}
