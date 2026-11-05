<?php

declare(strict_types=1);

namespace App\Filament\Resources\Households\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class HouseholdForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
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
                            ->relationship('beneficiaries', 'full_name')
                            ->searchable()
                            ->multiple(),
                    ]),
            ]);
    }
}
