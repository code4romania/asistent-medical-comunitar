<?php

declare(strict_types=1);

namespace App\Reports\Queries;

use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Models\Report;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class ReportQuery
{
    abstract public static function query(): Builder;

    public static function dateColumn(): string
    {
        return 'activity_log.created_at';
    }

    public static function aggregateByColumn(): string
    {
        return 'id';
    }

    public static function includeLatestBeforeRange(): bool
    {
        return true;
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

    public static function build(Report $report): Builder
    {
        $query = static::query()
            ->forUser($report->user)
            ->select(static::selectColumns())
            ->tap([static::class, 'tapQuery']);

        if (! $report->date_until) {
            return $query->whereDate(static::dateColumn(), '=', $report->date_from);
        }

        if (static::includeLatestBeforeRange()) {
            $union = $query->clone()
                ->whereDate(static::dateColumn(), '<', $report->date_from)
                ->latest('activity_log.created_at')
                ->limit(1);
        }

        return $query
            ->whereDate(static::dateColumn(), '>=', $report->date_from)
            ->whereDate(static::dateColumn(), '<=', $report->date_until)
            ->when(isset($union), fn (Builder $q) => $q->union($union));
    }

    public static function aggregate(Report $report): int
    {
        return static::build($report)
            ->distinct(static::aggregateByColumn())
            ->count(static::aggregateByColumn());
    }
}
