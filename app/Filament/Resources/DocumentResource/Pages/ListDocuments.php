<?php

declare(strict_types=1);

namespace App\Filament\Resources\DocumentResource\Pages;

use App\Concerns\HasConditionalTableEmptyState;
use App\Concerns\InteractsWithBeneficiary;
use App\Contracts\Pages\WithSidebar;
use App\Filament\Resources\BeneficiaryResource\Concerns;
use App\Filament\Resources\DocumentResource;
use App\Filament\Resources\DocumentResource\Actions\CreateDocumentAction;
use App\Filament\Resources\DocumentResource\Concerns\HasRecordBreadcrumb;
use App\Models\Document;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class ListDocuments extends ListRecords implements WithSidebar
{
    use HasConditionalTableEmptyState;
    use HasRecordBreadcrumb;
    use Concerns\HasActions;
    use Concerns\HasSidebar;
    use Concerns\ListRecordsForBeneficiary;
    use InteractsWithBeneficiary;

    protected static string $resource = DocumentResource::class;

    public function mount(...$args): void
    {
        parent::mount();

        [$beneficiary] = $args;

        $this->resolveBeneficiary($beneficiary);
    }

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()
            ->whereBeneficiary($this->getBeneficiary());
    }

    protected function getActions(): array
    {
        return [
            CreateDocumentAction::make(),
        ];
    }

    protected function getTableEmptyStateIcon(): ?string
    {
        if ($this->hasAlteredTableQuery()) {
            return null;
        }

        return 'icon-clipboard';
    }

    protected function getTableEmptyStateHeading(): ?string
    {
        if ($this->hasAlteredTableQuery()) {
            return null;
        }

        return __('document.empty.title');
    }

    protected function getTableEmptyStateDescription(): ?string
    {
        if ($this->hasAlteredTableQuery()) {
            return null;
        }

        return __('document.empty.description');
    }

    protected function getTableEmptyStateActions(): array
    {
        return [
            Tables\Actions\CreateAction::make()
                ->label(__('document.action.create'))
                ->modalHeading(__('document.action.create'))
                ->disableCreateAnother()
                ->using(function (array $data, $livewire) {
                    $data['beneficiary_id'] = $livewire->getBeneficiary()?->id;

                    return Document::create($data);
                })
                ->form(DocumentResource::getFormSchema())
                ->color('secondary')
                ->hidden(fn () => $this->hasAlteredTableQuery()),
        ];
    }
}
