<?php

declare(strict_types=1);

namespace App\Filament\Resources\Profiles\Schemas;

use App\Enums\StudyType;
use App\Filament\Forms\Components\Location;
use App\Filament\Forms\Components\YearPicker;
use App\Filament\Schemas\Components\Subsection;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class StudiesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Repeater::make('studies')
                    ->relationship()
                    ->label(__('user.profile.section.studies'))
                    ->hiddenLabel()
                    ->addActionLabel(__('study.action.create'))
                    ->minItems(1)
                    ->schema([
                        Subsection::make()
                            ->icon(Heroicon::OutlinedAcademicCap)
                            ->columns()
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
                    ->icon(Heroicon::OutlinedDocumentText)
                    ->columns()
                    ->schema([
                        Checkbox::make('has_participated_specialization')
                            ->label(__('field.has_participated_specialization')),

                        Checkbox::make('has_graduated_specialization')
                            ->label(__('field.has_graduated_specialization')),
                    ]),
            ]);
    }
}
