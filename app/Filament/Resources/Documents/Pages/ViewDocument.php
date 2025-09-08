<?php

declare(strict_types=1);

namespace App\Filament\Resources\Documents\Pages;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Actions\Action;
use App\Concerns\InteractsWithBeneficiary;
use App\Contracts\Pages\WithSidebar;
use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Filament\Resources\Beneficiaries\Concerns\HasSidebar;
use App\Filament\Resources\Documents\DocumentResource;
use App\Filament\Resources\Documents\Concerns\HasRecordBreadcrumb;
use App\Forms\Components\DocumentPreview;
use App\Forms\Components\FileList;
use App\Forms\Components\Subsection;
use App\Forms\Components\Value;
use App\Models\Document;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewDocument extends ViewRecord implements WithSidebar
{
    use HasRecordBreadcrumb;
    use HasSidebar;
    use InteractsWithBeneficiary;

    protected static string $resource = DocumentResource::class;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->heading(__('document.summary'))
                    ->columns()
                    ->headerActions(fn (Document $record) => [
                        Action::make('edit')
                            ->label(__('document.action.edit'))
                            ->url(BeneficiaryResource::getUrl('documents.edit', [
                                $this->getBeneficiary(),
                                $this->getRecord(),
                            ]))
                            ->color('gray'),
                    ])
                    ->schema([
                        Subsection::make()
                            ->icon('heroicon-o-document-text')
                            ->columns(2)
                            ->schema([
                                Value::make('title')
                                    ->label(__('field.document_title')),

                                Value::make('type')
                                    ->label(__('field.document_type')),

                                FileList::make('document')
                                    ->label(__('field.file'))
                                    ->columnSpanFull(),
                            ]),

                        Subsection::make()
                            ->icon('heroicon-o-chat-bubble-bottom-center-text')
                            ->schema([
                                Value::make('notes')
                                    ->label(__('field.notes')),
                            ]),
                    ]),

                Section::make()
                    ->visible(fn (Document $record) => $record->hasMedia('default'))
                    ->heading(__('document.preview'))
                    ->headerActions(function (Document $record) {
                        $media = $record->getFirstMedia('default');

                        return [
                            Action::make('download')
                                ->label(__('document.action.download'))
                                ->url($media?->getFullUrl())
                                ->color('gray')
                                ->icon('heroicon-o-arrow-down-tray')
                                ->extraAttributes([
                                    'download' => $media?->original_file_name,
                                ]),
                        ];
                    })
                    ->schema([
                        DocumentPreview::make(),
                    ]),
            ]);
    }
}
