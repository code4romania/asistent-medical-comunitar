<?php

declare(strict_types=1);

namespace App\Tables\Columns;

use App\Enums\Intervention\Status;
use App\Filament\Resources\BeneficiaryResource;
use App\Models\Intervention\CaseManagement;
use App\Models\Intervention\IndividualService;
use Filament\Tables\Columns\Column;
use Illuminate\Support\Collection;

class InterventionsColumn extends Column
{
    protected string $view = 'tables.columns.interventions-column';

    protected array $relations = [
        'interventions',
        'cases',
    ];

    public function interventions(): Collection
    {
        $interventions = collect();

        foreach ($this->relations as $relation) {
            $interventions->push(
                $this->getRecord()->{$relation}
            );
        }

        return $interventions
            ->flatten()
            ->sortBy('id', \SORT_NUMERIC);
    }

    public function getNameColumn(CaseManagement|IndividualService $intervention): ?string
    {
        return match (\get_class($intervention)) {
            CaseManagement::class => $intervention->name,
            IndividualService::class => $intervention->service->name,
            default => null,
        };
    }

    public function getTypeColumn(CaseManagement|IndividualService $intervention): ?string
    {
        if ($intervention instanceof CaseManagement) {
            if ($intervention->imported) {
                return __('case.type.ocasional');
            }

            return __('case.type.case');
        }

        return __('intervention.type.individual');
    }

    public function getStatusColumn(CaseManagement|IndividualService $intervention): ?string
    {
        if ($intervention instanceof CaseManagement) {
            return $intervention->status;
        }

        return $intervention->status?->label();
    }

    public function getServicesColumn(CaseManagement|IndividualService $intervention): string
    {
        if ($intervention instanceof CaseManagement) {
            $performed = $intervention->realized_interventions_count;
            $total = $intervention->interventions_count;
        } else {
            $performed = $intervention->status->is(Status::REALIZED) ? 1 : 0;
            $total = 1;
        }

        return $performed . '/' . $total;
    }

    public function getActionUrl(CaseManagement|IndividualService $intervention): string
    {
        if ($intervention instanceof CaseManagement) {
            return BeneficiaryResource::getUrl('interventions.view', [
                'record' => $intervention->beneficiary_id,
                'intervention' => $intervention->id,
            ]);
        }

        return '#';
    }

    public function getActionLabel(CaseManagement|IndividualService $intervention): string
    {
        if ($intervention instanceof CaseManagement) {
            return __('intervention.action.view_case');
        }

        return __('intervention.action.view_individual');
    }
}
