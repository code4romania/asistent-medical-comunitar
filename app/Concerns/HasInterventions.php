<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Models\Intervention;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasInterventions
{
    public function interventions(): HasMany
    {
        return $this->hasMany(Intervention::class);
    }
}
