<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Pages;

use App\Contracts\Pages\WithSidebar;
use App\Filament\Resources\BeneficiaryResource\Concerns;
use App\Filament\Resources\InterventionResource;
use App\Models\Intervention;
use App\Models\Vulnerability\Vulnerability;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class ListInterventions extends ListRecords implements WithSidebar
{
    use Concerns\HasActions;
    use Concerns\HasRecordBreadcrumb;
    use Concerns\HasSidebar;
    use Concerns\InteractsWithBeneficiaryRecord;

    protected static string $resource = InterventionResource::class;

    protected function getTableQuery(): Builder
    {
        return Vulnerability::query()
            ->with('category')
            ->withInterventionsForBeneficiary($this->record);
    }

    public function getTitle(): string
    {
        return __('intervention.label.plural');
    }

    public function getBreadcrumb(): string
    {
        return $this->getTitle();
    }

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make('add_service')
                ->label(__('intervention.action.add_service'))
                ->modalHeading(__('intervention.action.add_service'))
                ->icon('heroicon-o-plus-circle')
                ->model(Intervention\IndividualService::class)
                ->disableCreateAnother()
                ->using(function (array $data) {
                    $data['beneficiary_id'] = data_get($this->getRecord(), 'id');
                    $data['status'] = 'REPLACE_ME';

                    return Intervention\IndividualService::create($data);
                })
                ->form(InterventionResource::getIndividualServiceFormSchema()),

            Actions\CreateAction::make('open_case')
                ->label(__('intervention.action.open_case'))
                ->modalHeading(__('intervention.action.open_case'))
                ->icon('heroicon-o-folder-add')
                ->disableCreateAnother()
                ->using(function (array $data) {
                    $data['beneficiary_id'] = data_get($this->getRecord(), 'id');
                    // $data['status'] = 'REPLACE_ME';

                    return Intervention\CaseManagement::create($data);
                })
                ->form(InterventionResource::getCaseFormSchema()),
        ];
    }

    protected function getTableEmptyStateIcon(): ?string
    {
        return 'icon-empty-state';
    }

    protected function getTableEmptyStateHeading(): ?string
    {
        return __('intervention.empty.title');
    }

    protected function getTableEmptyStateActions(): array
    {
        return [
            Tables\Actions\Action::make('create')
                ->label(__('intervention.empty.create'))
                // ->url(static::getResource()::getUrl('create'))
                ->button()
                ->color('secondary'),
        ];
    }
}
