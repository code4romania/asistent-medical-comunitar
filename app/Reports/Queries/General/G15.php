<?php

declare(strict_types=1);

namespace App\Reports\Queries\General;

use App\Models\Beneficiary;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

/**
 * Sum beneficiari with Boală cronică (VSG_01); Vârstnic peste 65 ani (VCV_06).
 */
class G15 extends ReportQuery
{
    public static function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonContains('properties', ['VSG_01', 'VCV_06']);
            });
    }

    public static function aggregateByColumn(): string
    {
        return 'beneficiary_id';
    }
}
