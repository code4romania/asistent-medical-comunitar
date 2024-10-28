<?php

declare(strict_types=1);

namespace App\Reports\Queries\Pregnant;

use App\Models\Beneficiary;
use App\Models\Catagraphy;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class P03 extends ReportQuery
{
    /**
     * Sum beneficiari with Gravidă adultă (VGR_04) OR Minoră gravidă (VGR_01); Femeie însărcinată care a efectuat consultaţii prenatale (VGR_96).
     */
    public static function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonOverlaps('properties', ['VGR_04', 'VGR_01']);
            })
            ->whereHasCatagraphyRelation(Catagraphy::class, function (QueryBuilder $query) {
                $query->whereJsonContains('properties->attributes->cat_preg', 'VGR_96');
            });
    }
}
