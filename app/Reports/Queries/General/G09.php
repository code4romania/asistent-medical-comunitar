<?php

declare(strict_types=1);

namespace App\Reports\Queries\General;

use App\Models\Beneficiary;
use App\Models\Disease;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class G09 extends ReportQuery
{
    /**
     * Sum beneficiari with HIV (VSG_HIV); Adult 18-65 ani (VCV_05).
     */
    public static function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonContains('properties', 'VCV_05');
            })
            ->whereHasCatagraphyRelation(Disease::class, function (QueryBuilder $query) {
                $query->where('properties->attributes->category', 'VSG_HIV');
            });
    }
}
