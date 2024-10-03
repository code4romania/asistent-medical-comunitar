<?php

declare(strict_types=1);

namespace App\Reports\Queries\Child;

use App\Models\Beneficiary;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\BeneficiaryResource;

class C06 extends ReportQuery
{
    /**
     * Sum beneficiari with Copil care nu primește vitamina D și Fier (VCS_03); Copil 0-1 ani (VCV_01) OR Copil 1-5 ani (VCV_02) OR Copil 5-14 ani (VCV_03).
     */
    public static function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonContains('properties', 'VCS_03')
                    ->where(function (Builder $query) {
                        $query->whereJsonContains('properties', 'VCV_01')
                            ->orWhereJsonContains('properties', 'VCV_02')
                            ->orWhereJsonContains('properties', 'VCV_03');
                    });
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
