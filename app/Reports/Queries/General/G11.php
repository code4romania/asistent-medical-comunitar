<?php

declare(strict_types=1);

namespace App\Reports\Queries\General;

use App\Enums\Intervention\Status;
use App\Filament\Resources\BeneficiaryResource;
use App\Models\Intervention;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Tpetry\QueryExpressions\Language\Alias;

class G11 extends ReportQuery
{
    /*
     * Sum Servicii=Tratament medicamentos (STI_01); Status=realizat.
     */
    public static function query(): Builder
    {
        return Intervention::query()
            ->without('appointment', 'interventionable')
            ->whereRealizedIndividualServiceWithCode('STI_01');
    }

    public static function dateColumn(): string
    {
        return 'interventionable_individual_services.date';
    }

    public static function columns(): array
    {
        return [
            'id' => __('field.id'),
            'vulnerability_label' => __('field.addressed_vulnerability'),
            'status' => __('field.status'),
            'integrated' => __('field.integrated'),
            'beneficiary' => __('field.beneficiary'),
            'date' => __('field.date'),
            'outside_working_hours' => __('field.outside_working_hours'),
        ];
    }

    public static function tapQuery(Builder $query): Builder
    {
        return $query
            ->leftJoin('beneficiaries', 'interventions.beneficiary_id', '=', 'beneficiaries.id')
            ->select([
                new Alias('interventions.id', 'id'),
                new Alias('interventionable_individual_services.status', 'status'),
                new Alias('interventions.integrated', 'integrated'),
                new Alias('beneficiaries.full_name', 'beneficiary'),
                new Alias('interventionable_individual_services.outside_working_hours', 'outside_working_hours'),
                new Alias('interventionable_individual_services.date', 'date'),
                'interventions.beneficiary_id',
                'interventionable_id',
                'interventionable_type',
                'vulnerability_label',
            ])
            ->withCasts([
                'outside_working_hours' => 'boolean',
                'date' => 'date',
            ]);
    }

    public static function recordActionUrl(Model $record): ?string
    {
        return BeneficiaryResource::getUrl(
            name: 'interventions.view',
            params: [
                'beneficiary' => $record->beneficiary_id,
                'record' => $record,
            ],
            isAbsolute: false
        );
    }
}
