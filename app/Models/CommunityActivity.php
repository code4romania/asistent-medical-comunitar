<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\BelongsToNurse;
use App\Enums\CommunityActivity\Type;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class CommunityActivity extends Model implements HasMedia
{
    use BelongsToNurse;
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
        'type' => Type::class,
        'outside_working_hours' => 'boolean',
        'participants' => 'integer',
        'date' => 'date',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('participants_list')
            ->singleFile();
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
}
