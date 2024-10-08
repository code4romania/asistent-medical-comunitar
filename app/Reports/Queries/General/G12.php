<?php

declare(strict_types=1);

namespace App\Reports\Queries\General;

use App\Models\Beneficiary;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

class G12 extends ReportQuery
{
    /*
     * Sum beneficiari with at least one vulnerability; Adult 18-65 ani (VCV_05)
     */
    public static function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonContains('properties', 'VCV_05')
                    ->whereJsonLength('properties', '>', 1);
            });
    }
}
