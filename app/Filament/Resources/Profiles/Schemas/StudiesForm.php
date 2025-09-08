<?php

declare(strict_types=1);

namespace App\Filament\Resources\Profiles\Schemas;

use App\Enums\StudyType;
use App\Forms\Components\Location;
use App\Forms\Components\Repeater;
use App\Forms\Components\Subsection;
use App\Forms\Components\YearPicker;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class StudiesForm
{
    public static function getSchema(): array
    {
        return [
            Repeater::make('studies')
                ->relationship()
                ->label(__('study.label.plural'))
                ->addActionLabel(__('study.action.create'))
                ->minItems(1)
                ->columnSpanFull()
                ->schema([
                    Subsection::make()
                        ->icon('heroicon-o-academic-cap')
                        ->columns(2)
                        ->schema([
                            TextInput::make('name')
                                ->label(__('field.study_name'))
                                ->placeholder(__('placeholder.study_name'))
                                ->maxLength(200)
                                ->required(),

                            Select::make('type')
                                ->label(__('field.study_type'))
                                ->placeholder(__('placeholder.choose'))
                                ->options(StudyType::options())
                                ->required(),

                            TextInput::make('institution')
                                ->label(__('field.study_institution'))
                                ->placeholder(__('placeholder.study_institution'))
                                ->maxLength(200),

                            TextInput::make('duration')
                                ->label(__('field.study_duration'))
                                ->placeholder(__('placeholder.study_duration'))
                                ->integer()
                                ->minValue(0)
                                ->maxValue(100)
                                ->nullable(),

                            Location::make(),

                            YearPicker::make('start_year')
                                ->label(__('field.start_year'))
                                ->placeholder(__('placeholder.choose'))
                                ->nullable(),

                            YearPicker::make('end_year')
                                ->label(__('field.end_year'))
                                ->placeholder(__('placeholder.choose'))
                                ->after('start_year')
                                ->nullable(),
                        ]),
                ]),

            Subsection::make()
                ->heading(__('study.specialization_section'))
                ->icon('heroicon-o-document-text')
                ->columns(2)
                ->columnSpanFull()
                ->schema([
                    Checkbox::make('has_participated_specialization')
                        ->label(__('field.has_participated_specialization')),

                    Checkbox::make('has_graduated_specialization')
                        ->label(__('field.has_graduated_specialization')),
                ]),
        ];
    }
}
