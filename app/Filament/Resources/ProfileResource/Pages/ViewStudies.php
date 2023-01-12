<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Concerns\ResolvesCurrentUserProfile;
use App\Concerns\ResolveTranslateForProfiles;
use App\Filament\Resources\ProfileResource;
use App\Forms\Components\Subsection;
use App\Models\ProfileStudy;
use App\Models\User;
use Filament\Forms\Components;
use Filament\Pages\Actions;
use Filament\Resources\Form;
use Filament\Resources\Pages\ViewRecord;

class ViewStudies extends ViewRecord
{
    use ResolvesCurrentUserProfile, ResolveTranslateForProfiles;

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
                    ->relationship('studies')
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
                                            ->content(fn (ProfileStudy $record) => $record->name)
                                            ->columnSpan([
                                                'sm' => 2,
                                                'xl' => 3,
                                                '2xl' => 4,
                                            ]),
                                        Components\Placeholder::make('type')
                                            ->label($this->getTranslationLabel('type'))
                                            ->content(fn (ProfileStudy $record) => __('user.profile.studies_page.'.$record->type))
                                            ->columnSpan([
                                                'sm' => 2,
                                                'xl' => 3,
                                                '2xl' => 4,
                                            ]),
                                        Components\Placeholder::make('emitted_institution')
                                            ->label($this->getTranslationLabel('emitted_institution'))
                                            ->content(fn (ProfileStudy $record) => $record->emitted_institution)
                                            ->columnSpan([
                                                'sm' => 2,
                                                'xl' => 3,
                                                '2xl' => 4,
                                            ]),
                                        Components\Placeholder::make('duration')
                                            ->label($this->getTranslationLabel('duration'))
                                            ->content(fn (ProfileStudy $record) => $record->duration)
                                            ->columnSpan([
                                                'sm' => 2,
                                                'xl' => 3,
                                                '2xl' => 4,
                                            ]),
                                        Components\Placeholder::make('county_id')
                                            ->label($this->getTranslationLabel('county'))
                                            ->content(fn (ProfileStudy $record) => $record->county->name)
                                            ->columnSpan([
                                                'sm' => 2,
                                                'xl' => 3,
                                                '2xl' => 4,
                                            ]),
                                        Components\Placeholder::make('city_id')
                                            ->label($this->getTranslationLabel('city'))
                                            ->content(fn (ProfileStudy $record) => $record->city->name)
                                            ->columnSpan([
                                                'sm' => 2,
                                                'xl' => 3,
                                                '2xl' => 4,
                                            ]),
                                        Components\Placeholder::make('start_year')
                                            ->label($this->getTranslationLabel('start_year'))
                                            ->content(fn (ProfileStudy $record) => $record->start_year)
                                            ->columnSpan([
                                                'sm' => 2,
                                                'xl' => 3,
                                                '2xl' => 4,
                                            ]),
                                        Components\Placeholder::make('end_year')
                                            ->label($this->getTranslationLabel('end_year'))
                                            ->content(fn (ProfileStudy $record) => $record->end_year)
                                            ->columnSpan([
                                                'sm' => 2,
                                                'xl' => 3,
                                                '2xl' => 4,
                                            ]),
                                    ]),
                            ]),
                    ])
                    ->label($this->getTranslationLabel('title'))
                    ->defaultItems(1)
                    ->createItemButtonLabel($this->getTranslationLabel('add_btn'))
                    ->disableItemMovement(),
            ])
            ->columns(1);
    }
}
