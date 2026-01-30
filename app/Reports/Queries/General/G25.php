<?php

declare(strict_types=1);

namespace App\Reports\Queries\General;

use App\Enums\CommunityActivity\Campaign;
use App\Models\CommunityActivity;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class G25 extends ReportQuery
{
    /**
     * Sum activități comunitare Campanii sănătate and tip=Anunțare pentru screening populațional.
     */
    public static function query(): Builder
    {
        return CommunityActivity::query()
            ->whereCampaign(Campaign::SCREENING);
    }

    public static function dateColumn(): string
    {
        return 'created_at';
    }

    public static function includeLatestBeforeRange(): bool
    {
        return false;
    }

    public static function selectColumns(): array
    {
        return array_keys(static::columns());
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
