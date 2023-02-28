<?php

declare(strict_types=1);

namespace App\Forms\Components;

use App\Models\Family;
use App\Models\Household as HouseholdModel;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;

class Household extends Group
{
    public function getChildComponents(): array
    {
        return [
            Subsection::make()
                ->icon('heroicon-o-user-group')
                ->columns(2)
                ->schema(match ($this->getContainer()->getContext()) {
                    'view' => $this->getViewComponents(),
                    default => $this->getEditComponents(),
                }),
        ];
    }

    protected function getViewComponents(): array
    {
        return [
            Placeholder::make('household')
                ->label(__('field.household'))
                ->content(fn ($record) => $record->household?->name),
            Placeholder::make('family')
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
                ->relationship('household', 'name')
                ->preload()
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
                ->createOptionUsing(fn (array $data) => data_get(Family::create($data), 'id')),

        ];
    }
}
