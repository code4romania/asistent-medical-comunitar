<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Resources\Interventions\Schemas;

use App\Filament\Infolists\Components\BooleanEntry;
use App\Filament\Schemas\Components\Subsection;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class IndividualServiceInfolist
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
                            ->schema([
                                TextEntry::make('name')
                                    ->label(__('field.service')),

                                TextEntry::make('vulnerability_label')
                                    ->label(__('field.addressed_vulnerability')),

                                BooleanEntry::make('integrated')
                                    ->label(__('field.integrated')),

                                BooleanEntry::make('interventionable.outside_working_hours')
                                    ->label(__('field.outside_working_hours')),

                                TextEntry::make('status')
                                    ->label(__('field.status')),

                                TextEntry::make('interventionable.date')
                                    ->label(__('field.date'))
                                    ->date(),
                            ]),

                        Subsection::make()
                            ->icon(Heroicon::OutlinedChatBubbleBottomCenterText)
                            ->schema([
                                TextEntry::make('notes')
                                    ->label(__('field.notes')),
                            ]),
                    ]),
            ]);
    }
}
