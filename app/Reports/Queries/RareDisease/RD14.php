<?php

declare(strict_types=1);

namespace App\Reports\Queries\RareDisease;

use App\Models\Beneficiary;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

class RD14 extends ReportQuery
{
    /**
     * Sum beneficiari with AC-nefroblastom (VBR_NFB).
     */
    public static function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonContains('properties', 'VBR_NFB');
            });
    }
}
