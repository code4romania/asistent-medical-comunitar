<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Enums\EmployerType;
use App\Forms\Components\Location;
use App\Forms\Components\Subsection;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;

class EditEmployers extends EditRecord
{
    protected function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Repeater::make('studies')
                    ->relationship()
                    ->label(__('user.profile.section.employers'))
                    ->schema([
                        Subsection::make()
                            ->icon('heroicon-o-office-building')
                            ->columns(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label(__('user.profile.field.employer.name')),
                                Select::make('type')
                                    ->label(__('user.profile.field.employer.type'))
                                    ->options(EmployerType::options())
                                    ->required(),
                                TextInput::make('project_name')
                                    ->label(__('user.profile.field.employer.project')),
                                Location::make(),
                                DatePicker::make('start_date')
                                    ->label(__('user.profile.field.start_date')),
                                DatePicker::make('end_date')
                                    ->label(__('user.profile.field.end_date')),
                            ]),
                    ]),
            ]);
    }
}
