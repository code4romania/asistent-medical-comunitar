<?php

declare(strict_types=1);

namespace App\Filament\Resources\Profiles\Schemas;

use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use App\Enums\Employer\Funding;
use App\Enums\Employer\Type;
use App\Forms\Components\Location;
use App\Forms\Components\Repeater;
use App\Forms\Components\Subsection;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class EmployersForm
{
    public static function getSchema(): array
    {
        return [
            Repeater::make('employers')
                ->relationship()
                ->label(__('employer.label.plural'))
                ->addActionLabel(__('employer.action.create'))
                ->minItems(1)
                ->columnSpanFull()
                ->schema([
                    Subsection::make()
                        ->icon('heroicon-o-building-office')
                        ->columns(2)
                        ->schema([
                            TextInput::make('name')
                                ->label(__('field.employer_name'))
                                ->placeholder(__('placeholder.employer_name'))
                                ->maxLength(200)
                                ->required(),

                            Select::make('type')
                                ->label(__('field.employer_type'))
                                ->placeholder(__('placeholder.choose'))
                                ->options(Type::options())
                                ->enum(Type::class)
                                ->required(),

                            Select::make('funding')
                                ->label(__('field.funding'))
                                ->placeholder(__('placeholder.choose'))
                                ->options(Funding::options())
                                ->enum(Funding::class),

                            Group::make()
                                ->extraAttributes(['class' => 'flex h-full justify-end items-center'])
                                ->schema([
                                    Checkbox::make('is_project_based')
                                        ->label(__('field.employer_project_based'))
                                        ->live()
                                        ->afterStateUpdated(function (Set $set) {
                                            $set('project', null);
                                        }),
                                ]),

                            Section::make()
                                ->columnSpanFull()
                                // ->pointer('right') // TODO: fix pointer
                                ->hidden(fn (Get $get) => $get('is_project_based') === false)
                                ->schema([
                                    TextInput::make('project')
                                        ->label(__('field.employer_project'))
                                        ->placeholder(__('placeholder.employer_project'))
                                        ->live()
                                        ->maxLength(200)
                                        ->afterStateHydrated(function (Set $set, $state) {
                                            $set('is_project_based', $state !== null);
                                        }),
                                ]),

                            Location::make(),

                            TextInput::make('email')
                                ->label(__('field.employer_email'))
                                ->placeholder(__('placeholder.email'))
                                ->maxLength(200)
                                ->email(),

                            TextInput::make('phone')
                                ->label(__('field.employer_phone'))
                                ->placeholder(__('placeholder.phone'))
                                ->tel()
                                ->maxLength(15),

                            DatePicker::make('start_date')
                                ->label(__('field.start_date'))
                                ->placeholder(__('placeholder.date')),

                            Group::make()
                                ->schema([
                                    DatePicker::make('end_date')
                                        ->label(__('field.end_date'))
                                        ->placeholder(__('placeholder.date'))
                                        ->afterOrEqual('start_date')
                                        ->disabled(function (Get $get) {
                                            return $get('is_ongoing') === true;
                                        })
                                        ->afterStateHydrated(function (Set $set, $state) {
                                            $set('is_ongoing', $state === null);
                                        }),

                                    Group::make()
                                        ->extraAttributes(['class' => 'flex justify-end'])
                                        ->columnSpanFull()
                                        ->schema([
                                            Checkbox::make('is_ongoing')
                                                ->label(__('field.employer_ongoing'))
                                                ->live()
                                                ->afterStateUpdated(function (Set $set) {
                                                    $set('end_date', null);
                                                }),
                                        ]),
                                ]),

                            Checkbox::make('has_gp_agreement')
                                ->label(__('field.has_gp_agreement'))
                                ->live()
                                ->afterStateUpdated(function (Set $set) {
                                    $set('end_date', null);
                                }),

                            Section::make()
                                ->columnSpanFull()
                                ->hidden(fn (Get $get) => $get('has_gp_agreement') === false)
                                ->columns()
                                // ->pointer() // TODO: fix pointer
                                ->schema([
                                    TextInput::make('gp_name')
                                        ->label(__('field.gp_name'))
                                        ->placeholder(__('placeholder.gp_name'))
                                        ->maxLength(200)
                                        ->columnSpanFull(),

                                    TextInput::make('gp_email')
                                        ->label(__('field.gp_email'))
                                        ->placeholder(__('placeholder.email'))
                                        ->maxLength(200)
                                        ->email(),

                                    TextInput::make('gp_phone')
                                        ->label(__('field.gp_phone'))
                                        ->placeholder(__('placeholder.phone'))
                                        ->tel()
                                        ->maxLength(15),
                                ]),
                        ]),
                ]),
        ];
    }
}
