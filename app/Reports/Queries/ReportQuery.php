<?php

declare(strict_types=1);

namespace App\Reports\Queries;

use App\Models\Report;
use Illuminate\Database\Eloquent\Builder;

abstract class ReportQuery
{
    abstract public static function query(): Builder;

    abstract public static function dateColumn(): string;

    abstract public static function columns(): array;

    public static function getRecordActions(array $params = []): array
    {
        return [
            //
        ];
    }

    public static function build(Report $report): Builder
    {
        $query = static::query()
            ->select(array_keys(static::columns()));

        if (! $report->date_until) {
            return $query->whereDate(static::dateColumn(), '=', $report->date_from);
        }

        return $query
            ->whereDate(static::dateColumn(), '>=', $report->date_from)
            ->whereDate(static::dateColumn(), '<=', $report->date_until);
    }
}
