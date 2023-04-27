<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Pages;

use App\Contracts\Pages\WithSidebar;
use App\Filament\Resources\BeneficiaryResource\Concerns;
use App\Filament\Resources\InterventionResource;
use App\Models\Beneficiary;
use App\Models\Intervention\Intervention;
use App\Models\Vulnerability\Vulnerability;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
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
            ->withWhereHas('interventions', function ($query) {
                $query->where('beneficiary_id', $this->record?->id)
                    ->with('service');
            });
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
                ->model(Intervention::class)
                ->disableCreateAnother()
                ->using(function (array $data) {
                    $data['beneficiary_id'] = data_get($this->getRecord(), 'id');

                    return Intervention::create($data);
                })
                ->form(InterventionResource::getIndividualServiceFormSchema()),

            Actions\CreateAction::make('open_case')
                ->label(__('intervention.action.open_case'))
                ->icon('heroicon-o-folder-add'),
            // ->modalHeading(__('beneficiary.action_convert_confirm.title'))
            // ->modalSubheading(__('beneficiary.action_convert_confirm.text'))
            // ->modalButton(__('beneficiary.action_convert_confirm.action'))
            // ->modalWidth('md')
            // ->centerModal(false)

        ];
    }
}
