<?php

declare(strict_types=1);

namespace App\Filament\Resources\Profiles\Schemas;

use App\Filament\Schemas\Components\Subsection;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class AreaInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Subsection::make()
                    ->icon(Heroicon::OutlinedMapPin)
                    ->columns()
                    ->components([
                        TextEntry::make('activityCounty.name')
                            ->label(__('field.county')),

                        TextEntry::make('activityCities.formatted_name')
                            ->label(__('field.cities'))
                            ->html(),
                    ]),
            ]);
    }
}
