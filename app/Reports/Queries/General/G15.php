<?php

declare(strict_types=1);

namespace App\Reports\Queries\General;

use App\Filament\Resources\BeneficiaryResource;
use App\Models\Beneficiary;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

class G15 extends ReportQuery
{
    /**
     * Sum beneficiari with Boală cronică (VSG_01); Vârstnic peste 65 ani (VCV_06).
     */
    public static function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonContains('properties', ['VSG_01', 'VCV_06']);
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