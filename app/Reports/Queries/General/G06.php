<?php

declare(strict_types=1);

namespace App\Reports\Queries\General;

use App\Models\Beneficiary;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

class G06 extends ReportQuery
{
    /**
     * Sum beneficiari with Adult sau vârstnic fără familie (VFA_01); Vârstnic peste 65 ani (VCV_06).
     */
    public static function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonContains('properties', ['VFA_01', 'VCV_06']);
            });
    }
}
