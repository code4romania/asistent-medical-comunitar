<?php

declare(strict_types=1);

namespace App\Reports\Queries\General;

use App\Models\Beneficiary;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

class G08 extends ReportQuery
{
    /**
     * Sum beneficiari with Tuberculoză (VSG_TB); Adult 18-65 ani (VCV_05).
     *
     * TODO: VSG_TB and VCV_05 are recorded in separate activity log entries. Find a way to combine or query them.
     */
    public static function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonContains('properties', ['VCV_05'])
                    ->where('properties->attributes->category', 'VSG_TB');
            });
    }
}
