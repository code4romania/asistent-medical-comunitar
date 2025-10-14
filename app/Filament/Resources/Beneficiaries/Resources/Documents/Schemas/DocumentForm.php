<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Resources\Documents\Schemas;

use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DocumentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
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

                Textarea::make('notes')
                    ->label(__('field.notes'))
                    ->nullable()
                    ->columnSpanFull()
                    ->maxLength(65535),
            ]);
    }
}
