<?php

declare(strict_types=1);

namespace App\Reports\Queries\Pregnant;

use App\Models\Beneficiary;
use App\Models\Vulnerability\Vulnerability;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

class P01 extends ReportQuery
{
    /**
     * Sum beneficiari with Gravidă adultă (VGR_04) OR Minoră gravidă (VGR_01); At least one vulnerabilty from Vulnerbailități socio-economice section.
     */
    public static function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonOverlaps('properties', ['VGR_04', 'VGR_01'])
                    ->where(function (Builder $query) {
                        $query->whereJsonOverlaps(
                            'properties',
                            Vulnerability::query()
                                ->whereIsSocioEconomic()
                                ->whereIsValid()
                                ->get()
                                ->pluck('id')
                        );
                    });
            });
    }
}
