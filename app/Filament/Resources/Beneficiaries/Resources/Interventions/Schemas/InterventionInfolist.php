<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Resources\Interventions\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class InterventionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('closed_at')
                    ->dateTime()
                    ->placeholder('-'),
                IconEntry::make('integrated')
                    ->boolean(),
                TextEntry::make('notes')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('interventionable_type'),
                TextEntry::make('interventionable_id')
                    ->numeric(),
                TextEntry::make('vulnerability.name')
                    ->label('Vulnerability')
                    ->placeholder('-'),
                TextEntry::make('vulnerability_label')
                    ->placeholder('-'),
                TextEntry::make('appointment.id')
                    ->label('Appointment')
                    ->placeholder('-'),
                TextEntry::make('parent.id')
                    ->label('Parent')
                    ->placeholder('-'),
            ]);
    }
}
