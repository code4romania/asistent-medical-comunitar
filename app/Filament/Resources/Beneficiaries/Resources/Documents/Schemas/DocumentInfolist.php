<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Resources\Documents\Schemas;

use App\Filament\Resources\Beneficiaries\Resources\Documents\DocumentResource;
use App\Filament\Schemas\Components\Subsection;
use App\Forms\Components\DocumentPreview;
use App\Models\Document;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DocumentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make()
                    ->heading(__('document.summary'))
                    ->columns()
                    ->headerActions([
                        EditAction::make()
                            ->label(__('document.action.edit'))
                            ->url(fn (Document $record) => DocumentResource::getUrl('edit', [
                                'beneficiary' => $record->beneficiary_id,
                                'record' => $record->id,
                            ]))
                            ->color('gray'),
                    ])
                    ->schema([
                        Subsection::make()
                            ->icon('heroicon-o-document-text')
                            ->columns()
                            ->schema([
                                TextEntry::make('title')
                                    ->label(__('field.document_title')),

                                TextEntry::make('type')
                                    ->label(__('field.document_type')),

                                TextEntry::make('notes')
                                    ->label(__('field.notes'))
                                    ->wrap()
                                    ->columnSpanFull(),
                            ]),

                        Subsection::make()
                            ->icon('heroicon-o-chat-bubble-bottom-center-text')
                            ->schema([
                                TextEntry::make('notes')
                                    ->label(__('field.notes')),
                            ]),
                    ]),

                Section::make()
                    ->visible(fn (Document $record) => $record->hasMedia('default'))
                    ->heading(__('document.preview'))
                    ->headerActions([
                        Action::make('download')
                            ->label(__('document.action.download'))
                            ->url(fn (Document $record) => $record->getFirstMediaUrl('default'))
                            ->color('gray')
                            ->icon('heroicon-o-arrow-down-tray')
                            ->extraAttributes(fn (Document $record) => [
                                'download' => $record->getFirstMedia('default')?->original_file_name,
                            ]),
                    ])

                    ->schema([
                        DocumentPreview::make(),
                    ]),
            ]);
    }
}
