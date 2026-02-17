<?php

declare(strict_types=1);

namespace App\Reports\Queries\Pregnant;

use App\Models\Beneficiary;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

class P02 extends ReportQuery
{
    /**
     * Sum beneficiari with Gravidă adultă (VGR_04) OR Minoră gravidă (VGR_01); Boală cronică (VSG_01) OR Episod acut recent (VSG_02).
     */
    public static function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query
                    ->whereJsonOverlaps('properties', ['VSG_01', 'VSG_02'])
                    ->whereJsonOverlaps('properties', ['VGR_04', 'VGR_01']);
            });
    }
}
