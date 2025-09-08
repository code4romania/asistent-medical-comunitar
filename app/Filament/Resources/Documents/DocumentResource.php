<?php

declare(strict_types=1);

namespace App\Filament\Resources\Documents;

use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use Filament\Actions\ViewAction;
use Filament\Schemas\Components\Grid;
use App\Models\Document;
use App\Tables\Columns\TextColumn;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

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
            ->recordActions([
                ViewAction::make()
                    ->url(fn (Document $record) => BeneficiaryResource::getUrl('documents.view', [
                        'beneficiary' => $record->beneficiary_id,
                        'record' => $record->id,
                    ]))
                    ->iconButton(),
            ])
            ->toolbarActions([
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
