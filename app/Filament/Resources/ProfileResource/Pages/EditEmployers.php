<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Enums\EmployerType;
use App\Forms\Components\Location;
use App\Forms\Components\Subsection;
use App\Models\Profile\Employer;
use Filament\Forms\Components\Checkbox;
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
                Repeater::make('employers')
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
                                Checkbox::make('project_base'),
//                                    ->hidden(fn(Employer $record) => empty($record->project_name)),
                                TextInput::make('project')
                                    ->label(__('user.profile.field.employer.project')),
                                Location::make(),
                                DatePicker::make('start_date')
                                    ->label(__('user.profile.field.start_date')),
                                DatePicker::make('end_date')
                                    ->afterOrEqual('start_date')
                                    ->label(__('user.profile.field.end_date')),
                            ]),
                    ]),
            ]);
    }
}
