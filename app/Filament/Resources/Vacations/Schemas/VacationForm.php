<?php

declare(strict_types=1);

namespace App\Filament\Resources\Vacations\Schemas;

use Filament\Schemas\Components\Grid;
use App\Enums\VacationType;
use App\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;

class VacationForm
{
    public static function getSchema(): array
    {
        return [
            Select::make('type')
                ->label(__('field.type'))
                ->options(VacationType::options())
                ->enum(VacationType::class)
                ->required(),

            Grid::make()
                ->columnSpanFull()
                ->schema([
                    DatePicker::make('start_date')
                        ->label(__('field.start_date'))
                        ->required(),

                    DatePicker::make('end_date')
                        ->label(__('field.end_date'))
                        ->afterOrEqual('start_date')
                        ->required(),
                ]),

            Textarea::make('notes')
                ->label(__('field.notes'))
                ->columnSpanFull()
                ->autosize(false)
                ->rows(4)
                ->extraInputAttributes([
                    'class' => 'resize-none',
                ]),
        ];
    }
}
