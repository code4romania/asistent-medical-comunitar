<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Forms\Components\Repeater;
use App\Filament\Resources\HouseholdResource\Pages\ManageHouseholds;
use App\Filament\Tables\Columns\HouseholdFamiliesColumn;
use App\Filament\Tables\Columns\TextColumn;
use App\Models\Beneficiary;
use App\Models\Family;
use App\Models\Household;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Columns\Layout\Grid;
use Filament\Tables\Columns\Layout\Split;
use Illuminate\Database\Eloquent\Builder;

class HouseholdResource extends Resource
{
    protected static ?string $model = Household::class;

    protected static bool $shouldRegisterNavigation = false;

    public static function getModelLabel(): string
    {
        return __('household.label.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('household.label.plural');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema(static::getFormSchema());
    }

    public static function getFormSchema(): array
    {
        $beneficiaries = Beneficiary::pluck('full_name', 'id');

        return [
            TextInput::make('name')
                ->label(__('field.household_name'))
                ->maxLength(200)
                ->required(),

            Repeater::make('families')
                ->label(__('family.label.plural'))
                ->createItemButtonLabel(__('family.action.create'))
                ->relationship(callback: function (Builder $query) {
                    $query->with('beneficiaries');
                })
                ->minItems(1)
                ->columns(2)
                ->columnSpanFull()
                ->schema([
                    TextInput::make('name')
                        ->label(__('field.family_name'))
                        ->maxLength(200)
                        ->required(),

                    Select::make('beneficiaries')
                        ->label(__('beneficiary.label.plural'))
                        ->options($beneficiaries)
                        ->searchable()
                        ->multiple()
                        ->loadStateFromRelationshipsUsing(static function ($component, $state) {
                            $component->state(
                                $component->getModelInstance()
                                    ->beneficiaries
                                    ->pluck('id')
                                    ->all()
                            );
                        })
                        ->saveRelationshipsUsing(function (Family $record, $state) {
                            $record->beneficiaries()
                                ->whereNotIn('id', $state)
                                ->update([
                                    'family_id' => null,
                                ]);

                            Beneficiary::query()
                                ->whereIn('id', $state)
                                ->update([
                                    'family_id' => $record->id,
                                ]);
                        }),
                ]),

        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Grid::make(3)
                    ->schema([
                        TextColumn::make('name')
                            ->label(__('field.household'))
                            ->description(__('field.household'), position: 'above')
                            ->searchable()
                            ->sortable()
                            ->alignment('left'),

                        TextColumn::make('families_count')
                            ->label(__('field.families_count'))
                            ->description(__('field.families_count'), position: 'above')
                            ->alignment('left')
                            ->counts('families')
                            ->sortable(),

                        TextColumn::make('beneficiaries_count')
                            ->label(__('field.beneficiaries_count'))
                            ->description(__('field.beneficiaries_count'), position: 'above')
                            ->alignment('left')
                            ->counts('beneficiaries')
                            ->sortable(),
                    ]),

                Split::make([
                    HouseholdFamiliesColumn::make('families'),
                ])->collapsible(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->iconButton(),
                Tables\Actions\EditAction::make()
                    ->iconButton(),
                Tables\Actions\DeleteAction::make()
                    ->iconButton(),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageHouseholds::route('/'),
        ];
    }
}
