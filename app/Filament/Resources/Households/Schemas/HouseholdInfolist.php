<?php

declare(strict_types=1);

namespace App\Filament\Resources\Households\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class HouseholdInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label(__('field.household_name')),

                RepeatableEntry::make('families')
                    ->label(__('family.label.plural'))
                    ->columnSpanFull()
                    ->columns()
                    ->schema([
                        TextEntry::make('name')
                            ->label(__('field.family_name')),

                        TextEntry::make('beneficiaries.full_name')
                            ->label(__('beneficiary.label.plural')),
                    ]),
            ]);
    }
}
