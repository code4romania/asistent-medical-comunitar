<?php

declare(strict_types=1);

namespace App\Reports\Queries\Activity;

use App\Enums\Beneficiary\Status;
use App\Models\Beneficiary;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

class A03 extends ReportQuery
{
    /**
     * Total beneficiari proprii cu status Activ în perioada de referință.
     */
    public static function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasActivity(function (Builder $query) {
                $query
                    ->where('log_name', 'default')
                    ->where('event', 'created')
                    ->where('properties->attributes->status', Status::ACTIVE);
            });
    }

    public static function dateColumn(string $type): string
    {
        return 'beneficiaries.created_at';
    }
}
