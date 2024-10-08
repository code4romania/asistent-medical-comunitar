<?php

declare(strict_types=1);

namespace App\Reports\Queries\General;

use App\Models\Beneficiary;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

class G24 extends ReportQuery
{
    /**
     * Sum beneficiari fără vulenrabilități; Adult 18-65 ani (VCV_05).
     */
    public static function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonContains('properties', 'VCV_05')
                    // TODO: don't count properties ending in 97, 98, 99
                    ->whereJsonLength('properties', 1);
            });
    }
}
