<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Enums\EmployerType;
use App\Filament\Forms\Components\Location;
use App\Filament\Forms\Components\Repeater;
use App\Filament\Forms\Components\Subsection;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;

class EditEmployers extends EditRecord
{
    protected function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema(static::getSchema());
    }

    public static function getSchema(): array
    {
        return [
            Repeater::make('employers')
                ->relationship('employers')
                ->label(__('employer.label.plural'))
                ->createItemButtonLabel(__('employer.action.create'))
                ->minItems(1)
                ->schema([
                    Subsection::make()
                        ->icon('heroicon-o-office-building')
                        ->columns(2)
                        ->schema([
                            TextInput::make('name')
                                ->label(__('field.employer_name'))
                                ->placeholder(__('placeholder.employer_name'))
                                ->required(),
                            Select::make('type')
                                ->label(__('field.employer_type'))
                                ->placeholder(__('placeholder.choose'))
                                ->options(EmployerType::options())
                                ->required(),
                            Group::make()
                                ->extraAttributes(['class' => 'flex justify-end'])
                                ->columnSpanFull()
                                ->schema([
                                    Checkbox::make('is_project_based')
                                        ->label(__('field.employer_project_based'))
                                        ->reactive()
                                        ->afterStateUpdated(function (callable $set) {
                                            $set('project', null);
                                        }),
                                ]),
                            TextInput::make('project')
                                ->label(__('field.employer_project'))
                                ->placeholder(__('placeholder.employer_project'))
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
                                ->label(__('field.start_date'))
                                ->placeholder(__('placeholder.date')),
                            DatePicker::make('end_date')
                                ->label(__('field.end_date'))
                                ->placeholder(__('placeholder.date'))
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
                                        ->label(__('field.employer_ongoing'))
                                        ->reactive()
                                        ->afterStateUpdated(function (callable $set) {
                                            $set('end_date', null);
                                        }),
                                ]),
                        ]),
                ]),
        ];
    }
}
