<?php

declare(strict_types=1);

namespace App\Filament\Resources\AppointmentResource\Schemas;

use App\Enums\Gender;
use App\Forms\Components\Household;
use App\Forms\Components\Location;
use App\Forms\Components\Repeater;
use App\Forms\Components\Subsection;
use App\Models\Service\Service;
use App\Rules\MultipleIn;
use App\Rules\ValidCNP;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;

class OcasionalBeneficiaryForm
{
    public static function getSchema(): array
    {
        $services = Service::allAsFlatOptions();

        return [
            Subsection::make()
                ->icon('heroicon-o-user')
                ->columns(2)
                ->schema([
                    Checkbox::make('has_unknown_identity')
                        ->label(__('field.has_unknown_identity'))
                        ->default(false)
                        ->columnSpanFull()
                        ->live()
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
                                        ->live()
                                        ->afterStateUpdated(function (callable $set) {
                                            $set('cnp', null);
                                            $set('does_not_provide_cnp', false);
                                        }),

                                    Checkbox::make('does_not_provide_cnp')
                                        ->label(__('field.does_not_provide_cnp'))
                                        ->default(false)
                                        ->live()
                                        ->afterStateUpdated(function (callable $set) {
                                            $set('cnp', null);
                                            $set('does_not_have_cnp', false);
                                        }),
                                ]),
                        ]),
                ]),

            Household::make(),

            Subsection::make()
                ->icon('heroicon-o-map-pin')
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
                ]),

            Subsection::make()
                ->icon('heroicon-o-bolt')
                ->schema([
                    Repeater::make('ocasionalInterventions')
                        ->relationship()
                        ->label(__('intervention.label.plural'))
                        ->addActionLabel(__('intervention.action.create'))
                        ->minItems(1)
                        ->columns(2)
                        ->schema([
                            TextInput::make('reason')
                                ->label(__('field.intervention_name'))
                                ->placeholder(__('placeholder.intervention_name'))
                                ->maxLength(200)
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
                                ->options($services)
                                ->optionsLimit($services->count())
                                ->rule(new MultipleIn($services->keys()))
                                ->preload(),
                        ]),
                ]),

            Subsection::make()
                ->icon('heroicon-o-chat-bubble-bottom-center-text')
                ->schema([
                    RichEditor::make('notes')
                        ->label(__('field.beneficiary_notes'))
                        ->toolbarButtons(['bold', 'italic', 'strike', 'bulletList', 'orderedList', 'redo', 'undo'])
                        ->nullable()
                        ->maxLength(65535),
                ]),

        ];

        return [
            Subsection::make()
                ->icon('heroicon-o-user')
                ->columns()
                ->schema([
                    Checkbox::make('has_unknown_identity')
                        ->label(__('field.has_unknown_identity'))
                        ->default(false)
                        ->columnSpanFull()
                        ->live()
                        ->afterStateUpdated(function (Set $set) {
                            $set('first_name', null);
                            $set('last_name', null);
                            $set('gender', null);
                            $set('cnp', null);
                        }),

                    Grid::make()
                        ->disabled(fn (Get $get) => (bool) $get('has_unknown_identity'))
                        ->schema([
                            TextInput::make('first_name')
                                ->label(__('field.first_name'))
                                ->placeholder(__('placeholder.first_name'))
                                ->maxLength(50)
                                ->nullable()
                                ->required(fn (Get $get) => ! $get('has_unknown_identity')),

                            TextInput::make('last_name')
                                ->label(__('field.last_name'))
                                ->placeholder(__('placeholder.last_name'))
                                ->maxLength(50)
                                ->nullable()
                                ->required(fn (Get $get) => ! $get('has_unknown_identity')),

                            Select::make('gender')
                                ->label(__('field.gender'))
                                ->placeholder(__('placeholder.choose'))
                                ->options(Gender::options())
                                ->enum(Gender::class)
                                ->required(fn (Get $get) => ! $get('has_unknown_identity')),

                            Group::make()
                                ->schema([
                                    TextInput::make('cnp')
                                        ->label(__('field.cnp'))
                                        ->placeholder(__('placeholder.cnp'))
                                        ->unique(ignoreRecord: true)
                                        ->nullable()
                                        ->rule(new ValidCNP)
                                        ->disabled(function (Get $get) {
                                            return (bool) $get('does_not_have_cnp')
                                                || (bool) $get('does_not_provide_cnp');
                                        })
                                        ->required(function (Get $get) {
                                            return ! $get('has_unknown_identity')
                                                && ! $get('does_not_have_cnp')
                                                && ! $get('does_not_provide_cnp');
                                        }),

                                    Checkbox::make('does_not_have_cnp')
                                        ->label(__('field.does_not_have_cnp'))
                                        ->default(false)
                                        ->live()
                                        ->afterStateUpdated(function (Set $set) {
                                            $set('cnp', null);
                                            $set('does_not_provide_cnp', false);
                                        }),

                                    Checkbox::make('does_not_provide_cnp')
                                        ->label(__('field.does_not_provide_cnp'))
                                        ->default(false)
                                        ->live()
                                        ->afterStateUpdated(function (Set $set) {
                                            $set('cnp', null);
                                            $set('does_not_have_cnp', false);
                                        }),
                                ]),
                        ]),
                ]),

            Subsection::make()
                ->icon('heroicon-o-user-group')
                ->columns()
                ->schema([

                ]),

            Subsection::make()
                ->icon('heroicon-o-map-pin')
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
                ]),

            Subsection::make()
                ->icon('heroicon-o-bolt')
                ->schema([
                    Repeater::make('ocasionalInterventions')
                        ->relationship()
                        ->label(__('intervention.label.plural'))
                        ->addActionLabel(__('intervention.action.create'))
                        ->minItems(1)
                        ->columns(2)
                        ->schema([
                            TextInput::make('reason')
                                ->label(__('field.intervention_name'))
                                ->placeholder(__('placeholder.intervention_name'))
                                ->maxLength(200)
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
                                ->options($services)
                                ->optionsLimit($services->count())
                                ->rule(new MultipleIn($services->keys()))
                                ->preload(),
                        ]),
                ]),

            Subsection::make()
                ->icon('heroicon-o-chat-bubble-bottom-center-text')
                ->schema([
                    RichEditor::make('notes')
                        ->label(__('field.beneficiary_notes'))
                        ->toolbarButtons(['bold', 'italic', 'strike', 'bulletList', 'orderedList', 'redo', 'undo'])
                        ->nullable()
                        ->maxLength(65535),
                ]),

        ];
    }
}
