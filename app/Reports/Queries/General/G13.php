<?php

declare(strict_types=1);

namespace App\Reports\Queries\General;

use App\Filament\Resources\BeneficiaryResource;
use App\Models\Beneficiary;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

class G13 extends ReportQuery
{
    /**
     * Sum beneficiari with Adult sau vârstnic fără familie (VFA_01); Adult 18-65 ani (VCV_05).
     */
    public static function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonContains('properties', ['VFA_01', 'VCV_05']);
            });
    }

    public static function dateColumn(): string
    {
        return 'activity_log.created_at';
    }

    public static function columns(): array
    {
        return [
            'id' => __('field.id'),
            'first_name' => __('field.first_name'),
            'last_name' => __('field.last_name'),
            'cnp' => __('field.cnp'),
            'gender' => __('field.gender'),
            'date_of_birth' => __('field.age'),
            'county' => __('field.county'),
            'city' => __('field.city'),
            'status' => __('field.status'),
        ];
    }

    public static function getRecordActions(array $params = []): array
    {
        return [
            BeneficiaryResource::getUrl('view', $params, isAbsolute: false) => __('beneficiary.action.view_details'),
        ];
    }
}
