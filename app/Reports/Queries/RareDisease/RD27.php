<?php

declare(strict_types=1);

namespace App\Reports\Queries\RareDisease;

use App\Models\Beneficiary;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

class RD27 extends ReportQuery
{
    /**
     * Sum beneficiari with G-fenilcetonurie sau deficit de tetrahidrobiopterină (BH4) (VBR_FDT).
     */
    public static function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonContains('properties', 'VBR_FDT');
            });
    }
}
