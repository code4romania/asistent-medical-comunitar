<?php

declare(strict_types=1);

namespace App\Reports\Queries\General;

use App\Models\Beneficiary;
use App\Models\Disease;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class G18 extends ReportQuery
{
    /**
     * Sum beneficiari with Tulburări mintale şi de comportament (VSG_TMC); Vârstnic peste 65 ani (VCV_06).
     */
    public static function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonContains('properties', 'VCV_06');
            })
            ->whereHasCatagraphyRelation(Disease::class, function (QueryBuilder $query) {
                $query->where('properties->attributes->category', 'VSG_TMC');
            });
    }
}
