<?php

declare(strict_types=1);

namespace App\Reports\Queries\Activity;

use App\Enums\Beneficiary\Type;
use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Builder;

/**
 * Total beneficiari (proprii) nou-adăugați în perioada de referință.
 */
class A01 extends ActivityQuery
{
    public static function query(): Builder
    {
        return Beneficiary::query()
            ->whereHasActivity(function (Builder $query) {
                $query
                    ->where('log_name', 'default')
                    ->where('event', 'created')
                    ->where('properties->attributes->type', Type::REGULAR);
            });
    }

    public static function dateColumn(string $type): string
    {
        return 'beneficiaries.created_at';
    }

    public static function aggregateByColumn(): string
    {
        return 'beneficiary_id';
    }

    public static function includeLatestBeforeRange(): bool
    {
        return false;
    }
}
