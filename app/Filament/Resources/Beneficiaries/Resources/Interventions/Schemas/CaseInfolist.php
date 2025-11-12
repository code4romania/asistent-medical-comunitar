<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Resources\Interventions\Schemas;

use App\Filament\Infolists\Components\BooleanEntry;
use App\Filament\Schemas\Components\Subsection;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class CaseInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make()
                    ->heading(__('intervention.summary'))
                    ->columns(3)
                    ->components([
                        Subsection::make()
                            ->icon(Heroicon::OutlinedDocumentText)
                            ->columns(2)
                            ->columnSpan([
                                'lg' => 2,
                            ])
                            ->maxWidth(null)
                            ->components([
                                TextEntry::make('interventionable.name')
                                    ->label(__('field.intervention_name')),

                                TextEntry::make('interventionable.initiator')
                                    ->label(__('field.initiator')),

                                TextEntry::make('vulnerability_label')
                                    ->label(__('field.addressed_vulnerability')),

                                BooleanEntry::make('integrated')
                                    ->label(__('field.integrated')),
                            ]),

                        Subsection::make()
                            ->icon(Heroicon::OutlinedChatBubbleBottomCenterText)
                            ->maxWidth(null)
                            ->components([
                                TextEntry::make('notes')
                                    ->label(__('field.notes')),
                            ]),

                        Subsection::make()
                            ->icon(Heroicon::OutlinedClipboardDocumentCheck)
                            ->columnSpanFull()
                            ->maxWidth(null)
                            ->components([
                                TextEntry::make('interventionable.recommendations')
                                    ->label(__('field.monitoring_recommendations')),
                            ]),
                    ]),
            ]);
    }
}
