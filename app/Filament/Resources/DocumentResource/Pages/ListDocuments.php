<?php

declare(strict_types=1);

namespace App\Filament\Resources\DocumentResource\Pages;

use App\Concerns\InteractsWithBeneficiary;
use App\Contracts\Pages\WithSidebar;
use App\Filament\Resources\BeneficiaryResource\Concerns;
use App\Filament\Resources\DocumentResource;
use App\Filament\Resources\DocumentResource\Actions\CreateDocumentAction;
use App\Filament\Resources\DocumentResource\Concerns\HasRecordBreadcrumb;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListDocuments extends ListRecords implements WithSidebar
{
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
}
