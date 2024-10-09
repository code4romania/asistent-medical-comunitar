<?php

declare(strict_types=1);

namespace App\Reports\Queries\General;

use App\Models\Beneficiary;
use App\Models\Vulnerability\Vulnerability;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

class G24 extends ReportQuery
{
    /**
     * Sum beneficiari fără vulnerabilități; Adult 18-65 ani (VCV_05).
     */
    public static function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonContains('properties', 'VCV_05')
                    ->whereJsonDoesntOverlap(
                        'properties',
                        Vulnerability::query()
                            ->whereIsValid()
                            ->get()
                            ->pluck('id')
                    );
            });
    }
}
