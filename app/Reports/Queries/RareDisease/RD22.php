<?php

declare(strict_types=1);

namespace App\Reports\Queries\RareDisease;

use App\Models\Beneficiary;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

class RD22 extends ReportQuery
{
    /**
     * Sum beneficiari with G-mucopolizaharidoză tip I (sindromul Hurler) (VBR_TTD).
     */
    public static function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonContains('properties', 'VBR_TTD');
            });
    }
}
