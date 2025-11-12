<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Schemas;

use App\Filament\Infolists\Components\Household;
use App\Filament\Infolists\Components\Location;
use App\Filament\Schemas\Components\Subsection;
use App\Models\Beneficiary;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OcasionalBeneficiaryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make()
                    ->schema([
                        Subsection::make()
                            ->icon('heroicon-o-user')
                            ->schema([
                                TextEntry::make('has_unknown_identity')
                                    ->formatStateUsing(fn (bool $state) => $state ? __('field.has_unknown_identity') : null)
                                    ->visible(fn (bool $state) => $state)
                                    ->hiddenLabel(),

                                Grid::make()
                                    ->hidden(fn (Beneficiary $record) => $record->has_unknown_identity)
                                    ->schema([
                                        TextEntry::make('first_name')
                                            ->label(__('field.first_name')),

                                        TextEntry::make('last_name')
                                            ->label(__('field.last_name')),

                                        TextEntry::make('gender')
                                            ->label(__('field.gender')),

                                        TextEntry::make('cnp_with_fallback')
                                            ->label(__('field.cnp')),
                                    ]),
                            ]),

                        Household::make(),

                        Location::make(),

                        Subsection::make()
                            ->icon('heroicon-o-bolt')
                            ->schema([
                                RepeatableEntry::make('ocasionalInterventions')
                                    ->label(__('intervention.label.plural'))
                                    ->columns()
                                    ->schema([
                                        TextEntry::make('reason')
                                            ->label(__('field.intervention_name')),

                                        TextEntry::make('date')
                                            ->label(__('field.date'))
                                            ->date(),

                                        TextEntry::make('services.name')
                                            ->label(__('field.services_offered'))
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Subsection::make()
                            ->icon('heroicon-o-chat-bubble-bottom-center-text')
                            ->schema([
                                TextEntry::make('notes')
                                    ->label(__('field.beneficiary_notes'))
                                    ->extraAttributes(['class' => 'prose max-w-none'])
                                    ->html(),
                            ]),
                    ]),
            ]);
    }
}
