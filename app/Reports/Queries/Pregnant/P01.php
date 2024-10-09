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
     * Sum beneficiari with Gravidă adultă (VGR_04); At least one vulnerabilty from Vulnerbailități socio-economice section.
     */
    public static function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonContains('properties', 'VGR_04')
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
