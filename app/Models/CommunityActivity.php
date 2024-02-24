<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\CommunityActivityType;
use App\Enums\User\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class CommunityActivity extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'type',
        'name',
        'date',
        'outside_working_hours',
        'location',
        'organizer',
        'participants',
        'notes',
    ];

    protected $casts = [
        'type' => CommunityActivityType::class,
        'outside_working_hours' => 'boolean',
        'participants' => 'integer',
        'date' => 'date',
    ];

    public static function booted(): void
    {
        static::addGlobalScope('forCurrentUser', function (Builder $query) {
            if (! auth()->check()) {
                return $query;
            }

            return match (auth()->user()->role) {
                Role::COORDINATOR => $query->where('county_id', auth()->user()->county_id),
                Role::NURSE => $query->where('county_id', auth()->user()->activity_county_id),
                default => $query,
            };
        });

        static::creating(function (self $activity) {
            if (! auth()->check()) {
                return;
            }

            $activity->county_id = match (auth()->user()->role) {
                Role::COORDINATOR => auth()->user()->county_id,
                Role::NURSE => auth()->user()->activity_county_id,
                default => null,
            };
        });
    }

    public function county(): BelongsTo
    {
        return $this->belongsTo(County::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('participants_list')
            ->singleFile();
    }

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

    // public function scopeForCurrentUser(Builder $query): Builder
    // {
    //     if (auth()->user()->isAdmin()) {
    //         return $query;
    //     }

    //     if (auth()->user()->isCoordinator()) {
    //         return $query->where('county_id', auth()->user()->county_id);
    //     }

    //     if (auth()->user()->isNurse()) {
    //         return $query->where('county_id', auth()->user()->activity_county_id);
    //     }
    // }

    public function getHourAttribute(): string
    {
        return $this->outside_working_hours
            ? __('community_activity.hour.outside_working_hours')
            : __('community_activity.hour.within_working_hours');
    }

    public function getTitleAttribute(): string
    {
        return $this->name . ' ' . $this->date->toFormattedDate();
    }
}
