<?php

declare(strict_types=1);

namespace App\Filament\Resources\Documents\Pages;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use App\Concerns\InteractsWithBeneficiary;
use App\Contracts\Pages\WithSidebar;
use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Filament\Resources\Beneficiaries\Concerns\HasSidebar;
use App\Filament\Resources\Documents\DocumentResource;
use App\Filament\Resources\Documents\Concerns\HasRecordBreadcrumb;
use App\Forms\Components\Subsection;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\EditRecord;

class EditDocument extends EditRecord implements WithSidebar
{
    use HasRecordBreadcrumb;
    use HasSidebar;
    use InteractsWithBeneficiary;

    protected static string $resource = DocumentResource::class;

    protected function configureDeleteAction(DeleteAction $action): void
    {
        $resource = static::getResource();

        $action
            ->authorize($resource::canDelete($this->getRecord()))
            ->record($this->getRecord())
            ->recordTitle($this->getRecordTitle())
            ->successRedirectUrl($this->getDeleteRedirectUrl());
    }

    protected function getDeleteRedirectUrl(): ?string
    {
        return BeneficiaryResource::getUrl('documents.index', [
            $this->getBeneficiary(),
        ]);
    }

    protected function getRedirectUrl(): ?string
    {
        return BeneficiaryResource::getUrl('documents.view', [
            $this->getBeneficiary(),
            $this->getRecord(),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->heading(__('document.summary'))
                    ->columns()
                    ->schema([
                        Subsection::make()
                            ->icon('heroicon-o-document-text')
                            ->columns(2)
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
                            ]),

                        Subsection::make()
                            ->icon('heroicon-o-chat-bubble-bottom-center-text')
                            ->schema([
                                Textarea::make('notes')
                                    ->label(__('field.notes'))
                                    ->nullable()
                                    ->columnSpanFull()
                                    ->maxLength(65535),
                            ]),
                    ]),
            ]);
    }
}
