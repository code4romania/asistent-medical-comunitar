<?php

declare(strict_types=1);

namespace App\Reports\Queries;

use App\Enums\AggregateFunction;
use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class ReportQuery
{
    abstract public static function query(): Builder;

    public static function dateColumn(string $type): string
    {
        return 'vulnerability_entries.created_at';
    }

    public static function aggregateFunction(): AggregateFunction
    {
        return AggregateFunction::COUNT;
    }

    public static function aggregateByColumn(): string
    {
        return 'id';
    }

    public static function includeLatestBeforeRange(): bool
    {
        return true;
    }

    public static function distinct(): bool
    {
        return match (static::aggregateFunction()) {
            AggregateFunction::COUNT => true,
            default => false,
        };
    }

    public static function startDateNullable(): bool
    {
        return false;
    }

    public static function endDateNullable(): bool
    {
        return false;
    }

    public static function selectColumns(): array
    {
        return [
            'beneficiaries.id',
            'beneficiaries.first_name',
            'beneficiaries.last_name',
            'beneficiaries.cnp',
            'beneficiaries.gender',
            'beneficiaries.date_of_birth',
            'beneficiaries.status',
            'counties.name as county',
            'cities.name as city',
        ];
    }

    public static function columns(): array
    {
        return [
            'id' => __('field.id'),
            'first_name' => __('field.first_name'),
            'last_name' => __('field.last_name'),
            'cnp' => __('field.cnp'),
            'gender' => __('field.gender'),
            'date_of_birth' => __('field.age'),
            'county' => __('field.county'),
            'city' => __('field.city'),
            'status' => __('field.status'),
        ];
    }

    public static function tapQuery(Builder $query): Builder
    {
        return $query->addSelect([
            'beneficiaries.nurse_id',
        ]);
    }

    public static function where(Builder $query, Report $report): Builder
    {
        return $query;
    }

    public static function recordActionUrl(Model $record): ?string
    {
        return BeneficiaryResource::getUrl(
            'view',
            ['record' => $record],
            false
        );
    }

    public static function recordActionLabel(Model $record): ?string
    {
        return __('report.action.view_details');
    }

    public static function getRecordActions(Model $record): array
    {
        $url = static::recordActionUrl($record);
        $label = static::recordActionLabel($record);

        if (blank($url) || blank($label)) {
            return [];
        }

        return [
            $url => $label,
        ];
    }

    public static function build(Report $report, bool $aggregate = false): Builder
    {
        /** @var Builder */
        $query = static::query()
            ->forUser($report->user);

        if ($aggregate) {
            $query->select(static::aggregateByColumn());

            if (static::distinct()) {
                $query->distinct();
            }
        } else {
            $query
                ->select(static::selectColumns())
                ->tap([static::class, 'tapQuery']);
        }

        if (! $report->date_until) {
            return $query->whereDate(static::dateColumn('start'), '=', $report->date_from);
        }

        if (static::includeLatestBeforeRange()) {
            $union = $query->clone()
                ->whereDate(static::dateColumn('start'), '<', $report->date_from)
                ->latest(static::dateColumn('start'))
                ->limit(1);
        }

        static::where($query, $report);
        static::whereDate($query, 'start', $report->date_from);
        static::whereDate($query, 'end', $report->date_until);

        if (isset($union)) {
            $query->union($union);
        }

        return $query;
    }

    public static function aggregate(Report $report): int|float|string
    {
        $method = static::aggregateFunction()->value;

        return static::build($report, true)
            ->when(static::distinct(), fn (Builder $query) => $query->distinct())
            ->$method(static::aggregateByColumn()) ?? 0;
    }

    public static function whereDate(Builder $query, string $column, ?Carbon $date): Builder
    {
        $condition = match ($column) {
            'start' => static::startDateNullable(),
            'end' => static::endDateNullable(),
        };

        $operator = match ($column) {
            'start' => '>=' ,
            'end' => '<=' ,
        };

        if (! $condition) {
            return $query->whereDate(static::dateColumn($column), $operator, $date);
        }

        return $query->where(
            fn (Builder $query): Builder => $query
                ->whereDate(static::dateColumn($column), $operator, $date)
                ->orWhereNull(static::dateColumn($column))
        );
    }
}
