<?php

declare(strict_types=1);

namespace App\Filament\Resources\DocumentResource\Pages;

use App\Concerns\InteractsWithBeneficiary;
use App\Contracts\Pages\WithSidebar;
use App\Filament\Forms\Components\Card;
use App\Filament\Forms\Components\Subsection;
use App\Filament\Resources\BeneficiaryResource;
use App\Filament\Resources\BeneficiaryResource\Concerns\HasSidebar;
use App\Filament\Resources\DocumentResource;
use App\Filament\Resources\DocumentResource\Concerns\HasRecordBreadcrumb;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Actions\DeleteAction;
use Filament\Resources\Form;
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

    protected function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->header(__('document.summary'))
                    ->columns()
                    ->schema([
                        Subsection::make()
                            ->icon('heroicon-o-document-text')
                            ->columns(2)
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
                            ]),

                        Subsection::make()
                            ->icon('heroicon-o-annotation')
                            ->schema([
                                Textarea::make('notes')
                                    ->label(__('field.notes'))
                                    ->nullable()
                                    ->columnSpanFull(),
                            ]),
                    ]),
            ]);
    }
}
