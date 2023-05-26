<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\CommunityActivityType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'name',
        'date',
        'outside_working_hours',
        'location',
        'organizer',
        'participants',
        'participants_list',
        'notes',
    ];

    protected $casts = [
        'type' => CommunityActivityType::class,
        'outside_working_hours' => 'boolean',
        'participants' => 'integer',
        'date' => 'date',
    ];

    public function scopeOnlyCampaigns(Builder $query): Builder
    {
        return $query->where('type', CommunityActivityType::CAMPAIGN);
    }

    public function scopeOnlyEnvironmentActivities(Builder $query): Builder
    {
        return $query->where('type', CommunityActivityType::ENVIRONMENT);
    }

    public function scopeOnlyAdministrativeActivities(Builder $query): Builder
    {
        return $query->where('type', CommunityActivityType::ADMINISTRATIVE);
    }

    public function getHourAttribute(): string
    {
        return $this->outside_working_hours
            ? __('community_activity.hour.outside_working_hours')
            : __('community_activity.hour.within_working_hours');
    }
}
