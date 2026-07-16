<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Models\City;
use App\Models\County;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasActivityAreas
{
    public function initializeHasActivityAreas(): void
    {
        $this->fillable = array_merge($this->fillable, ['activity_county_id']);
    }

    public function activityCounty(): BelongsTo
    {
        return $this->belongsTo(County::class, 'activity_county_id');
    }

    public function activityCities(): BelongsToMany
    {
        return $this->belongsToMany(City::class, 'profile_activity_areas', 'user_id', 'city_id');
    }

    public function scopeActivatesInCounty(Builder $query, int $county_id): Builder
    {
        return $query->where('activity_county_id', $county_id);
    }

    public function scopeActivatesInCurrentUserCounty(Builder $query): Builder
    {
        return $query->where('activity_county_id', auth()->user()->activity_county_id ?? auth()->user()->county_id);
    }

    public function scopeWithActivityAreas(Builder $query): Builder
    {
        return $query->with('activityCounty', 'activityCities');
    }
}
