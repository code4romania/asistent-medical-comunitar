<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Concerns;

use App\Enums\Beneficiary\IDType;
use App\Enums\Gender;
use App\Filament\Forms\Components\Household;
use App\Filament\Forms\Components\Location;
use App\Filament\Forms\Components\Repeater;
use App\Filament\Forms\Components\Subsection;
use App\Filament\Forms\Components\Value;
use App\Rules\ValidCNP;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

trait CommonEditFormSchema
{
    protected static function getRegularBeneficiaryFormSchema(): array
    {
        return [
            Subsection::make()
                ->icon('heroicon-o-user')
                ->columns(2)
                ->schema([
                    TextInput::make('first_name')
                        ->label(__('field.first_name'))
                        ->placeholder(__('placeholder.first_name'))
                        ->maxLength(50)
                        ->nullable()
                        ->required(fn (callable $get) => ! $get('has_unknown_identity')),

                    TextInput::make('last_name')
                        ->label(__('field.last_name'))
                        ->placeholder(__('placeholder.last_name'))
                        ->maxLength(50)
                        ->nullable()
                        ->required(fn (callable $get) => ! $get('has_unknown_identity')),

                    Group::make()
                        ->schema([
                            TextInput::make('cnp')
                                ->label(__('field.cnp'))
                                ->placeholder(__('placeholder.cnp'))
                                ->unique(ignoreRecord: true)
                                ->nullable()
                                ->rule(new ValidCNP)
                                ->disabled(function (callable $get) {
                                    return (bool) $get('does_not_have_cnp')
                                        || (bool) $get('does_not_provide_cnp');
                                })
                                ->required(function (callable $get) {
                                    return ! $get('has_unknown_identity')
                                        && ! $get('does_not_have_cnp')
                                        && ! $get('does_not_provide_cnp');
                                })
                                ->afterStateHydrated(function ($state, callable $set) {
                                    if (\is_null($state)) {
                                        $set('does_not_have_cnp', true);
                                    }
                                }),

                            Checkbox::make('does_not_have_cnp')
                                ->label(__('field.does_not_have_cnp'))
                                ->default(false)
                                ->reactive()
                                ->afterStateUpdated(function (callable $set) {
                                    $set('cnp', null);
                                    $set('does_not_provide_cnp', false);
                                }),

                            Checkbox::make('does_not_provide_cnp')
                                ->label(__('field.does_not_provide_cnp'))
                                ->default(false)
                                ->reactive()
                                ->afterStateUpdated(function (callable $set) {
                                    $set('cnp', null);
                                    $set('does_not_have_cnp', false);
                                }),
                        ]),

                    Select::make('id_type')
                        ->label(__('field.id_type'))
                        ->placeholder(__('placeholder.id_type'))
                        ->options(IDType::options())
                        ->enum(IDType::class)
                        ->reactive()
                        ->afterStateUpdated(function (callable $set, $state) {
                            if (! $state || IDType::tryFrom($state)?->is(IDType::NONE)) {
                                $set('id_serial', null);
                                $set('id_number', null);
                            }
                        })
                        ->required(),

                    Group::make()
                        ->columns()
                        ->columnSpanFull()
                        ->disabled(
                            fn (callable $get) => ! $get('id_type') || IDType::tryFrom($get('id_type'))?->is(IDType::NONE)
                        )
                        ->schema([
                            TextInput::make('id_serial')
                                ->label(__('field.id_serial'))
                                ->placeholder(__('placeholder.id_serial')),

                            TextInput::make('id_number')
                                ->label(__('field.id_number'))
                                ->placeholder(__('placeholder.id_number')),
                        ]),

                    Select::make('gender')
                        ->label(__('field.gender'))
                        ->placeholder(__('placeholder.choose'))
                        ->options(Gender::options())
                        ->enum(Gender::class)
                        ->required(fn (callable $get) => ! $get('has_unknown_identity')),

                    DatePicker::make('date_of_birth')
                        ->label(__('field.date_of_birth'))
                        ->placeholder(__('placeholder.date'))
                        ->maxDate(today()->endOfDay())
                        ->nullable(),

                    Value::make('ethnicity')
                        ->label(__('field.ethnicity')),

                    Value::make('work_status')
                        ->label(__('field.work_status')),
                ]),

            Household::make(),

            static::getLocationSubsection(),

            Subsection::make()
                ->icon('heroicon-o-annotation')
                ->schema([
                    RichEditor::make('notes')
                        ->label(__('field.beneficiary_notes'))
                        ->toolbarButtons(['bold', 'italic', 'strike', 'bulletList', 'orderedList', 'redo', 'undo'])
                        ->nullable()
                        ->maxLength(65535),
                ]),
        ];
    }

    protected static function getOcasionalBeneficiaryFormSchema(): array
    {
        return [
            Subsection::make()
                ->icon('heroicon-o-user')
                ->columns(2)
                ->schema([
                    Checkbox::make('has_unknown_identity')
                        ->label(__('field.has_unknown_identity'))
                        ->default(false)
                        ->columnSpanFull()
                        ->reactive()
                        ->afterStateUpdated(function (callable $set) {
                            $set('first_name', null);
                            $set('last_name', null);
                            $set('gender', null);
                            $set('cnp', null);
                        }),

                    Grid::make()
                        ->disabled(fn (callable $get) => (bool) $get('has_unknown_identity'))
                        ->schema([
                            TextInput::make('first_name')
                                ->label(__('field.first_name'))
                                ->placeholder(__('placeholder.first_name'))
                                ->maxLength(50)
                                ->nullable()
                                ->required(fn (callable $get) => ! $get('has_unknown_identity')),

                            TextInput::make('last_name')
                                ->label(__('field.last_name'))
                                ->placeholder(__('placeholder.last_name'))
                                ->maxLength(50)
                                ->nullable()
                                ->required(fn (callable $get) => ! $get('has_unknown_identity')),

                            Select::make('gender')
                                ->label(__('field.gender'))
                                ->placeholder(__('placeholder.choose'))
                                ->options(Gender::options())
                                ->enum(Gender::class)
                                ->required(fn (callable $get) => ! $get('has_unknown_identity')),

                            Group::make()
                                ->schema([
                                    TextInput::make('cnp')
                                        ->label(__('field.cnp'))
                                        ->placeholder(__('placeholder.cnp'))
                                        ->unique(ignoreRecord: true)
                                        ->nullable()
                                        ->rule(new ValidCNP)
                                        ->disabled(function (callable $get) {
                                            return (bool) $get('does_not_have_cnp')
                                                || (bool) $get('does_not_provide_cnp');
                                        })
                                        ->required(function (callable $get) {
                                            return ! $get('has_unknown_identity')
                                                && ! $get('does_not_have_cnp')
                                                && ! $get('does_not_provide_cnp');
                                        }),

                                    Checkbox::make('does_not_have_cnp')
                                        ->label(__('field.does_not_have_cnp'))
                                        ->default(false)
                                        ->reactive()
                                        ->afterStateUpdated(function (callable $set) {
                                            $set('cnp', null);
                                            $set('does_not_provide_cnp', false);
                                        }),

                                    Checkbox::make('does_not_provide_cnp')
                                        ->label(__('field.does_not_provide_cnp'))
                                        ->default(false)
                                        ->reactive()
                                        ->afterStateUpdated(function (callable $set) {
                                            $set('cnp', null);
                                            $set('does_not_have_cnp', false);
                                        }),
                                ]),
                        ]),
                ]),

            Household::make(),

            static::getLocationSubsection(),

            Subsection::make()
                ->icon('heroicon-o-lightning-bolt')
                ->schema([
                    Repeater::make('ocasionalInterventions')
                        ->relationship()
                        ->label(__('intervention.label.plural'))
                        ->createItemButtonLabel(__('intervention.action.create'))
                        ->minItems(1)
                        ->columns(2)
                        ->schema([
                            TextInput::make('reason')
                                ->label(__('field.intervention_reason'))
                                ->placeholder(__('placeholder.intervention_reason'))
                                ->nullable(),

                            DatePicker::make('date')
                                ->label(__('field.date'))
                                ->placeholder(__('placeholder.date'))
                                ->default(today()),

                            Select::make('services')
                                ->relationship('services', 'name')
                                ->label(__('field.services_offered'))
                                ->placeholder(__('placeholder.choose_services'))
                                ->columnSpanFull()
                                ->multiple()
                                ->preload(),
                        ]),
                ]),

            Subsection::make()
                ->icon('heroicon-o-annotation')
                ->schema([
                    RichEditor::make('notes')
                        ->label(__('field.beneficiary_notes'))
                        ->toolbarButtons(['bold', 'italic', 'strike', 'bulletList', 'orderedList', 'redo', 'undo'])
                        ->nullable()
                        ->maxLength(65535),
                ]),

        ];
    }

    private static function getLocationSubsection(): Subsection
    {
        return Subsection::make()
            ->icon('heroicon-o-location-marker')
            ->columns(2)
            ->schema([
                Location::make(),

                TextInput::make('address')
                    ->label(__('field.address'))
                    ->maxLength(50)
                    ->nullable(),

                TextInput::make('phone')
                    ->label(__('field.phone'))
                    ->tel()
                    ->nullable()
                    ->maxLength(15),
            ]);
    }
}
