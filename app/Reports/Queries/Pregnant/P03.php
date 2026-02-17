<?php

declare(strict_types=1);

namespace App\Reports\Queries\Pregnant;

use App\Models\Beneficiary;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

class P03 extends ReportQuery
{
    /**
     * Sum beneficiari with Gravidă adultă (VGR_04) OR Minoră gravidă (VGR_01); Femeie însărcinată care a efectuat consultaţii prenatale (VGR_96).
     */
    public static function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query
                    ->whereJsonContains('properties', 'VGR_96')
                    ->whereJsonOverlaps('properties', ['VGR_04', 'VGR_01']);
            });
    }
}
