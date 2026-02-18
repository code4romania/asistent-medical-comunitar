<?php

declare(strict_types=1);

namespace App\Reports\Queries\General;

use App\Models\Beneficiary;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

class G17 extends ReportQuery
{
    /*
     * Sum beneficiari with Dizabilitate cu certificat (VDH_01) + Dizabilitate fără certificat (VDH_02); Vârstnic peste 65 ani (VCV_06)
     */
    public static function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query
                    ->whereJsonOverlaps('properties', ['VDH_01', 'VDH_02'])
                    ->whereJsonContains('properties', 'VCV_06');
            });
    }
}
