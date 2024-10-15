<?php

declare(strict_types=1);

namespace App\Reports\Queries\Pregnant;

use App\Models\Beneficiary;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

class P10 extends ReportQuery
{
    /**
     * Sum beneficiari with Gravidă adultă (VGR_04) OR Minoră gravidă (VGR_01); Educație - consiliere gravidă (SES_13).
     */
    public static function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonOverlaps('properties', ['VGR_04', 'VGR_01']);
            })
            ->whereHas('interventions', function (Builder $query) {
                $query->whereRealizedIndividualServiceWithCode('SES_13');
            });
    }
}
