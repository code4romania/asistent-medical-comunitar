<?php

declare(strict_types=1);

namespace App\Filament\Resources\Documents\Pages;

use App\Filament\Resources\Beneficiaries\Concerns\HasActions;
use App\Filament\Resources\Beneficiaries\Concerns\HasSidebar;
use App\Filament\Resources\Beneficiaries\Concerns\ListRecordsForBeneficiary;
use Filament\Actions\CreateAction;
use App\Concerns\HasConditionalTableEmptyState;
use App\Concerns\InteractsWithBeneficiary;
use App\Contracts\Pages\WithSidebar;
use App\Filament\Resources\BeneficiaryResource\Concerns;
use App\Filament\Resources\Documents\DocumentResource;
use App\Filament\Resources\Documents\Actions\CreateDocumentAction;
use App\Filament\Resources\Documents\Concerns\HasRecordBreadcrumb;
use App\Models\Document;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class ListDocuments extends ListRecords implements WithSidebar
{
    use HasConditionalTableEmptyState;
    use HasActions;
    use HasSidebar;
    use ListRecordsForBeneficiary;
    use InteractsWithBeneficiary;
    use HasRecordBreadcrumb {
        HasRecordBreadcrumb::getBreadcrumbs insteadof ListRecordsForBeneficiary;
    }

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

    public function getTitle(): string
    {
        return __('beneficiary.section.documents');
    }

    public function getBreadcrumb(): string
    {
        return $this->getTitle();
    }

    protected function getHeaderActions(): array
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
            CreateAction::make()
                ->label(__('document.action.create'))
                ->modalHeading(__('document.action.create'))
                ->createAnother(false)
                ->using(function (array $data, $livewire) {
                    $data['beneficiary_id'] = $livewire->getBeneficiary()?->id;

                    return Document::create($data);
                })
                ->schema(DocumentResource::getFormSchema())
                ->color('gray')
                ->hidden(fn () => $this->hasAlteredTableQuery()),
        ];
    }
}
