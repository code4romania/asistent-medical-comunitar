<?php

declare(strict_types=1);

namespace App\Filament\Forms\Components;

use App\Models\Family;
use App\Models\Household as HouseholdModel;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class Household extends Group
{
    protected bool $withoutSubsection = false;

    public function withoutSubsection()
    {
        $this->withoutSubsection = true;

        return $this;
    }

    public function getChildComponents(): array
    {
        if ($this->withoutSubsection) {
            return $this->getSchema();
        }

        return [
            Subsection::make()
                ->icon('heroicon-o-user-group')
                ->columns(2)
                ->schema($this->getSchema()),
        ];
    }

    protected function getSchema(): array
    {
        return match ($this->getContainer()->getContext()) {
            'view' => $this->getViewComponents(),
            default => $this->getEditComponents(),
        };
    }

    protected function getViewComponents(): array
    {
        return [
            Value::make('household')
                ->label(__('field.household'))
                ->content(fn ($record) => $record->household?->name),

            Value::make('family')
                ->label(__('field.family'))
                ->content(fn ($record) => $record->family?->name),
        ];
    }

    protected function getEditComponents(): array
    {
        return [
            Select::make('household_id')
                ->label(__('field.household'))
                ->placeholder(__('placeholder.household'))
                ->options($this->getHouseholds())
                ->loadStateFromRelationshipsUsing(function ($component) {
                    $component->state(
                        $component->getModelInstance()->family?->household?->id
                    );
                })

                ->searchable()
                ->reactive()
                ->afterStateUpdated(fn (callable $set) => $set('family_id', null))
                ->createOptionForm([
                    Grid::make()
                        ->schema([
                            TextInput::make('name')
                                ->label(__('field.household_name')),
                        ]),
                ])
                ->createOptionUsing(fn (array $data) => data_get(HouseholdModel::create($data), 'id')),

            Select::make('family_id')
                ->label(__('field.family'))
                ->placeholder(__('placeholder.family'))
                ->allowHtml()
                ->searchable()
                ->requiredWith('household_id')
                ->relationship(
                    'family',
                    'name',
                    fn (Builder $query, callable $get) => $query
                        ->where('household_id', $get('household_id'))
                        ->limit(100)
                )
                ->preload()
                ->createOptionForm([
                    Grid::make()
                        ->schema([
                            TextInput::make('name')
                                ->label(__('field.household_name')),
                        ]),
                ])
                ->createOptionUsing(function (array $data, callable $get) {
                    $data['household_id'] = $get('household_id');

                    return data_get(Family::create($data), 'id');
                }),

        ];
    }

    protected function getHouseholds(): Collection
    {
        return Cache::driver('array')
            ->remember('households', MINUTE_IN_SECONDS, fn () => HouseholdModel::pluck('name', 'id'));
    }
}
