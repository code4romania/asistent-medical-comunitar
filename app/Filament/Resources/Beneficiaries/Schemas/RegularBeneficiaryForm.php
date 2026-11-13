<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Schemas;

use App\Enums\Beneficiary\ReasonRemoved;
use App\Enums\Beneficiary\Status;
use App\Models\Beneficiary;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Illuminate\Database\Eloquent\Builder;

class RegularBeneficiaryForm
{
    public static function configure(Schema $schema, bool $includeProgram = false): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make()
                    ->heading(__('beneficiary.section.program'))
                    ->visible($includeProgram)
                    ->components([
                        Grid::make()
                            ->columns()
                            ->maxWidth(Width::FiveExtraLarge)
                            ->components([
                                TextEntry::make('id')
                                    ->label(__('field.beneficiary_id')),

                                TextEntry::make('type')
                                    ->label(__('field.beneficiary_type')),

                                Grid::make()
                                    ->columnSpanFull()
                                    ->components([
                                        Select::make('nurse_id')
                                            ->label(__('field.allocated_nurse'))
                                            ->placeholder(__('placeholder.choose'))
                                            ->relationship(
                                                'nurse',
                                                'full_name',
                                                fn (Builder $query): Builder => $query
                                                    ->onlyNurses()
                                                    ->activatesInCurrentUserCounty()
                                                    ->select([
                                                        'id', 'first_name', 'last_name', 'full_name',
                                                    ])
                                            )
                                            ->searchable()
                                            ->preload()
                                            ->visible(fn (Beneficiary $record): bool => auth()->user()->isMediator() && blank($record->nurse_id)),

                                        TextEntry::make('nurse.full_name')
                                            ->label(__('field.allocated_nurse'))
                                            ->visible(fn (Beneficiary $record): bool => auth()->user()->isMediator() && filled($record->nurse_id)),

                                        Select::make('mediator.full_name')
                                            ->label(__('field.allocated_mediator'))
                                            ->placeholder(__('placeholder.choose'))
                                            ->relationship(
                                                'mediator',
                                                'full_name',
                                                fn (Builder $query): Builder => $query
                                                    ->activatesInCurrentUserCounty()
                                                    ->select([
                                                        'id', 'full_name',
                                                    ])
                                            )
                                            ->searchable()
                                            ->preload()
                                            ->visible(fn (Beneficiary $record): bool => auth()->user()->isNurse() && blank($record->mediator_id)),

                                        TextEntry::make('mediator.full_name')
                                            ->label(__('field.allocated_mediator'))
                                            ->visible(fn (Beneficiary $record): bool => auth()->user()->isNurse() && filled($record->mediator_id)),
                                    ]),

                                Select::make('integrated')
                                    ->label(__('field.integrated'))
                                    ->boolean(
                                        trueLabel: __('beneficiary.integrated.yes'),
                                        falseLabel: __('beneficiary.integrated.no'),
                                    )
                                    ->formatStateUsing(fn (?bool $state) => (int) $state)
                                    ->required(),

                                Select::make('status')
                                    ->label(__('field.current_status'))
                                    ->placeholder(__('placeholder.choose'))
                                    ->options(Status::class)
                                    ->live()
                                    ->required(),

                                Grid::make()
                                    ->visible(fn (Get $get) => Status::REMOVED->is($get('status')))
                                    ->components([
                                        Select::make('reason_removed')
                                            ->label(__('field.reason_removed'))
                                            ->placeholder(__('placeholder.choose'))
                                            ->options(ReasonRemoved::class)
                                            ->live()
                                            ->required(),

                                        TextInput::make('reason_removed_notes')
                                            ->label(__('field.reason_removed_notes'))
                                            ->maxLength(200)
                                            ->required(fn (Get $get) => ReasonRemoved::OTHER->is($get('reason_removed'))),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
