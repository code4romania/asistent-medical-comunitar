<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Enums\StudyType;
use App\Forms\Components\Location;
use App\Forms\Components\Subsection;
use App\Services\Helper;
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
                    ->label('user.profile.section.studies')
                    ->translateLabel()
                    ->defaultItems(1)
                    ->schema([
                        Subsection::make()
                            ->icon('heroicon-o-academic-cap')
                            ->columns(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label(__('user.profile.field.study.name'))
                                    ->maxLength(50)
                                    ->required(),
                                Select::make('type')
                                    ->label(__('user.profile.field.study.type'))
                                    ->options(StudyType::options())
                                    ->required(),
                                TextInput::make('institution')
                                    ->label(__('user.profile.field.study.institution')),
                                TextInput::make('duration')
                                    ->label(__('user.profile.field.study.duration'))
                                    ->integer()
                                    ->nullable(),
                                Location::make(),
                                Select::make('start_year')
                                    ->label(__('user.profile.field.start_date'))
                                    ->options(
                                        Helper::generateYearsOptions()
                                    )
                                    ->searchable()
                                    ->nullable(),
                                Select::make('end_year')
                                    ->label('user.profile.field.end_date')
                                    ->translateLabel()
                                    ->options(
                                        Helper::generateYearsOptions()
                                    )
                                    ->searchable()
                                    ->after('start_year')
                                    ->nullable(),
                            ]),
                    ]),
            ]);
    }
}
