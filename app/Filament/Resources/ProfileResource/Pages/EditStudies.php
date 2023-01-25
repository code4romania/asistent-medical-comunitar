<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Enums\StudyType;
use App\Forms\Components\Location;
use App\Forms\Components\Subsection;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;

class EditStudies extends EditRecord
{
    protected function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Repeater::make('studies')
                    ->relationship()
                    ->label(__('study.label.plural'))
                    ->createItemButtonLabel(__('study.action.create'))
                    ->schema([
                        Subsection::make()
                            ->icon('heroicon-o-academic-cap')
                            ->columns(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label(__('field.study_name'))
                                    ->maxLength(50)
                                    ->required(),
                                Select::make('type')
                                    ->label(__('field.study_type'))
                                    ->options(StudyType::options())
                                    ->required(),
                                TextInput::make('institution')
                                    ->label(__('field.study_institution')),
                                TextInput::make('duration')
                                    ->label(__('field.study_duration'))
                                    ->integer()
                                    ->nullable(),
                                Location::make(),
                                Select::make('start_year')
                                    ->label(__('field.start_year'))
                                    ->options($this->generateYearsOptions())
                                    ->nullable(),
                                Select::make('end_year')
                                    ->label(__('field.end_year'))
                                    ->options($this->generateYearsOptions())
                                    ->after('start_year')
                                    ->nullable(),
                            ]),
                    ]),
            ]);
    }

    private function generateYearsOptions(): array
    {
        return range(today()->year, 1950);
    }
}
