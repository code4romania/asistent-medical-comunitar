<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Tables\Columns\TextColumn;
use App\Models\Document;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static bool $shouldRegisterNavigation = false;

    public static function getModelLabel(): string
    {
        return __('document.label.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('document.label.plural');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label(__('field.date'))
                    ->formatStateUsing(fn ($record) => $record->created_at->toFormattedDate())
                    ->sortable(),

                TextColumn::make('title')
                    ->label(__('field.document_title'))
                    ->wrap()
                    ->sortable()
                    ->searchable()
                    ->limit(),

                TextColumn::make('type')
                    ->label(__('field.document_type'))
                    ->sortable(),

                TextColumn::make('notes')
                    ->label(__('field.notes'))
                    ->searchable()
                    ->wrap()
                    ->limit(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->url(fn (Document $record) => BeneficiaryResource::getUrl('documents.view', [
                        'beneficiary' => $record->beneficiary_id,
                        'record' => $record->id,
                    ]))
                    ->iconButton(),
            ])
            ->bulkActions([
                //
            ])
            ->defaultSort('id', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getFormSchema(): array
    {
        return [
            Grid::make()
                ->schema([
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
                ]),
        ];
    }
}
