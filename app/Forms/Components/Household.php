<?php

declare(strict_types=1);

namespace App\Forms\Components;

use App\Models\Family;
use App\Models\Household as HouseholdModel;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class Household extends Component
{
    protected string $view = 'filament-infolists::components.group';

    final public static function make(): static
    {
        $static = app(static::class);
        $static->configure();

        return $static;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->schema([
            Subsection::make()
                ->icon('heroicon-o-user-group')
                ->columns()
                ->schema([
                    Select::make('household_id')
                        ->label(__('field.household'))
                        ->placeholder(__('placeholder.household'))
                        ->options($this->getHouseholds())
                        ->loadStateFromRelationshipsUsing(function (Select $component) {
                            $component->state(
                                $component->getModelInstance()->family?->household?->id
                            );
                        })
                        ->searchable()
                        ->live()
                        ->afterStateUpdated(fn (Set $set) => $set('family_id', null))
                        ->createOptionModalHeading(__('household.action.create'))
                        ->createOptionForm([
                            Grid::make()
                                ->schema([
                                    TextInput::make('name')
                                        ->label(__('field.household_name'))
                                        ->maxLength(200)
                                        ->required(),
                                ]),
                        ])
                        ->createOptionUsing(fn (array $data) => HouseholdModel::createForCurrentNurse($data)->getKey()),

                    Select::make('family_id')
                        ->label(__('field.family'))
                        ->placeholder(__('placeholder.family'))
                        ->searchable()
                        ->requiredWith('household_id')
                        ->relationship(
                            'family',
                            'name',
                            fn (Builder $query, Get $get) => $query
                                ->where('household_id', $get('household_id'))
                                ->limit(100)
                        )
                        ->preload()
                        ->createOptionModalHeading(__('family.action.create'))
                        ->createOptionForm(function (Get $get) {
                            if (! $get('household_id')) {
                                return null;
                            }

                            return [
                                Grid::make()
                                    ->schema([
                                        TextInput::make('name')
                                            ->label(__('field.family_name'))
                                            ->maxLength(200)
                                            ->required(),
                                    ]),
                            ];
                        })
                        ->createOptionUsing(function (array $data, Get $get) {
                            $data['household_id'] = $get('household_id');

                            if (! $data['household_id']) {
                                return null;
                            }

                            $family = Family::create($data);

                            return $family->getKey();
                        }),

                ]),
        ]);
    }

    protected function getHouseholds(): Collection
    {
        return Cache::driver('array')
            ->remember('households', MINUTE_IN_SECONDS, fn () => HouseholdModel::pluck('name', 'id'));
    }
}
