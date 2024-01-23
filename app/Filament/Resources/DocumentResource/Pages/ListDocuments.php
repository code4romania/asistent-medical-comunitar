<?php

declare(strict_types=1);

namespace App\Filament\Resources\DocumentResource\Pages;

use App\Concerns\InteractsWithBeneficiary;
use App\Contracts\Pages\WithSidebar;
use App\Filament\Resources\BeneficiaryResource\Concerns;
use App\Filament\Resources\DocumentResource;
use App\Filament\Resources\DocumentResource\Concerns\HasRecordBreadcrumb;
use App\Models\Document;
use Filament\Pages\Actions as PageActions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions as TableActions;
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
            PageActions\CreateAction::make()
                ->label(__('document.action.create'))
                ->modalHeading(__('document.action.create'))
                ->icon('heroicon-o-plus-circle')
                ->disableCreateAnother()
                ->using(function (array $data, $livewire) {
                    $data['beneficiary_id'] = $livewire->getBeneficiary()?->id;

                    Document::create($data);
                })
                ->form(DocumentResource::getFormSchema()),
        ];
    }

    protected function getTableEmptyStateIcon(): ?string
    {
        return 'icon-clipboard';
    }

    protected function getTableEmptyStateHeading(): ?string
    {
        return __('document.empty.title');
    }

    protected function getTableEmptyStateDescription(): ?string
    {
        return __('document.empty.description');
    }

    protected function getTableEmptyStateActions(): array
    {
        return [
            TableActions\CreateAction::make()
                ->label(__('document.action.create'))
                ->modalHeading(__('document.action.create'))
                ->disableCreateAnother()
                ->using(function (array $data, $livewire) {
                    $data['beneficiary_id'] = $livewire->getBeneficiary()?->id;

                    Document::create($data);
                })
                ->form(DocumentResource::getFormSchema())
                ->color('secondary'),
        ];
    }
}
