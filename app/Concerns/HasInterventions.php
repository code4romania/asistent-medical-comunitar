<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Models\Intervention\IndividualService;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasInterventions
{
    public function interventions(): HasMany
    {
        return $this->hasMany(IndividualService::class)
            ->withoutCase();
    }
}
