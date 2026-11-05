<?php

declare(strict_types=1);

namespace App\Reports\Queries\General;

use App\Models\Beneficiary;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

/**
 * Sum beneficiari with Tuberculoză (VSG_TB); Vârstnic peste 65 ani (VCV_06).
 */
class G16 extends ReportQuery
{
    public static function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonContains('properties', ['VCV_06', 'VSG_TB']);
            });
    }

    public static function aggregateByColumn(): string
    {
        return 'beneficiary_id';
    }
}
