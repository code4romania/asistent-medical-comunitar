<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Pages;

use App\Enums\Beneficiary\IDType;
use App\Enums\Beneficiary\Type;
use App\Enums\Gender;
use App\Filament\Resources\BeneficiaryResource;
use App\Forms\Components\Location;
use App\Forms\Components\Placeholder;
use App\Forms\Components\Subsection;
use App\Rules\ValidCNP;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Pages\CreateRecord;

class CreateBeneficiary extends CreateRecord
{
    protected static string $resource = BeneficiaryResource::class;

    protected static bool $canCreateAnother = false;

    protected function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Card::make()
                    ->schema([
                        Grid::make(['md' => 3])
                            ->schema([
                                Select::make('type')
                                    ->label(__('field.beneficiary_type'))
                                    ->options(Type::options())
                                    ->default(Type::REGULAR->value)
                                    ->disablePlaceholderSelection()
                                    ->reactive()
                                    ->required(),
                            ]),

                        Group::make()
                            ->visible(fn ($state) => $state['type'] === Type::REGULAR->value)
                            ->schema(static::getRegularBeneficiaryFormSchema()),

                        Group::make()
                            ->visible(fn ($state) => $state['type'] === Type::OCASIONAL->value)
                            ->schema(static::getOcasionalBeneficiaryFormSchema()),
                    ]),
            ]);
    }

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
                                ->unique()
                                ->nullable()
                                ->rule(new ValidCNP)
                                ->disabled(fn (callable $get) => (bool) $get('does_not_have_cnp'))
                                ->required(fn (callable $get) => ! $get('has_unknown_identity') && ! $get('does_not_have_cnp')),

                            Checkbox::make('does_not_have_cnp')
                                ->label(__('field.does_not_have_cnp'))
                                ->default(false)
                                ->extraAttributes(['class' => ' justify-end'])
                                ->reactive()
                                ->afterStateUpdated(function (callable $set) {
                                    $set('cnp', null);
                                }),
                        ]),

                    Select::make('id_type')
                        ->label(__('field.id_type'))
                        ->placeholder(__('placeholder.id_type'))
                        ->options(IDType::options())
                        ->enum(IDType::class)
                        ->reactive()
                        ->afterStateUpdated(function (callable $set, $state) {
                            if (! $state || IDType::from($state) === IDType::NONE) {
                                $set('id_serial', null);
                                $set('id_number', null);
                            }
                        })
                        ->required(),

                    Group::make()
                        ->columns()
                        ->columnSpanFull()
                        ->disabled(
                            fn (callable $get) => ! $get('id_type') || IDType::tryFrom($get('id_type')) === IDType::NONE
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
                        ->disablePlaceholderSelection()
                        ->enum(Gender::class)
                        ->required(fn (callable $get) => ! $get('has_unknown_identity')),

                    DatePicker::make('date_of_birth')
                        ->label(__('field.date_of_birth'))
                        ->placeholder(__('placeholder.date'))
                        ->maxDate(today()->addDay())
                        ->nullable(),

                    Placeholder::make('ethnicity')
                        ->label(__('field.ethnicity')),

                    Placeholder::make('work_status')
                        ->label(__('field.work_status')),
                ]),

            static::getHouseholdSubsection(),

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
                                ->disablePlaceholderSelection()
                                ->enum(Gender::class)
                                ->required(fn (callable $get) => ! $get('has_unknown_identity')),

                            Group::make()
                                ->schema([
                                    TextInput::make('cnp')
                                        ->label(__('field.cnp'))
                                        ->placeholder(__('placeholder.cnp'))
                                        ->unique()
                                        ->nullable()
                                        ->rule(new ValidCNP)
                                        ->disabled(fn (callable $get) => (bool) $get('does_not_have_cnp'))
                                        ->required(fn (callable $get) => ! $get('has_unknown_identity') && ! $get('does_not_have_cnp')),

                                    Checkbox::make('does_not_have_cnp')
                                        ->label(__('field.does_not_have_cnp'))
                                        ->default(false)
                                        ->extraAttributes(['class' => ' justify-end'])
                                        ->reactive()
                                        ->afterStateUpdated(function (callable $set) {
                                            $set('cnp', null);
                                        }),
                                ]),
                        ]),
                ]),

            static::getHouseholdSubsection(),

            static::getLocationSubsection(),

            Subsection::make()
                ->icon('heroicon-o-lightning-bolt')
                ->schema([
                    Repeater::make('interventions')
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
                                ->label(__('field.services'))
                                ->placeholder(__('placeholder.choose_services'))
                                ->columnSpanFull()
                                ->multiple()
                                ->options([
                                    'Educație - poluare',
                                    'Educație - alimentație',
                                    'Educație - sport',
                                    'Educație - fumat',
                                    'Educație - consumul de alcool',
                                    'Educație - droguri',
                                    'Educație - activitate sexuală',
                                    'Educație - planificare familială',
                                    'Educație parentală',
                                ]),
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

    private static function getHouseholdSubsection(): Subsection
    {
        return Subsection::make()
            ->icon('heroicon-o-user-group')
            ->columns(2)
            ->schema([
                Placeholder::make('household')
                    ->label(__('field.household')),

                Placeholder::make('family')
                    ->label(__('field.family')),
            ]);
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

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['amc_id'] = auth()->id();

        return $data;
    }
}
