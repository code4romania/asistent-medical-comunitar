<?php

declare(strict_types=1);

namespace App\Reports\Queries\General;

use App\Models\Beneficiary;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

/**
 * Sum beneficiari with Femeie de vârstă fertilă (VGR_10).
 */
class G01 extends ReportQuery
{
    public static function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonContains('properties', 'VGR_10');
            });
    }

    public static function aggregateByColumn(): string
    {
        return 'beneficiary_id';
    }
}
