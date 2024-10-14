<?php

declare(strict_types=1);

namespace App\Reports\Queries\Child;

use App\Models\Beneficiary;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

class C06 extends ReportQuery
{
    /**
     * Sum beneficiari with Copil care nu primește vitamina D și Fier (VSC_03); Copil 0-1 ani (VCV_01) OR Copil 1-5 ani (VCV_02) OR Copil 5-14 ani (VCV_03).
     */
    public static function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonContains('properties', 'VSC_03')
                    ->whereJsonOverlaps('properties', ['VCV_01', 'VCV_02', 'VCV_03']);
            });
    }
}
