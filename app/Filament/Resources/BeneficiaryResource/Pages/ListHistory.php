<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Pages;

use App\Concerns\InteractsWithBeneficiary;
use App\Contracts\Pages\WithSidebar;
use App\Filament\Resources\BeneficiaryResource\Concerns;
use App\Filament\Resources\HistoryResource;
use App\Models\Activity;
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
            ->whereNot('log_name', 'vulnerabilities')
            ->where(function (Builder $query) {
                $beneficiary = $this->getBeneficiary();

                $query->whereMorphedTo('subject', $beneficiary)
                    ->orWhereMorphedTo('subject', $beneficiary->catagraphy);
            })
            ->select([
                'id',
                'created_at',
                'causer_type',
                'causer_id',
                'subject_type',
                'subject_id',
                'log_name',
                'event',
            ])
            ->selectRaw('JSON_LENGTH(JSON_EXTRACT(properties, "$.attributes")) as changes_count');
    }

    public function getTitle(): string
    {
        return __('activity.label');
    }

    public function getBreadcrumb(): string
    {
        return $this->getTitle();
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
