<?php

declare(strict_types=1);

namespace App\Reports\Queries\General;

use App\Models\Beneficiary;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

class G23 extends ReportQuery
{
    /**
     * Sum beneficiari with Lăuză adultă (VGR_08) + Minoră lăuză (VGR_02).
     */
    public static function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonContains('properties', 'VGR_08')
                    ->orWhereJsonContains('properties', 'VGR_02');
            });
    }
}
