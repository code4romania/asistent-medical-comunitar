<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Resources\Interventions\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class InterventionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                DateTimePicker::make('closed_at'),
                Toggle::make('integrated')
                    ->required(),
                Textarea::make('notes')
                    ->columnSpanFull(),
                TextInput::make('interventionable_type')
                    ->required(),
                TextInput::make('interventionable_id')
                    ->required()
                    ->numeric(),
                Select::make('vulnerability_id')
                    ->relationship('vulnerability', 'name'),
                TextInput::make('vulnerability_label'),
                Select::make('appointment_id')
                    ->relationship('appointment', 'id'),
                Select::make('parent_id')
                    ->relationship('parent', 'id'),
            ]);
    }
}
