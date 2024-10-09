<?php

declare(strict_types=1);

namespace App\Reports\Queries\Pregnant;

use App\Models\Beneficiary;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

class P09 extends ReportQuery
{
    /**
     * Sum beneficiari with Gravidă adultă (VGR_04) OR Minoră gravidă (VGR_01); Referire către medic de familie (STR_02) OR Însoțire medic de familie (SAI_02) OR Notificare medic de familie (SNF_02).
     */
    public static function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonOverlaps('properties', ['VGR_04', 'VGR_01'])
                    ->whereJsonOverlaps('properties', ['STR_02', 'SAI_02', 'SNF_02']);
            });
    }
}
