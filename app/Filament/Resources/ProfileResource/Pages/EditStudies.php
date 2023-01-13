<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Concerns\ResolvesCurrentUserProfile;
use App\Concerns\ResolveTranslateForProfiles;
use App\Enums\StudyType;
use App\Filament\Resources\ProfileResource;
use App\Forms\Components\Subsection;
use App\Models\ProfileStudy;
use App\Services\Helper;
use Filament\Forms\Components;
use Filament\Pages\Actions;
use Filament\Resources\Form;
use Filament\Resources\Pages\EditRecord;

class EditStudies extends EditRecord
{
    use ResolvesCurrentUserProfile, ResolveTranslateForProfiles;

    protected static string $resource = ProfileResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
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
                                        Components\TextInput::make('name')
                                            ->label($this->getTranslationLabel('name'))
                                            ->columnSpan([
                                                'sm' => 2,
                                                'xl' => 3,
                                                '2xl' => 4,
                                            ]),
                                        Components\Select::make('type')
                                            ->label($this->getTranslationLabel('type'))
                                            ->options($this->getTypes())
                                            ->columnSpan([
                                                'sm' => 2,
                                                'xl' => 3,
                                                '2xl' => 4,
                                            ]),
                                        Components\TextInput::make('emitted_institution')
                                            ->label($this->getTranslationLabel('emitted_institution'))
                                            ->columnSpan([
                                                'sm' => 2,
                                                'xl' => 3,
                                                '2xl' => 4,
                                            ]),
                                        Components\TextInput::make('duration')
                                            ->label($this->getTranslationLabel('duration'))
                                            ->columnSpan([
                                                'sm' => 2,
                                                'xl' => 3,
                                                '2xl' => 4,
                                            ]),
                                        Components\Select::make('county_id')
                                            ->label($this->getTranslationLabel('county'))
                                            ->relationship('county', 'name')
                                            ->columnSpan([
                                                'sm' => 2,
                                                'xl' => 3,
                                                '2xl' => 4,
                                            ]),
                                        Components\Select::make('city_id')
                                            ->label($this->getTranslationLabel('city'))
                                            ->relationship('city', 'name')
                                            ->columnSpan([
                                                'sm' => 2,
                                                'xl' => 3,
                                                '2xl' => 4,
                                            ]),
                                        Components\Select::make('start_year')
                                            ->label($this->getTranslationLabel('start_year'))
                                            ->options(
                                                Helper::generateYearsOptions()
                                            )
                                            ->searchable()
                                            ->required()
                                            ->columnSpan([
                                                'sm' => 2,
                                                'xl' => 3,
                                                '2xl' => 4,
                                            ]),
                                        Components\Select::make('end_year')
                                            ->label($this->getTranslationLabel('end_year'))
                                            ->options(
                                                Helper::generateYearsOptions()
                                            )
                                            ->searchable()
                                            ->after('start_year')
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
    private static function getTypes(): array
    {
        return  collect(StudyType::values())
            ->mapWithKeys(fn ($type) => [$type => __('user.profile.studies_page.' . $type)
            ])->toArray();
    }
}
