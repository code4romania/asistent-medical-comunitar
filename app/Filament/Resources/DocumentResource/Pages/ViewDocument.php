<?php

declare(strict_types=1);

namespace App\Filament\Resources\DocumentResource\Pages;

use App\Concerns\InteractsWithBeneficiary;
use App\Contracts\Pages\WithSidebar;
use App\Filament\Forms\Components\Card;
use App\Filament\Forms\Components\FileList;
use App\Filament\Forms\Components\Subsection;
use App\Filament\Forms\Components\Value;
use App\Filament\Resources\BeneficiaryResource;
use App\Filament\Resources\BeneficiaryResource\Concerns\HasSidebar;
use App\Filament\Resources\DocumentResource;
use App\Filament\Resources\DocumentResource\Concerns\HasRecordBreadcrumb;
use App\Models\Document;
use Filament\Pages\Actions;
use Filament\Resources\Form;
use Filament\Resources\Pages\ViewRecord;

class ViewDocument extends ViewRecord implements WithSidebar
{
    use HasRecordBreadcrumb;
    use HasSidebar;
    use InteractsWithBeneficiary;

    protected static string $resource = DocumentResource::class;

    protected function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->header(__('document.summary'))
                    ->columns()
                    ->componentActions(fn (Document $record) => [
                        Actions\Action::make('edit')
                            ->label(__('document.action.edit'))
                            ->url(BeneficiaryResource::getUrl('documents.edit', [
                                $this->getBeneficiary(),
                                $this->getRecord(),
                            ]))
                            ->color('secondary'),
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
                            ->icon('heroicon-o-annotation')
                            ->schema([
                                Value::make('notes')
                                    ->label(__('field.notes')),
                            ]),
                    ]),

            ]);
    }
}
