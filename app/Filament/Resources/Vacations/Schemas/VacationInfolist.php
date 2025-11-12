<?php

declare(strict_types=1);

namespace App\Filament\Resources\Vacations\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class VacationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('type')
                    ->label(__('field.type'))
                    ->columnSpanFull(),

                TextEntry::make('start_date')
                    ->label(__('field.start_date'))
                    ->date(),

                TextEntry::make('end_date')
                    ->label(__('field.end_date'))
                    ->date(),

                TextEntry::make('notes')
                    ->label(__('field.notes'))
                    ->columnSpanFull(),
            ]);
    }
}
