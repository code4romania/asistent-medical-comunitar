<?php

declare(strict_types=1);

namespace App\Reports\Queries\Child;

use App\Enums\Beneficiary\ReasonRemoved;
use App\Models\Beneficiary;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

class C17 extends ReportQuery
{
    /**
     * Sum beneficiari with reason_removed=Deces la domiciliu ; Copil 0-1 ani (VCV_01) OR Copil 1-5 ani (VCV_02) OR Copil 5-14 ani (VCV_03).
     */
    public static function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasVulnerabilities(function (Builder $query) {
                $query->whereJsonOverlaps('properties', ['VCV_01', 'VCV_02', 'VCV_03']);
            })
            ->whereHas('activities', function (Builder $query) {
                $query->where('properties->attributes->reason_removed', ReasonRemoved::DECEASED_HOME);
            });
    }
}
