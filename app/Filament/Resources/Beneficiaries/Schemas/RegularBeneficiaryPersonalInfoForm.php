<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Schemas;

use alcea\cnp\Cnp;
use App\Enums\Beneficiary\Ethnicity;
use App\Enums\Beneficiary\IDType;
use App\Enums\Beneficiary\WorkStatus;
use App\Enums\Gender;
use App\Filament\Forms\Components\Household;
use App\Filament\Forms\Components\Location;
use App\Filament\Schemas\Components\Subsection;
use App\Rules\ValidCNP;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class RegularBeneficiaryPersonalInfoForm
{
    public static function configure(Schema $schema, bool $includeProgram = false): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make()
                    ->heading(__('beneficiary.section.personal_data'))
                    ->components([
                        Subsection::make()
                            ->icon('heroicon-o-user')
                            ->columns()
                            ->components([
                                TextInput::make('first_name')
                                    ->label(__('field.first_name'))
                                    ->placeholder(__('placeholder.first_name'))
                                    ->maxLength(50)
                                    ->nullable()
                                    ->required(),

                                TextInput::make('last_name')
                                    ->label(__('field.last_name'))
                                    ->placeholder(__('placeholder.last_name'))
                                    ->maxLength(50)
                                    ->nullable()
                                    ->required(),

                                Group::make()
                                    ->components([
                                        TextInput::make('cnp')
                                            ->label(fn (Get $get) => $get('has_non_standard_cnp')
                                                ? __('field.non_standard_cnp')
                                                : __('field.cnp'))
                                            ->placeholder(fn (Get $get) => $get('has_non_standard_cnp')
                                                ? __('placeholder.non_standard_cnp')
                                                : __('placeholder.cnp'))
                                            ->unique(ignoreRecord: true)
                                            ->nullable()
                                            ->maxLength(13)
                                            ->rule(new ValidCNP, fn (Get $get): bool => ! $get('has_non_standard_cnp'))
                                            ->disabled(function (Get $get) {
                                                return (bool) $get('does_not_have_cnp')
                                                    || (bool) $get('does_not_provide_cnp');
                                            })
                                            ->required(function (Get $get) {
                                                return ! $get('has_unknown_identity')
                                                    && ! $get('does_not_have_cnp')
                                                    && ! $get('does_not_provide_cnp');
                                            })
                                            ->lazy()
                                            ->afterStateUpdated(function (?string $state, Set $set): void {
                                                $cnp = new Cnp($state);

                                                if ($cnp->isValid()) {
                                                    $set('date_of_birth', $cnp->getBirthDateFromCNP());
                                                }
                                            }),

                                        Checkbox::make('has_non_standard_cnp')
                                            ->label(__('field.has_non_standard_cnp'))
                                            ->default(false)
                                            ->live()
                                            ->afterStateUpdated(function (Set $set) {
                                                $set('does_not_have_cnp', false);
                                                $set('does_not_provide_cnp', false);
                                            }),

                                        Checkbox::make('does_not_have_cnp')
                                            ->label(__('field.does_not_have_cnp'))
                                            ->default(false)
                                            ->live()
                                            ->afterStateUpdated(function (Set $set) {
                                                $set('cnp', null);
                                                $set('does_not_provide_cnp', false);
                                                $set('has_non_standard_cnp', false);
                                            }),

                                        Checkbox::make('does_not_provide_cnp')
                                            ->label(__('field.does_not_provide_cnp'))
                                            ->default(false)
                                            ->live()
                                            ->afterStateUpdated(function (Set $set) {
                                                $set('cnp', null);
                                                $set('does_not_have_cnp', false);
                                                $set('has_non_standard_cnp', false);
                                            }),
                                    ]),

                                Select::make('id_type')
                                    ->label(__('field.id_type'))
                                    ->placeholder(__('placeholder.id_type'))
                                    ->options(IDType::class)
                                    ->live()
                                    ->afterStateUpdated(function (Set $set, $state) {
                                        if (blank($state) || IDType::NONE->is($state)) {
                                            $set('id_serial', null);
                                            $set('id_number', null);
                                        }
                                    })
                                    ->required(),

                                Group::make()
                                    ->columns()
                                    ->columnSpanFull()
                                    ->disabled(fn (Get $get) => blank($get('id_type')) || IDType::NONE->is($get('id_type')))
                                    ->components([
                                        TextInput::make('id_serial')
                                            ->label(__('field.id_serial'))
                                            ->placeholder(__('placeholder.id_serial'))
                                            ->maxLength(50),

                                        TextInput::make('id_number')
                                            ->label(__('field.id_number'))
                                            ->placeholder(__('placeholder.id_number'))
                                            ->maxLength(50),
                                    ]),

                                Select::make('gender')
                                    ->label(__('field.gender'))
                                    ->placeholder(__('placeholder.choose'))
                                    ->options(Gender::class)
                                    ->required(),

                                DatePicker::make('date_of_birth')
                                    ->label(__('field.date_of_birth'))
                                    ->placeholder(__('placeholder.date'))
                                    ->maxDate(today()->endOfDay())
                                    ->nullable(),

                                Select::make('ethnicity')
                                    ->label(__('field.ethnicity'))
                                    ->placeholder(__('placeholder.choose'))
                                    ->options(Ethnicity::class),

                                Select::make('work_status')
                                    ->label(__('field.work_status'))
                                    ->placeholder(__('placeholder.choose'))
                                    ->options(WorkStatus::class),
                            ]),

                        Household::make(),

                        Subsection::make()
                            ->icon('heroicon-o-map-pin')
                            ->columns()
                            ->components([
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
                            ->icon('heroicon-o-chat-bubble-bottom-center-text')
                            ->components([
                                RichEditor::make('notes')
                                    ->label(__('field.beneficiary_notes'))
                                    ->toolbarButtons(['bold', 'italic', 'strike', 'bulletList', 'orderedList', 'redo', 'undo'])
                                    ->nullable()
                                    ->maxLength(65535),
                            ]),
                    ]),
            ]);
    }
}
