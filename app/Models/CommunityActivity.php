<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\BelongsToNurse;
use App\Enums\CommunityActivity\Administrative;
use App\Enums\CommunityActivity\Campaign;
use App\Enums\CommunityActivity\Type;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class CommunityActivity extends Model implements HasMedia
{
    use BelongsToNurse;
    use HasFactory;
    use InteractsWithMedia;
    use LogsActivity;

    protected $fillable = [
        'type',
        'subtype',
        'name',
        'date',
        'outside_working_hours',
        'location',
        'organizer',
        'participants',
        'roma_participants',
        'notes',
    ];

    protected $casts = [
        'type' => Type::class,
        'outside_working_hours' => 'boolean',
        'participants' => 'integer',
        'roma_participants' => 'integer',
        'date' => 'date',
    ];

    public static function booted(): void
    {
        static::creating(function (self $communityActivity) {
            if (! auth()->check()) {
                return;
            }

            if (! auth()->user()->isNurse()) {
                return;
            }

            $communityActivity->nurse_id = auth()->id();
        });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('participants_list')
            ->singleFile();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->dontSubmitEmptyLogs()
            ->logFillable()
            ->logOnlyDirty();
    }

    public function scopeOnlyCampaigns(Builder $query): Builder
    {
        return $query->where('type', Type::CAMPAIGN);
    }

    public function scopeOnlyAdministrativeActivities(Builder $query): Builder
    {
        return $query->where('type', Type::ADMINISTRATIVE);
    }

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

    public function getSubtypeAttribute(?string $value): Campaign | Administrative | null
    {
        $enum = match ($this->type) {
            Type::CAMPAIGN => Campaign::class,
            Type::ADMINISTRATIVE => Administrative::class,
            default => null,
        };

        if (! $enum || ! $value) {
            return null;
        }

        return $enum::tryFrom($value);
    }
}
