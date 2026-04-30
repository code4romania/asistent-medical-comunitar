<?php

declare(strict_types=1);

namespace App\Reports\Queries\Child;

use App\Models\Beneficiary;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

/**
 * Sum beneficiari with Copil născut prematur (VSC_10).
 */
class C02 extends ReportQuery
{
    public static function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonContains('properties', 'VSC_10');
            });
    }

    public static function aggregateByColumn(): string
    {
        return 'beneficiary_id';
    }
}
