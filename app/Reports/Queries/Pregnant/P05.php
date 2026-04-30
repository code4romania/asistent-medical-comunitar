<?php

declare(strict_types=1);

namespace App\Reports\Queries\Pregnant;

use App\Models\Beneficiary;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

/**
 * Sum beneficiari with Avort medical (VGR_12).
 */
class P05 extends ReportQuery
{
    public static function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonContains('properties', 'VGR_12');
            });
    }

    public static function aggregateByColumn(): string
    {
        return 'beneficiary_id';
    }
}
