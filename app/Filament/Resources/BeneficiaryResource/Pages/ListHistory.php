<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Pages;

use App\Concerns\InteractsWithBeneficiary;
use App\Contracts\Pages\WithSidebar;
use App\Filament\Resources\BeneficiaryResource\Concerns;
use App\Filament\Resources\HistoryResource;
use App\Models\Activity;
use App\Models\Beneficiary;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListHistory extends ListRecords implements WithSidebar
{
    use Concerns\HasActions;
    use Concerns\HasRecordBreadcrumb;
    use Concerns\HasSidebar;
    use InteractsWithBeneficiary;

    protected static string $resource = HistoryResource::class;

    public function mount(): void
    {
        parent::mount();

        $this->resolveBeneficiary(request()->record);
    }

    protected function getTableQuery(): Builder
    {
        return Activity::query()
            ->whereMorphRelation('subject', Beneficiary::class, 'id', $this->getBeneficiary()->id)
            ->orWhereJsonContains('properties->beneficiary_id', $this->getBeneficiary()->id);
    }

    public function getTitle(): string
    {
        return __('activity.label');
    }

    public function getBreadcrumb(): string
    {
        return $this->getTitle();
    }

    protected function getActions(): array
    {
        return [];
    }
}
