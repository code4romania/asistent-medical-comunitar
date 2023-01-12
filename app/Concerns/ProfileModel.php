<?php

namespace App\Concerns;

use App\Models\City;
use App\Models\County;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait ProfileModel
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
    public function county(): BelongsTo
    {
        return $this->belongsTo(County::class);
    }
}
