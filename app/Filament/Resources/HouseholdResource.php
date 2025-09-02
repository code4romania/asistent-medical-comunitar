<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\HouseholdResource\Pages\ManageHouseholds;
use App\Forms\Components\Repeater;
use App\Models\Beneficiary;
use App\Models\Family;
use App\Models\Household;
use App\Tables\Columns\HouseholdFamiliesColumn;
use App\Tables\Columns\TextColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\Layout\Grid;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Table;
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
                ->addActionLabel(__('family.action.create'))
                ->relationship(modifyQueryUsing: function (Builder $query) {
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
            ->modifyQueryUsing(function (Builder $query) {
                $query->with([
                    'families.beneficiaries.catagraphy' => function ($query) {
                        $query
                            ->with(['disabilities', 'diseases'])
                            ->select([
                                'id',
                                'cat_age',
                                'cat_as',
                                'cat_cr',
                                'has_disabilities',
                                'cat_edu',
                                'cat_fam',
                                'cat_id',
                                'cat_inc',
                                'cat_liv',
                                'cat_mf',
                                'cat_ns',
                                'cat_pov',
                                'cat_preg',
                                'cat_rep',
                                'has_health_issues',
                                'is_social_case',
                                'cat_ssa',
                                'cat_vif',
                                'beneficiary_id',
                            ]);
                    },
                ]);
            })
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
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageHouseholds::route('/'),
        ];
    }
}
