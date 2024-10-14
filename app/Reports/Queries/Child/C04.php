<?php

declare(strict_types=1);

namespace App\Reports\Queries\Child;

use App\Models\Beneficiary;
use App\Models\Disease;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class C04 extends ReportQuery
{
    /**
     * Sum beneficiari with Boală infecţioasă (VSG_BI); Copil 0-1 ani (VCV_01) OR Copil 1-5 ani (VCV_02) OR Copil 5-14 ani (VCV_03).
     */
    public static function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonOverlaps('properties', ['VCV_01', 'VCV_02', 'VCV_03']);
            })
            ->whereHasCatagraphyRelation(Disease::class, function (QueryBuilder $query) {
                $query->where('properties->attributes->category', 'VSG_BI');
            });
    }
}
