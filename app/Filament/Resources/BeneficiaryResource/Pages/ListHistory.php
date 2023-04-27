<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Pages;

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
    use Concerns\InteractsWithBeneficiaryRecord;

    protected static string $resource = HistoryResource::class;

    protected function getTableQuery(): Builder
    {
        return Activity::whereMorphRelation('subject', Beneficiary::class, 'id', $this->getRecord()->id);
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
