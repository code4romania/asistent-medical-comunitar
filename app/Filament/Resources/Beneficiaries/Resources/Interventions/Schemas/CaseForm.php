<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Resources\Interventions\Schemas;

use App\Enums\Intervention\CaseInitiator;
use App\Filament\Resources\Beneficiaries\Resources\Interventions\InterventionResource;
use App\Filament\Schemas\Components\Subsection;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class CaseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Subsection::make()
                    ->icon(Heroicon::OutlinedDocumentText)
                    ->columns(2)
                    ->components([
                        TextInput::make('interventionable.name')
                            ->label(__('field.intervention_name'))
                            ->required()
                            ->maxLength(200)
                            ->columnSpanFull(),

                        Select::make('interventionable.initiator')
                            ->label(__('field.initiator'))
                            ->placeholder(__('placeholder.choose'))
                            ->options(CaseInitiator::class)
                            ->default(CaseInitiator::NURSE)
                            ->required(),

                        Select::make('vulnerability_id')
                            ->label(__('field.addressed_vulnerability'))
                            ->placeholder(__('placeholder.select_one'))
                            ->options(fn (Page $livewire) => InterventionResource::getValidVulnerabilities($livewire->getRecord()))
                            ->in(fn (Page $livewire) => InterventionResource::getValidVulnerabilities($livewire->getRecord())?->keys())
                            ->searchable()
                            ->live()
                            ->required(),

                        Hidden::make('vulnerability_label')
                            ->afterStateHydrated(function (Set $set, $state, Page $livewire) {
                                $vulnerability_id = InterventionResource::getValidVulnerabilities($livewire->getRecord())
                                    ?->filter(fn (string $value) => $value === $state)
                                    ->keys()
                                    ->first();

                                $set('vulnerability_id', $vulnerability_id);
                            }),

                        Radio::make('integrated')
                            ->label(__('field.integrated'))
                            ->inline()
                            ->boolean()
                            ->default(0),
                    ]),

                Subsection::make()
                    ->icon(Heroicon::OutlinedChatBubbleBottomCenterText)
                    ->schema([
                        Textarea::make('notes')
                            ->label(__('field.notes'))
                            ->maxLength(65535)
                            ->nullable()
                            ->autosize()
                            ->rows(4),
                    ]),

                Subsection::make()
                    ->icon(Heroicon::OutlinedClipboardDocumentCheck)
                    ->schema([
                        Textarea::make('interventionable.recommendations')
                            ->label(__('field.monitoring_recommendations'))
                            ->maxLength(65535)
                            ->nullable()
                            ->autosize()
                            ->rows(4),
                    ]),
            ]);
    }
}
