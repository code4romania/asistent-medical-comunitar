<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Enums\EmployerType;
use App\Forms\Components\Location;
use App\Forms\Components\Subsection;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
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
                                    ->options(EmployerType::options()),
                                Group::make()
                                    ->extraAttributes(['class' => 'flex justify-end'])
                                    ->columnSpanFull()
                                    ->schema([
                                        Checkbox::make('is_project_based')
                                            ->label(__('user.profile.field.employer.project_based'))
                                            ->reactive()
                                            ->afterStateUpdated(function (callable $set) {
                                                $set('project', null);
                                            }),
                                    ]),
                                TextInput::make('project')
                                    ->label(__('user.profile.field.employer.project'))
                                    ->hidden(function (callable $get) {
                                        return $get('is_project_based') === false;
                                    })
                                    ->reactive()
                                    ->afterStateHydrated(function (callable $set, $state) {
                                        $set('is_project_based', $state !== null);
                                    })
                                    ->columnSpanFull(),
                                Location::make(),
                                DatePicker::make('start_date')
                                    ->label(__('user.profile.field.start_date')),
                                DatePicker::make('end_date')
                                    ->label(__('user.profile.field.end_date'))
                                    ->afterOrEqual('start_date')
                                    ->disabled(function (callable $get) {
                                        return $get('is_ongoing') === true;
                                    })
                                    ->afterStateHydrated(function (callable $set, $state) {
                                        $set('is_ongoing', $state === null);
                                    }),
                                Group::make()
                                    ->extraAttributes(['class' => 'flex justify-end'])
                                    ->columnSpanFull()
                                    ->schema([
                                        Checkbox::make('is_ongoing')
                                            ->label(__('user.profile.field.employer.ongoing'))
                                            ->reactive()
                                            ->afterStateUpdated(function (callable $set) {
                                                $set('end_date', null);
                                            }),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
