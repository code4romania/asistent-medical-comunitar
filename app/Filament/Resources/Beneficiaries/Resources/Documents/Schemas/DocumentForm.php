<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Resources\Documents\Schemas;

use App\Filament\Schemas\Components\Subsection;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class DocumentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Subsection::make()
                    ->icon(Heroicon::OutlinedDocumentText)
                    ->columns()
                    ->components([
                        TextInput::make('title')
                            ->label(__('field.document_title'))
                            ->maxLength(200)
                            ->required(),

                        TextInput::make('type')
                            ->label(__('field.document_type'))
                            ->maxLength(200)
                            ->nullable(),

                        SpatieMediaLibraryFileUpload::make('document')
                            ->label(__('field.file'))
                            ->maxSize(1024 * 1024 * 2)
                            ->columnSpanFull(),
                    ]),

                Subsection::make()
                    ->icon(Heroicon::OutlinedChatBubbleBottomCenterText)
                    ->components([
                        Textarea::make('notes')
                            ->label(__('field.notes'))
                            ->nullable()
                            ->maxLength(65535),
                    ]),
            ]);
    }
}
