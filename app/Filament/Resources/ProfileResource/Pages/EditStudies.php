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
                                    ->label('user.profile.field.study.name')
                                    ->translateLabel(),
                                Select::make('type')
                                    ->label('user.profile.field.study.type')
                                    ->translateLabel()
                                    ->options(StudyType::options()),
                                TextInput::make('institution')
                                    ->label('user.profile.field.study.institution')
                                    ->translateLabel(),
                                TextInput::make('duration')
                                    ->label('user.profile.field.study.duration')
                                    ->translateLabel()
                                    ->integer()
                                    ->nullable(),
                                Location::make(),
                                Select::make('start_year')
                                    ->label('user.profile.field.start_date')
                                    ->translateLabel()
                                    ->options(
                                        Helper::generateYearsOptions()
                                    )
                                    ->searchable(),
                                Select::make('end_year')
                                    ->label('user.profile.field.end_date')
                                    ->translateLabel()
                                    ->options(
                                        Helper::generateYearsOptions()
                                    )
                                    ->searchable()
                                    ->after('start_year'),
                            ]),
                    ]),
            ]);
    }
}
