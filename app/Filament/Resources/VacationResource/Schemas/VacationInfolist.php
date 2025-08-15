<?php

declare(strict_types=1);

namespace App\Filament\Resources\VacationResource\Schemas;

use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\TextEntry;

class VacationInfolist
{
    public static function getSchema(): array
    {
        return [
            TextEntry::make('type')
                ->label(__('field.type')),

            Grid::make()
                ->columnSpanFull()
                ->schema([
                    TextEntry::make('start_date')
                        ->label(__('field.start_date'))
                        ->date(),

                    TextEntry::make('end_date')
                        ->label(__('field.end_date'))
                        ->date(),
                ]),

            TextEntry::make('notes')
                ->label(__('field.notes'))
                ->columnSpanFull(),
        ];
    }
}
