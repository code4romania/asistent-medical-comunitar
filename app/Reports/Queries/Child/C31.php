<?php

declare(strict_types=1);

namespace App\Reports\Queries\Child;

use App\Enums\CommunityActivity\Campaign;
use App\Models\CommunityActivity;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Tpetry\QueryExpressions\Language\Alias;

/**
 * Sum activități comunitare Campanii sănătate and tip=Triaj epidemiologic.
 */
class C31 extends ReportQuery
{
    public static function query(): Builder
    {
        return CommunityActivity::query()
            ->leftJoin('users', 'community_activities.nurse_id', '=', 'users.id')
            ->whereCampaign(Campaign::EPIDEM_TRIAGE);
    }

    public static function dateColumn(string $type): string
    {
        return 'community_activities.created_at';
    }

    public static function aggregateByColumn(): string
    {
        return 'community_activities.id';
    }

    public static function includeLatestBeforeRange(): bool
    {
        return false;
    }

    public static function selectColumns(): array
    {
        return collect(static::columns())
            ->keys()
            ->map(fn (string $key) => match ($key) {
                'id' => 'community_activities.id',
                default => $key,
            })
            ->all();
    }

    public static function columns(): array
    {
        return [
            'id' => __('field.id'),
            'subtype' => __('field.type'),
            'name' => __('field.activity'),
            'date' => __('field.date'),
            'outside_working_hours' => __('field.outside_working_hours'),
            'location' => __('field.location'),
            'organizer' => __('field.organizer'),
            'participants' => __('field.participants'),
            'roma_participants' => __('field.roma_participants'),
        ];
    }

    public static function tapQuery(Builder $query): Builder
    {
        return $query->addSelect([
            'nurse_id',
            'type',
            new Alias('activity_county_id', 'county_id'),
        ]);
    }

    /**
     * There's currently no community activity dedicated page.
     */
    public static function recordActionUrl(Model $record): ?string
    {
        return null;
    }
}
