<?php

declare(strict_types=1);

namespace App\Tables\Columns;

use App\Enums\Intervention\CaseType;
use App\Models\Intervention\CaseManagement;
use App\Models\Intervention\IndividualService;
use App\Models\Intervention\OcasionalIntervention;
use Filament\Tables\Columns\Column;
use Illuminate\Database\Eloquent\Model;
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

    public function getNameColumn(Model $intervention): ?string
    {
        return match (\get_class($intervention)) {
            CaseManagement::class => $intervention->name,
            IndividualService::class => $intervention->service->name,
            OcasionalIntervention::class => 'REPLACE_ME',
            default => null,
        };
    }

    public function getTypeColumn(Model $intervention): ?string
    {
        if ($intervention instanceof CaseManagement) {
            return match ($intervention->type) {
                CaseType::CASE => __('case.type.case'),
                CaseType::OCASIONAL => __('case.type.ocasional')
            };
        }

        return __('intervention.type.individual');
    }
}
