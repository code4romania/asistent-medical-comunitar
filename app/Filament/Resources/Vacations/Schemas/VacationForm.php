<?php

declare(strict_types=1);

namespace App\Filament\Resources\Vacations\Schemas;

use App\Enums\VacationType;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class VacationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema

            ->components([
                Select::make('type')
                    ->label(__('field.type'))
                    ->options(VacationType::class)
                    ->required()
                    ->columnSpanFull(),

                DatePicker::make('start_date')
                    ->label(__('field.start_date'))
                    ->required(),

                DatePicker::make('end_date')
                    ->label(__('field.end_date'))
                    ->afterOrEqual('start_date')
                    ->required(),

                Textarea::make('notes')
                    ->label(__('field.notes'))
                    ->columnSpanFull()
                    ->autosize(false)
                    ->rows(4)
                    ->extraInputAttributes([
                        'class' => 'resize-none',
                    ]),
            ]);
    }
}
