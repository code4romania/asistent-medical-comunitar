<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Models\Intervention;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait MorphsIntervention
{
    public function intervention(): MorphOne
    {
        return $this->morphOne(Intervention::class, 'interventionable');
    }
}
