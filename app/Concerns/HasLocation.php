<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Models\City;
use App\Models\County;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasLocation
{
    public function initializeHasLocation(): void
    {
        $this->fillable = array_merge($this->fillable, ['county_id', 'city_id']);
    }

    public function county(): BelongsTo
    {
        return $this->belongsTo(County::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function scopeWithLocation(Builder $query): Builder
    {
        return $query->with('county', 'city');
    }
}
