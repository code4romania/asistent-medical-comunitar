<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Tables\Columns\TextColumn;
use App\Models\Document;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
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
                        ->required(),

                    TextInput::make('type')
                        ->label(__('field.document_type'))
                        ->nullable(),

                    SpatieMediaLibraryFileUpload::make('document')
                        ->label(__('field.file'))
                        ->maxSize(1024 * 1024 * 2)
                        ->columnSpanFull(),

                    Textarea::make('notes')
                        ->label(__('field.notes'))
                        ->nullable()
                        ->columnSpanFull(),
                ]),
        ];
    }
}
